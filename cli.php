<?php
declare(strict_types=1);

/**
 * Command-Line Interface (CLI) Tool for Services Co-operative Bank Template
 *
 * Usage:
 *   php cli.php migrate
 *   php cli.php seed [client-slug]
 *   php cli.php clear-cache
 *   php cli.php create-client [client-slug] "[Client Legal Name]"
 */

define('ROOT_DIR', __DIR__);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/seeds/SeedData.php';

// Bootstrap minimal environment
\Core\App::boot();

$command = $argv[1] ?? 'help';

switch ($command) {
    case 'migrate':
        runMigration();
        break;

    case 'seed':
        $client = $argv[2] ?? \Core\Settings::clientSlug();
        runSeed($client);
        break;

    case 'clear-cache':
        clearCache();
        break;

    case 'create-client':
        $slug = $argv[2] ?? null;
        $name = $argv[3] ?? null;
        if (!$slug || !$name) {
            echo "Error: Missing arguments.\nUsage: php cli.php create-client [client-slug] \"[Client Legal Name]\"\n";
            exit(1);
        }
        createClient($slug, $name);
        break;

    case 'help':
    default:
        showHelp();
        break;
}

function runMigration(): void
{
    echo "Running database migrations...\n";

    $pdo = \Core\Database::connect();
    $driver = $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);
    $schemaFile = ($driver === 'sqlite')
        ? ROOT_DIR . '/database/schema_sqlite.sql'
        : ROOT_DIR . '/database/schema.sql';

    if (!file_exists($schemaFile)) {
        echo "Error: Schema file not found at {$schemaFile}\n";
        exit(1);
    }

    $sql = file_get_contents($schemaFile);

    try {
        if ($driver === 'sqlite') {
            $pdo->exec($sql);
        } else {
            $pdo->exec($sql);
        }
        echo "✓ Database schema applied successfully using driver: {$driver}!\n";
    } catch (\Throwable $e) {
        echo "Migration Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

function runSeed(string $clientSlug): void
{
    \Database\Seeds\SeedData::run($clientSlug);
    \Core\Settings::clearCache();
}

function clearCache(): void
{
    $cacheDir = ROOT_DIR . '/storage/cache';
    $files = glob($cacheDir . '/*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            @unlink($file);
            $count++;
        }
    }
    echo "✓ Cleared {$count} cache file(s).\n";
}

function createClient(string $slug, string $name): void
{
    $clientDir = ROOT_DIR . '/clients/' . $slug;
    if (is_dir($clientDir)) {
        echo "Error: Client directory {$slug} already exists.\n";
        exit(1);
    }

    mkdir($clientDir . '/assets', 0755, true);
    mkdir($clientDir . '/lang', 0755, true);
    mkdir($clientDir . '/seed', 0755, true);

    // Create default config
    $configContent = <<<PHP
<?php
declare(strict_types=1);

return [
    'client_slug' => '{$slug}',
    'legal' => [
        'verified_legal_name' => '{$name}',
        'approved_public_name' => '{$name}',
        'entity_type' => 'credit_society', // 'licensed_bank' | 'credit_society' | 'agri_society' | 'employee_society'
        'registration_number' => 'Regd. No. 0000',
        'pan' => '',
        'gst' => '',
        'dicgc_enabled' => false,
    ],
    'contact' => [
        'head_office_address_en' => 'Head Office Address, Kerala',
        'head_office_address_ml' => 'ഹെഡ് ഓഫീസ് വിലാസം, കേരളം',
        'primary_phone' => '+91 484 000 0000',
        'whatsapp_number' => '919876543210',
        'email' => 'info@{$slug}.local',
    ],
    'enabled_modules' => [
        'product_catalogue',
        'rate_engine',
        'calculators',
        'branch_directory',
        'enquiry_workflow',
        'news_events',
        'trust_centre',
    ],
    'default_language' => 'en',
];
PHP;

    file_put_contents($clientDir . '/config.php', $configContent);

    // Create theme.json with Emerald Green preset
    $themeContent = json_encode([
        'name' => "{$name} Theme",
        'preset' => 'emerald-green',
        'layout' => [
            'header_style' => 'left_logo',
            'hero_style' => 'slider',
            'card_style' => 'shadow',
            'footer_columns' => 4,
            'button_radius' => 'rounded',
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    file_put_contents($clientDir . '/theme.json', $themeContent);

    // Copy starter lang files
    copy(ROOT_DIR . '/clients/periyar-scs/lang/en.php', $clientDir . '/lang/en.php');
    copy(ROOT_DIR . '/clients/periyar-scs/lang/ml.php', $clientDir . '/lang/ml.php');

    echo "✓ New client '{$slug}' created successfully at clients/{$slug}!\n";
    echo "Next steps:\n";
    echo "  1. Review clients/{$slug}/config.php and theme.json\n";
    echo "  2. Add logo.png into clients/{$slug}/assets/\n";
    echo "  3. Run: php cli.php seed {$slug}\n";
    echo "  4. Set CLIENT={$slug} in your .env\n";
}

function showHelp(): void
{
    echo "Services Co-operative Bank CLI Tool\n";
    echo "====================================\n";
    echo "Commands:\n";
    echo "  php cli.php migrate                       Apply database schema\n";
    echo "  php cli.php seed [client-slug]             Seed initial products, rates, branches\n";
    echo "  php cli.php clear-cache                   Flush cached settings and templates\n";
    echo "  php cli.php create-client [slug] \"[Name]\" Scaffold a new white-label client\n";
}
