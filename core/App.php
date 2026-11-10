<?php
declare(strict_types=1);

namespace Core;

/**
 * Application Kernel.
 * Orchestrates environment variables, multi-client resolution,
 * session, i18n, theme engine, database, and router dispatch.
 */
class App
{
    private static ?string $activeClient = null;
    private static ?ThemeEngine $themeEngine = null;
    private static ?Router $router = null;

    public static function boot(?string $client = null): void
    {
        // 1. Load environment file
        self::loadEnv();

        // 2. Start session
        Session::start();

        // 3. Resolve active client
        self::$activeClient = $client ?? self::resolveClient();

        // 4. Initialize Settings
        Settings::init(self::$activeClient);

        // 5. Initialize Theme Engine
        $dbTheme = Settings::get('theme', []);
        self::$themeEngine = new ThemeEngine(self::$activeClient, is_array($dbTheme) ? $dbTheme : []);

        // 6. Share core variables to all views
        self::registerGlobalViewData();
    }

    private static function loadEnv(): void
    {
        $envFile = dirname(__DIR__) . '/.env';
        if (!file_exists($envFile)) {
            $exampleEnv = dirname(__DIR__) . '/.env.example';
            if (file_exists($exampleEnv)) {
                copy($exampleEnv, $envFile);
            } else {
                return;
            }
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (str_contains($line, '=')) {
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val);
                $val = trim($val, "\"'");
                if (!isset($_ENV[$key])) {
                    $_ENV[$key] = $val;
                    putenv("{$key}={$val}");
                }
            }
        }
    }

    private static function resolveClient(): string
    {
        // Priority 1: Domain-based resolution if mapping defined
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $domainMap = [
            'periyar.local' => 'periyar-scs',
            'kalliaseri.local' => 'kalliaseri-scb',
        ];

        if (isset($domainMap[$host])) {
            return $domainMap[$host];
        }

        // Priority 2: Environment variable CLIENT
        if (!empty($_ENV['CLIENT'])) {
            return $_ENV['CLIENT'];
        }

        // Default client
        return 'kalliaseri-scb';
    }

    private static function registerGlobalViewData(): void
    {
        View::share([
            'client_slug' => self::$activeClient,
            'client_config' => Settings::all(),
            'theme_tokens' => self::$themeEngine->getTokens(),
            'theme_layout' => self::$themeEngine->getLayout(),
            'theme_css' => self::$themeEngine->generateCssVariables(),
            'settings' => Settings::all(),
            'legal_profile' => Settings::get('legal', []),
            'contact_info' => Settings::get('contact', []),
            'social_links' => Settings::get('social', []),
            'app_url' => rtrim($_ENV['APP_URL'] ?? '', '/'),
        ]);
    }

    public static function run(): void
    {
        self::boot();

        $request = Request::capture();

        // Initialize i18n with URL language prefix if present
        I18n::init(self::$activeClient, $request->getLang());

        // Update shared lang in View
        View::share([
            'current_lang' => I18n::currentLang(),
            'is_malayalam' => I18n::isMalayalam(),
        ]);

        // Load application routes
        $router = new Router();
        self::$router = $router;

        require dirname(__DIR__) . '/app/routes.php';

        // Dispatch request
        $response = $router->dispatch($request);
        $response->send();
    }

    public static function getClient(): string
    {
        return self::$activeClient ?? 'kalliaseri-scb';
    }

    public static function getThemeEngine(): ThemeEngine
    {
        return self::$themeEngine;
    }

    public static function getRouter(): Router
    {
        return self::$router;
    }
}
