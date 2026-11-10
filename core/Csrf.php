<?php
declare(strict_types=1);

namespace Core;

/**
 * CSRF Protection with timing-safe comparison,
 * HTML input generators, and header support.
 */
class Csrf
{
    private const SESSION_KEY = '_csrf_token';
    private const TOKEN_LENGTH = 32;

    public static function token(): string
    {
        Session::start();
        $token = Session::get(self::SESSION_KEY);

        if (!$token || !is_string($token)) {
            $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
            Session::set(self::SESSION_KEY, $token);
        }

        return $token;
    }

    public static function field(): string
    {
        $token = self::token();
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validate(Request $request): bool
    {
        $token = $request->input('_csrf_token') ?? $request->header('x-csrf-token');

        if (!$token || !is_string($token)) {
            return false;
        }

        $storedToken = Session::get(self::SESSION_KEY);
        if (!$storedToken || !is_string($storedToken)) {
            return false;
        }

        return hash_equals($storedToken, $token);
    }

    public static function regenerate(): string
    {
        Session::start();
        $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
        Session::set(self::SESSION_KEY, $token);
        return $token;
    }
}
