<?php
declare(strict_types=1);

namespace Core;

/**
 * Authentication and Role-Based Access Control (RBAC).
 * Supports Super Admin, Admin, Editor, and Branch Manager roles.
 */
class Auth
{
    private const SESSION_USER_KEY = '_auth_user_id';
    private static ?array $cachedUser = null;

    public static function attempt(string $usernameOrEmail, string $password): bool
    {
        Session::start();

        // Check login throttling
        $attemptsKey = '_login_attempts_' . md5($usernameOrEmail);
        $attempts = Session::get($attemptsKey, 0);
        $lockoutKey = '_login_lockout_' . md5($usernameOrEmail);
        $lockoutTime = Session::get($lockoutKey, 0);

        if ($lockoutTime > time()) {
            Session::flash('error', __('Too many failed login attempts. Please try again in :sec seconds.', 'നിരവധി തവണ പരാജയപ്പെട്ടു. ദയവായി :sec സെക്കൻഡുകൾക്ക് ശേഷം വീണ്ടും ശ്രമിക്കുക.', ['sec' => $lockoutTime - time()]));
            return false;
        }

        try {
            $user = Database::fetchOne(
                "SELECT u.*, r.slug as role_slug, r.name as role_name 
                 FROM users u 
                 LEFT JOIN roles r ON u.role_id = r.id 
                 WHERE (u.email = ? OR u.username = ?) AND u.status = 'active' 
                 LIMIT 1",
                [$usernameOrEmail, $usernameOrEmail]
            );

            if ($user && password_verify($password, $user['password_hash'])) {
                // Reset throttle counters
                Session::remove($attemptsKey);
                Session::remove($lockoutKey);

                // Regenerate session to prevent fixation
                Session::regenerate(true);
                Session::set(self::SESSION_USER_KEY, (int)$user['id']);
                self::$cachedUser = $user;

                // Update last login timestamp
                Database::execute("UPDATE users SET last_login_at = NOW(), last_login_ip = ? WHERE id = ?", [
                    (new Request())->ip(),
                    $user['id']
                ]);

                // Record audit log
                self::logAudit('auth.login', 'User logged in: ' . $user['username'], (int)$user['id']);

                return true;
            }
        } catch (\Throwable $e) {
            error_log('Auth error: ' . $e->getMessage());
        }

        // Increment failed attempts
        $attempts++;
        Session::set($attemptsKey, $attempts);
        if ($attempts >= 5) {
            Session::set($lockoutKey, time() + 300); // 5 min lockout
            Session::remove($attemptsKey);
        }

        return false;
    }

    public static function check(): bool
    {
        Session::start();
        return Session::has(self::SESSION_USER_KEY);
    }

    public static function id(): ?int
    {
        Session::start();
        $id = Session::get(self::SESSION_USER_KEY);
        return $id ? (int)$id : null;
    }

    public static function user(): ?array
    {
        if (self::$cachedUser !== null) {
            return self::$cachedUser;
        }

        $id = self::id();
        if (!$id) {
            return null;
        }

        try {
            $user = Database::fetchOne(
                "SELECT u.*, r.slug as role_slug, r.name as role_name 
                 FROM users u 
                 LEFT JOIN roles r ON u.role_id = r.id 
                 WHERE u.id = ? AND u.status = 'active' 
                 LIMIT 1",
                [$id]
            );

            if ($user) {
                self::$cachedUser = $user;
                return $user;
            }
        } catch (\Throwable $e) {
            // DB error
        }

        self::logout();
        return null;
    }

    public static function hasRole(string|array $roles): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        $userRole = $user['role_slug'] ?? '';
        if ($userRole === 'super_admin') {
            return true; // Super admin possesses all roles
        }

        if (is_array($roles)) {
            return in_array($userRole, $roles, true);
        }

        return $userRole === $roles;
    }

    public static function branchId(): ?int
    {
        $user = self::user();
        if (!$user) {
            return null;
        }
        return !empty($user['branch_id']) ? (int)$user['branch_id'] : null;
    }

    public static function isBranchManager(): bool
    {
        $user = self::user();
        return ($user['role_slug'] ?? '') === 'branch_manager';
    }

    public static function logout(): void
    {
        $id = self::id();
        if ($id) {
            self::logAudit('auth.logout', 'User logged out', $id);
        }

        self::$cachedUser = null;
        Session::remove(self::SESSION_USER_KEY);
        Session::destroy();
    }

    public static function logAudit(string $action, string $details = '', ?int $userId = null): void
    {
        try {
            $uid = $userId ?? self::id();
            $ip = (new Request())->ip();
            Database::execute(
                "INSERT INTO audit_log (user_id, action, details, ip_address, created_at) 
                 VALUES (?, ?, ?, ?, NOW())",
                [$uid, $action, $details, $ip]
            );
        } catch (\Throwable $e) {
            // Silently continue if audit log table not ready yet
        }
    }
}
