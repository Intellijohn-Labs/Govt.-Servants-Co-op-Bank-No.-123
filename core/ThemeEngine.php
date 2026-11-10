<?php
declare(strict_types=1);

namespace Core;

/**
 * White-label Theme Engine.
 * Dynamically compiles CSS Custom Properties from client theme.json
 * and database overrides, provides 5 distinct light-theme presets,
 * and enforces WCAG AA contrast ratio validation.
 */
class ThemeEngine
{
    private string $clientSlug;
    private array $themeConfig = [];
    private array $activeTokens = [];

    public const PRESETS = [
        'royal-blue' => [
            'name' => 'Royal Blue & Gold',
            'tokens' => [
                '--primary' => '#0A4D92',
                '--primary-contrast' => '#FFFFFF',
                '--secondary' => '#1E88E5',
                '--accent' => '#D97706',
                '--bg' => '#F8FAFC',
                '--surface' => '#FFFFFF',
                '--text' => '#0F172A',
                '--muted' => '#64748B',
                '--border' => '#E2E8F0',
                '--header-bg' => '#FFFFFF',
                '--footer-bg' => '#0A2540',
                '--radius' => '0.5rem',
                '--shadow' => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
                '--font-body' => "'Inter', 'Noto Sans Malayalam', system-ui, -apple-system, sans-serif",
                '--font-heading' => "'Poppins', 'Manjari', system-ui, -apple-system, sans-serif",
            ],
            'layout' => [
                'header_style' => 'left_logo',
                'hero_style' => 'slider',
                'card_style' => 'shadow',
                'footer_columns' => 4,
                'button_radius' => 'rounded-pill',
            ]
        ],
        'emerald-green' => [
            'name' => 'Emerald Green & Warm Amber',
            'tokens' => [
                '--primary' => '#0F766E',
                '--primary-contrast' => '#FFFFFF',
                '--secondary' => '#059669',
                '--accent' => '#D97706',
                '--bg' => '#F0FDF4',
                '--surface' => '#FFFFFF',
                '--text' => '#111827',
                '--muted' => '#4B5563',
                '--border' => '#E5E7EB',
                '--header-bg' => '#FFFFFF',
                '--footer-bg' => '#064E3B',
                '--radius' => '0.375rem',
                '--shadow' => '0 4px 6px -1px rgb(0 0 0 / 0.08), 0 2px 4px -2px rgb(0 0 0 / 0.06)',
                '--font-body' => "'Inter', 'Noto Sans Malayalam', system-ui, -apple-system, sans-serif",
                '--font-heading' => "'Inter', 'Manjari', system-ui, -apple-system, sans-serif",
            ],
            'layout' => [
                'header_style' => 'left_logo',
                'hero_style' => 'slider',
                'card_style' => 'shadow',
                'footer_columns' => 4,
                'button_radius' => 'rounded',
            ]
        ],
        'maroon-gold' => [
            'name' => 'Maroon & Heritage Gold',
            'tokens' => [
                '--primary' => '#881337',
                '--primary-contrast' => '#FFFFFF',
                '--secondary' => '#9F1239',
                '--accent' => '#B45309',
                '--bg' => '#FFFBF7',
                '--surface' => '#FFFFFF',
                '--text' => '#1C1917',
                '--muted' => '#78716C',
                '--border' => '#E7E5E4',
                '--header-bg' => '#FFFFFF',
                '--footer-bg' => '#4C0519',
                '--radius' => '0.25rem',
                '--shadow' => '0 4px 6px -1px rgb(0 0 0 / 0.08)',
                '--font-body' => "'Inter', 'Noto Sans Malayalam', system-ui, -apple-system, sans-serif",
                '--font-heading' => "'Merriweather', 'Manjari', Georgia, serif",
            ],
            'layout' => [
                'header_style' => 'centered_logo',
                'hero_style' => 'single_image',
                'card_style' => 'flat',
                'footer_columns' => 4,
                'button_radius' => 'rounded',
            ]
        ],
        'teal-orange' => [
            'name' => 'Teal & Sunset Orange',
            'tokens' => [
                '--primary' => '#0E7490',
                '--primary-contrast' => '#FFFFFF',
                '--secondary' => '#0284C7',
                '--accent' => '#EA580C',
                '--bg' => '#F8FAFC',
                '--surface' => '#FFFFFF',
                '--text' => '#0F172A',
                '--muted' => '#64748B',
                '--border' => '#CBD5E1',
                '--header-bg' => '#FFFFFF',
                '--footer-bg' => '#164E63',
                '--radius' => '0.75rem',
                '--shadow' => '0 10px 15px -3px rgb(0 0 0 / 0.1)',
                '--font-body' => "'Inter', 'Noto Sans Malayalam', system-ui, -apple-system, sans-serif",
                '--font-heading' => "'Poppins', 'Manjari', system-ui, -apple-system, sans-serif",
            ],
            'layout' => [
                'header_style' => 'left_logo',
                'hero_style' => 'slider',
                'card_style' => 'shadow',
                'footer_columns' => 4,
                'button_radius' => 'rounded-pill',
            ]
        ],
        'charcoal-amber' => [
            'name' => 'Charcoal & Amber Gold',
            'tokens' => [
                '--primary' => '#1E293B',
                '--primary-contrast' => '#FFFFFF',
                '--secondary' => '#334155',
                '--accent' => '#F59E0B',
                '--bg' => '#F8FAFC',
                '--surface' => '#FFFFFF',
                '--text' => '#0F172A',
                '--muted' => '#64748B',
                '--border' => '#E2E8F0',
                '--header-bg' => '#FFFFFF',
                '--footer-bg' => '#0F172A',
                '--radius' => '0.5rem',
                '--shadow' => '0 4px 6px -1px rgb(0 0 0 / 0.1)',
                '--font-body' => "'Inter', 'Noto Sans Malayalam', system-ui, -apple-system, sans-serif",
                '--font-heading' => "'Poppins', 'Manjari', system-ui, -apple-system, sans-serif",
            ],
            'layout' => [
                'header_style' => 'left_logo',
                'hero_style' => 'slider',
                'card_style' => 'shadow',
                'footer_columns' => 4,
                'button_radius' => 'rounded',
            ]
        ]
    ];

