<?php
declare(strict_types=1);

/**
 * Services Co-operative Bank Website Template
 * Front Controller
 */

// If running via PHP CLI built-in webserver, serve static files directly
if (php_sapi_name() === 'cli-server') {
    $uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
    $file = __DIR__ . $uriPath;
    if ($uriPath !== '/' && $uriPath !== '' && file_exists($file) && !is_dir($file)) {
        return false;
    }
    if (str_starts_with($uriPath, '/clients/')) {
        $clientFile = dirname(__DIR__) . $uriPath;
        if (file_exists($clientFile) && !is_dir($clientFile)) {
            $ext = strtolower(pathinfo($clientFile, PATHINFO_EXTENSION));
            $mimes = [
                'css' => 'text/css',
                'js' => 'application/javascript',
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'svg' => 'image/svg+xml',
                'webp' => 'image/webp',
                'ico' => 'image/x-icon',
                'woff2' => 'font/woff2',
                'woff' => 'font/woff',
                'ttf' => 'font/ttf',
            ];
            header('Content-Type: ' . ($mimes[$ext] ?? 'application/octet-stream'));
            readfile($clientFile);
            exit;
        }
    }
}

// Define directory constants
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('CORE_DIR', ROOT_DIR . '/core');
define('PUBLIC_DIR', __DIR__);
define('STORAGE_DIR', ROOT_DIR . '/storage');

// Register Composer Autoloader
$autoloader = ROOT_DIR . '/vendor/autoload.php';
if (!file_exists($autoloader)) {
    die("Autoloader not found. Please run 'composer install' or 'composer dump-autoload'.");
}
require_once $autoloader;

// Error and Exception Handling
set_exception_handler(function (\Throwable $e) {
    error_log("Unhandled Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());

    $debug = ($_ENV['APP_DEBUG'] ?? 'false') === 'true';

    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: text/html; charset=UTF-8');
    }

    if ($debug) {
        echo "<!DOCTYPE html><html><head><title>500 Internal Error</title>";
        echo "<style>body{font-family:sans-serif;background:#fff5f5;color:#991b1b;padding:2rem;}pre{background:#fee2e2;padding:1rem;border-radius:4px;overflow:auto;}</style></head><body>";
        echo "<h1>Application Error: " . htmlspecialchars($e->getMessage()) . "</h1>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (line " . $e->getLine() . ")</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "</body></html>";
    } else {
        $errorPage = APP_DIR . '/Views/errors/500.php';
        if (file_exists($errorPage)) {
            include $errorPage;
        } else {
            echo "<h1>500 Internal Server Error</h1><p>An unexpected error occurred. Please try again later.</p>";
        }
    }
    exit(1);
});

// Run Application
\Core\App::run();
