<?php
declare(strict_types=1);

namespace Core;

/**
 * Unified Settings Repository.
 * Merges client static config with database settings and
 * maintains a high-performance JSON cache in /storage/cache.
 */
class Settings
{
    private static string $clientSlug = 'kalliaseri-scb';
    private static array $data = [];
    private static bool $loaded = false;

    public static function init(string $clientSlug): void
    {
        self::$clientSlug = $clientSlug;
        self::load();
    }

    public static function load(bool $forceRefresh = false): void
    {
        $cacheDir = dirname(__DIR__) . '/storage/cache';
        $cacheFile = $cacheDir . '/settings_' . self::$clientSlug . '.json';

        if (!$forceRefresh && file_exists($cacheFile)) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            if (is_array($cached)) {
                self::$data = $cached;
                self::$loaded = true;
                return;
            }
        }

        // 1. Load client static config file
        $baseDir = dirname(__DIR__);
        $configFile = $baseDir . '/clients/' . self::$clientSlug . '/config.php';
        $fileConfig = [];
        if (file_exists($configFile)) {
            $fileConfig = include $configFile;
            if (!is_array($fileConfig)) {
                $fileConfig = [];
            }
        }

        // 2. Query database settings if DB is available
        $dbSettings = [];
        try {
            $rows = Database::fetchAll("SELECT `key`, `value` FROM settings WHERE client_slug = ? OR client_slug IS NULL", [self::$clientSlug]);
            foreach ($rows as $row) {
                $key = $row['key'];
                $val = $row['value'];
                // Decode JSON values if applicable
                $decoded = json_decode($val, true);
                $dbSettings[$key] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : $val;
            }
        } catch (\Throwable $e) {
            // DB might not be seeded or connected yet, fallback gracefully
        }

        // 3. Deep merge: DB settings override file settings
        self::$data = array_replace_recursive($fileConfig, $dbSettings);
        self::$loaded = true;

        // 4. Save to cache
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        @file_put_contents($cacheFile, json_encode(self::$data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (!self::$loaded) {
            self::load();
        }

        if (array_key_exists($key, self::$data)) {
            return self::$data[$key];
        }

        // Support dot notation like 'legal.entity_type' or 'contact.phone'
        $segments = explode('.', $key);
        $current = self::$data;
        foreach ($segments as $segment) {
            if (is_array($current) && array_key_exists($segment, $current)) {
                $current = $current[$segment];
            } else {
                return $default;
            }
        }

        return $current;
    }

    public static function all(): array
    {
        if (!self::$loaded) {
            self::load();
        }
        return self::$data;
    }

    public static function isModuleEnabled(string $module): bool
    {
        $modules = self::get('enabled_modules', []);
        return in_array($module, $modules, true);
    }

    public static function clientSlug(): string
    {
        return self::$clientSlug;
    }

    public static function clearCache(): void
    {
        $cacheFile = dirname(__DIR__) . '/storage/cache/settings_' . self::$clientSlug . '.json';
        if (file_exists($cacheFile)) {
            @unlink($cacheFile);
        }
        self::$loaded = false;
        self::load(true);
    }

    public static function set(string $key, mixed $value): void
    {
        $storedValue = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string)$value;

        // Upsert into database
        $sql = "INSERT INTO settings (client_slug, `key`, `value`, updated_at) 
                VALUES (?, ?, ?, NOW()) 
                ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), updated_at = NOW()";

        // SQLite compatibility
        if (($_ENV['DB_DRIVER'] ?? 'mysql') === 'sqlite') {
            $sql = "INSERT INTO settings (client_slug, `key`, `value`, updated_at) 
                    VALUES (?, ?, ?, datetime('now'))
                    ON CONFLICT(client_slug, `key`) DO UPDATE SET `value`=excluded.`value`, updated_at=excluded.updated_at";
        }

        try {
            Database::execute($sql, [self::$clientSlug, $key, $storedValue]);
        } catch (\Throwable $e) {
            // DB fallback
        }

        self::clearCache();
    }
}