    public function __construct(string $clientSlug, array $dbThemeOverrides = [])
    {
        $this->clientSlug = $clientSlug;
        $this->loadTheme($dbThemeOverrides);
    }

    private function loadTheme(array $dbOverrides = []): void
    {
        $baseDir = dirname(__DIR__);
        $themeJsonPath = $baseDir . '/clients/' . $this->clientSlug . '/theme.json';

        $fileTheme = [];
        if (file_exists($themeJsonPath)) {
            $json = file_get_contents($themeJsonPath);
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                $fileTheme = $decoded;
            }
        }

        // Check database for active theme override if not explicitly provided
        if (empty($dbOverrides)) {
            try {
                $dbThemeRow = Database::fetchOne(
                    "SELECT * FROM themes WHERE client_slug = ? AND is_active = 1 ORDER BY updated_at DESC, id DESC LIMIT 1",
                    [$this->clientSlug]
                );
                if ($dbThemeRow) {
                    if (!empty($dbThemeRow['preset_key'])) {
                        $dbOverrides['preset'] = $dbThemeRow['preset_key'];
                    }
                    if (!empty($dbThemeRow['tokens_json'])) {
                        $decodedTokens = json_decode($dbThemeRow['tokens_json'], true);
                        if (is_array($decodedTokens)) {
                            $dbOverrides['tokens'] = $decodedTokens;
                        }
                    }
                    if (!empty($dbThemeRow['layout_json'])) {
                        $decodedLayout = json_decode($dbThemeRow['layout_json'], true);
                        if (is_array($decodedLayout)) {
                            $dbOverrides['layout'] = $decodedLayout;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Table might not exist or database not yet initialized
            }
        }

        // Determine base preset
        $presetKey = $dbOverrides['preset'] ?? $fileTheme['preset'] ?? 'royal-blue';
        $preset = self::PRESETS[$presetKey] ?? self::PRESETS['royal-blue'];

        // Token merging: if preset changed from file's preset, prefer preset's tokens
        $tokens = $preset['tokens'];
        if (!empty($dbOverrides['tokens']) && is_array($dbOverrides['tokens'])) {
            $tokens = array_merge($tokens, $dbOverrides['tokens']);
        } elseif (($fileTheme['preset'] ?? '') === $presetKey && !empty($fileTheme['tokens']) && is_array($fileTheme['tokens'])) {
            $tokens = array_merge($tokens, $fileTheme['tokens']);
        }

        // Merge layout settings
        $layout = $preset['layout'];
        if (!empty($dbOverrides['layout']) && is_array($dbOverrides['layout'])) {
            $layout = array_merge($layout, $dbOverrides['layout']);
        } elseif (($fileTheme['preset'] ?? '') === $presetKey && !empty($fileTheme['layout']) && is_array($fileTheme['layout'])) {
            $layout = array_merge($layout, $fileTheme['layout']);
        }

        $this->activeTokens = $tokens;
        $this->themeConfig = [
            'preset' => $presetKey,
            'tokens' => $tokens,
            'layout' => $layout,
            'dark_mode_enabled' => $dbOverrides['dark_mode_enabled'] ?? $fileTheme['dark_mode_enabled'] ?? false,
        ];
    }

    public function getPreset(): string
    {
        return $this->themeConfig['preset'] ?? 'royal-blue';
    }

    public function getThemeConfig(): array
    {
        return $this->themeConfig;
    }

    public function getTokens(): array
    {
        return $this->activeTokens;
    }

    public function getLayout(): array
    {
        return $this->themeConfig['layout'] ?? [];
    }

    public function getLayoutValue(string $key, mixed $default = null): mixed
    {
        return $this->themeConfig['layout'][$key] ?? $default;
    }

    public function generateCssVariables(): string
    {
        $css = ":root {\n";
        foreach ($this->activeTokens as $property => $value) {
            $css .= "  {$property}: {$value};\n";
        }
        $css .= "}\n";

        // Generate high-contrast or dark mode overrides if enabled
        if (!empty($this->themeConfig['dark_mode_enabled'])) {
            $css .= "[data-bs-theme='dark'] {\n";
            $css .= "  --bg: #0F172A;\n";
            $css .= "  --surface: #1E293B;\n";
            $css .= "  --text: #F8FAFC;\n";
            $css .= "  --muted: #94A3B8;\n";
            $css .= "  --border: #334155;\n";
            $css .= "  --header-bg: #1E293B;\n";
            $css .= "  --footer-bg: #0B1120;\n";
            $css .= "}\n";
        }

        return $css;
    }

    /**
     * Calculates WCAG 2.1 Contrast Ratio between two hex colors.
     * Returns array with ratio and pass/fail boolean for AA standard (4.5:1).
     */
    public static function checkContrast(string $hexForeground, string $hexBackground): array
    {
        $lum1 = self::calculateLuminance($hexForeground);
        $lum2 = self::calculateLuminance($hexBackground);

        $brightest = max($lum1, $lum2);
        $darkest = min($lum1, $lum2);

        $ratio = round(($brightest + 0.05) / ($darkest + 0.05), 2);

        return [
            'ratio' => $ratio,
            'aa_normal' => $ratio >= 4.5,
            'aa_large' => $ratio >= 3.0,
            'aaa_normal' => $ratio >= 7.0,
            'status' => $ratio >= 4.5 ? 'PASS' : ($ratio >= 3.0 ? 'PASS_LARGE_ONLY' : 'FAIL')
        ];
    }

    private static function calculateLuminance(string $hex): float
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (strlen($hex) !== 6) {
            return 0.0;
        }

        $r = hexdec(substr($hex, 0, 2)) / 255;
        $g = hexdec(substr($hex, 2, 2)) / 255;
        $b = hexdec(substr($hex, 4, 2)) / 255;

        $r = ($r <= 0.03928) ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = ($g <= 0.03928) ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = ($b <= 0.03928) ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }
}
