<?php
declare(strict_types=1);

namespace Core;

/**
 * Multi-language manager supporting English ('en') and Malayalam ('ml').
 * Handles prefix routing (/ml/...), translation lookups, fallback chains,
 * and hreflang tag generation.
 */
class I18n
{
    private static string $currentLang = 'en';
    private static string $defaultLang = 'en';
    private static array $supportedLangs = ['en' => 'English', 'ml' => 'മലയാളം'];
    private static array $translations = [];
    private static string $activeClient = 'kalliaseri-scb';

    public static function init(string $client, ?string $urlLang = null): void
    {
        self::$activeClient = $client;

        $getLang = $_GET['lang'] ?? null;
        if ($getLang && isset(self::$supportedLangs[$getLang])) {
            self::$currentLang = $getLang;
            Session::set('_lang', $getLang);
        } elseif ($urlLang && isset(self::$supportedLangs[$urlLang])) {
            self::$currentLang = $urlLang;
            Session::set('_lang', $urlLang);
        } else {
            // If URL has no language prefix, always default to English
            self::$currentLang = self::$defaultLang;
            Session::set('_lang', self::$defaultLang);
        }

        self::loadTranslations();
    }

    public static function setClient(string $client): void
    {
        self::$activeClient = $client;
        self::loadTranslations();
    }

    public static function setDefaultLang(string $lang): void
    {
        if (isset(self::$supportedLangs[$lang])) {
            self::$defaultLang = $lang;
        }
    }

    public static function setLang(string $lang): void
    {
        if (isset(self::$supportedLangs[$lang])) {
            self::$currentLang = $lang;
            Session::set('_lang', $lang);
            self::loadTranslations();
        }
    }

    public static function currentLang(): string
    {
        return self::$currentLang;
    }

    public static function isMalayalam(): bool
    {
        return self::$currentLang === 'ml';
    }

    public static function defaultLang(): string
    {
        return self::$defaultLang;
    }

    public static function supportedLangs(): array
    {
        return self::$supportedLangs;
    }

    private static function loadTranslations(): void
    {
        self::$translations = [];
        $baseDir = dirname(__DIR__);

        // 1. Load client language dictionary
        $clientLangFile = $baseDir . '/clients/' . self::$activeClient . '/lang/' . self::$currentLang . '.php';
        if (file_exists($clientLangFile)) {
            $data = include $clientLangFile;
            if (is_array($data)) {
                self::$translations = array_merge(self::$translations, $data);
            }
        }

        // 2. Also load default fallback language if current is not default
        if (self::$currentLang !== 'en') {
            $clientEnFile = $baseDir . '/clients/' . self::$activeClient . '/lang/en.php';
            if (file_exists($clientEnFile)) {
                $enData = include $clientEnFile;
                if (is_array($enData)) {
                    foreach ($enData as $k => $v) {
                        if (!isset(self::$translations[$k])) {
                            self::$translations[$k] = $v;
                        }
                    }
                }
            }
        }
    }

    public static function get(string $key, ?string $fallback = null, array $replace = []): string
    {
        if (isset(self::$translations[$key])) {
            $text = self::$translations[$key];
        } elseif ($fallback !== null && preg_match('/\p{Malayalam}/u', $fallback) && !preg_match('/\p{Malayalam}/u', $key)) {
            // Inline bilingual call: __('English text', 'മലയാളം') -> pick by active language
            $text = self::isMalayalam() ? $fallback : $key;
        } else {
            $text = $fallback ?? $key;
        }

        if (!empty($replace)) {
            foreach ($replace as $placeholder => $value) {
                $text = str_replace(':' . $placeholder, (string)$value, $text);
            }
        }

        return $text;
    }

    /**
     * Translates a bilingual database field (e.g. ['name_en', 'name_ml'])
     */
    public static function field(array|object $row, string $fieldBase): string
    {
        $lang = self::$currentLang;
        $key = "{$fieldBase}_{$lang}";

        if (is_array($row)) {
            if (!empty($row[$key])) {
                return (string)$row[$key];
            }
            return (string)($row["{$fieldBase}_en"] ?? $row[$fieldBase] ?? '');
        }

        if (is_object($row)) {
            if (!empty($row->$key)) {
                return (string)$row->$key;
            }
            $enKey = "{$fieldBase}_en";
            return (string)($row->$enKey ?? $row->$fieldBase ?? '');
        }

        return '';
    }

    /**
     * Generates a localized URL for the current or specified path.
     */
    public static function url(string $path = '/', ?string $targetLang = null): string
    {
        $lang = $targetLang ?? self::$currentLang;
        $cleanPath = '/' . ltrim($path, '/');

        // If target language is Malayalam, prepend /ml
        if ($lang === 'ml') {
            return '/ml' . ($cleanPath === '/' ? '' : $cleanPath);
        }

        return $cleanPath;
    }

    /**
     * Returns alternate hreflang tags for SEO
     */
    public static function hreflangTags(string $path = '/'): string
    {
        $cleanPath = '/' . ltrim($path, '/');
        $baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');

        $html = '<link rel="alternate" hreflang="en" href="' . htmlspecialchars($baseUrl . $cleanPath, ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        $html .= '<link rel="alternate" hreflang="ml" href="' . htmlspecialchars($baseUrl . '/ml' . ($cleanPath === '/' ? '' : $cleanPath), ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        $html .= '<link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($baseUrl . $cleanPath, ENT_QUOTES, 'UTF-8') . '" />';

        return $html;
    }
}
