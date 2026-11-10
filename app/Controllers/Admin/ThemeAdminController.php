<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Settings;
use Core\Session;
use Core\ThemeEngine;

class ThemeAdminController
{
    public function index(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $themeEngine = new ThemeEngine($clientSlug);
        $tokens = $themeEngine->getTokens();
        $contrast = ThemeEngine::checkContrast($tokens['--primary-contrast'] ?? '#FFFFFF', $tokens['--primary'] ?? '#0A4D92');

        $activeTheme = [
            'primary' => $tokens['--primary'] ?? '#0A4D92',
            'primary_contrast' => $tokens['--primary-contrast'] ?? '#FFFFFF',
            'secondary' => $tokens['--secondary'] ?? '#1E88E5',
            'accent' => $tokens['--accent'] ?? '#D97706',
            'footer_bg' => $tokens['--footer-bg'] ?? '#0A2540',
        ];

        $presets = [
            'royal-blue' => [
                'name' => 'Royal Blue & Gold (Trust & Stability)',
                'primary' => '#0A4D92',
                'primary_contrast' => '#FFFFFF',
                'secondary' => '#1E88E5',
                'accent' => '#D97706',
            ],
            'emerald-green' => [
                'name' => 'Emerald Green & Warm Amber (Agriculture & Society)',
                'primary' => '#0F766E',
                'primary_contrast' => '#FFFFFF',
                'secondary' => '#059669',
                'accent' => '#D97706',
            ],
            'maroon-gold' => [
                'name' => 'Maroon & Deep Gold (Heritage & Tradition)',
                'primary' => '#7F1D1D',
                'primary_contrast' => '#FFFFFF',
                'secondary' => '#991B1B',
                'accent' => '#D97706',
            ],
            'teal-orange' => [
                'name' => 'Teal & Vibrant Orange (Modern Community)',
                'primary' => '#0D9488',
                'primary_contrast' => '#FFFFFF',
                'secondary' => '#14B8A6',
                'accent' => '#EA580C',
            ],
            'charcoal-amber' => [
                'name' => 'Charcoal & Amber (Contemporary Financial)',
                'primary' => '#1E293B',
                'primary_contrast' => '#FFFFFF',
                'secondary' => '#334155',
                'accent' => '#F59E0B',
            ],
        ];

        $response = new Response();
        return $response->view('admin/theme', [
            'title' => 'Theme Customization & WCAG Contrast',
            'activeNav' => 'theme',
            'activeTheme' => $activeTheme,
            'contrast' => $contrast,
            'presets' => $presets,
        ], 'admin');
    }

    public function applyPreset(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $preset = trim((string)$request->input('preset', 'royal-blue'));

        if (isset(ThemeEngine::PRESETS[$preset])) {
            $presetData = ThemeEngine::PRESETS[$preset];
            Database::execute(
                "INSERT INTO themes (client_slug, name, preset_key, tokens_json, is_active)
                 VALUES (?, ?, ?, ?, 1)
                 ON DUPLICATE KEY UPDATE preset_key = VALUES(preset_key), tokens_json = VALUES(tokens_json), is_active = 1",
                [$clientSlug, $presetData['name'], $preset, json_encode($presetData['tokens'])]
            );
            Session::flash('success', "Applied theme preset '{$preset}' successfully.");
        }

        $response = new Response();
        return $response->redirect('/admin/theme');
    }
}
