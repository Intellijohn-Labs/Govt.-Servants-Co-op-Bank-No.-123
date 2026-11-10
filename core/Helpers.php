<?php
declare(strict_types=1);

use Core\I18n;
use Core\Csrf;
use Core\Settings;
use Core\Auth;
use Core\Session;

if (!function_exists('__')) {
    function __(string $key, ?string $fallback = null, array $replace = []): string
    {
        return I18n::get($key, $fallback, $replace);
    }
}

if (!function_exists('bank_name')) {
    /** Public institution name in the active language (falls back to English). */
    function bank_name(): string
    {
        $en = (string)Settings::get('legal.approved_public_name', '');
        if (I18n::isMalayalam()) {
            $ml = (string)Settings::get('legal.approved_public_name_ml', '');
            if ($ml !== '') {
                return $ml;
            }
        }
        return $en;
    }
}

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('url')) {
    function url(string $path = '/', ?string $lang = null): string
    {
        return I18n::url($path, $lang);
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $url = '/' . ltrim($path, '/');
        // Append a content hash so browsers/CDNs never serve a stale stylesheet or script
        // (skips big files such as the intro video).
        $publicDir = defined('PUBLIC_DIR') ? PUBLIC_DIR : dirname(__DIR__) . '/public';
        $file = $publicDir . $url;
        if (is_file($file) && filesize($file) < 1048576) {
            return $url . '?v=' . substr(md5_file($file), 0, 8);
        }
        return $url;
    }
}

if (!function_exists('client_asset')) {
    function client_asset(string $path): string
    {
        $slug = Settings::clientSlug();
        return "/clients/{$slug}/assets/" . ltrim($path, '/');
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return Csrf::token();
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return Csrf::field();
    }
}

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Settings::get($key, $default);
    }
}

if (!function_exists('module_enabled')) {
    function module_enabled(string $module): bool
    {
        return Settings::isModuleEnabled($module);
    }
}

if (!function_exists('current_lang')) {
    function current_lang(): string
    {
        return I18n::currentLang();
    }
}

if (!function_exists('is_malayalam')) {
    function is_malayalam(): bool
    {
        return I18n::isMalayalam();
    }
}

if (!function_exists('client_slug')) {
    function client_slug(): string
    {
        return Settings::clientSlug();
    }
}

if (!function_exists('auth_user')) {
    function auth_user(): ?array
    {
        return Auth::user();
    }
}

if (!function_exists('auth_check')) {
    function auth_check(): bool
    {
        return Auth::check();
    }
}

if (!function_exists('has_role')) {
    function has_role(string|array $role): bool
    {
        return Auth::hasRole($role);
    }
}

if (!function_exists('flash')) {
    function flash(string $key, mixed $default = null): mixed
    {
        return Session::getFlash($key, $default);
    }
}

if (!function_exists('old')) {
    function old(string $key, mixed $default = ''): mixed
    {
        $old = Session::get('_old_input', []);
        return $old[$key] ?? $default;
    }
}

if (!function_exists('format_currency')) {
    function format_currency(float|int|string|null $amount): string
    {
        if ($amount === null || $amount === '') {
            return '₹ 0';
        }

        $num = (float)$amount;
        $formatted = number_format($num, 2);

        // Indian numbering format (lakhs, crores)
        $parts = explode('.', $formatted);
        $intPart = $parts[0];
        $decPart = $parts[1];

        $len = strlen($intPart);
        if ($len > 3) {
            $lastThree = substr($intPart, $len - 3);
            $rest = substr($intPart, 0, $len - 3);
            $restFormatted = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
            $intPart = $restFormatted . ',' . $lastThree;
        }

        return ($decPart === '00') ? "₹ {$intPart}" : "₹ {$intPart}.{$decPart}";
    }
}

if (!function_exists('format_date')) {
    function format_date(?string $date, string $format = 'd M Y'): string
    {
        if (!$date) {
            return '';
        }
        $timestamp = strtotime($date);
        return $timestamp ? date($format, $timestamp) : $date;
    }
}

if (!function_exists('mask_pan')) {
    function mask_pan(?string $pan): string
    {
        if (!$pan || strlen($pan) < 10) {
            return (string)$pan;
        }
        // Retain only last 4 digits, mask first 5 and last letter or standard mask
        return substr($pan, 0, 2) . 'XXXXXX' . substr($pan, -2);
    }
}
