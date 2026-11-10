<?php
declare(strict_types=1);

/**
 * Minimal PSR-4 autoloader mirroring composer.json.
 * build.sh copies this to <workspace>/vendor/autoload.php so the static export
 * works on build machines without Composer (e.g. Vercel). Not used for normal
 * development, which keeps using Composer's vendor/autoload.php.
 */
spl_autoload_register(static function (string $class): void {
    static $map = [
        'Core\\' => 'core/',
        'App\\' => 'app/',
        'Modules\\' => 'modules/',
        'Database\\' => 'database/',
    ];
    $root = dirname(__DIR__); // vendor/autoload.php -> project root
    foreach ($map as $prefix => $dir) {
        if (str_starts_with($class, $prefix)) {
            $file = $root . '/' . $dir . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
            if (is_file($file)) {
                require_once $file;
            }
            return;
        }
    }
});

require_once dirname(__DIR__) . '/core/Helpers.php';
