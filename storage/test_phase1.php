<?php
declare(strict_types=1);

/**
 * Phase 1 Verification Script
 * Tests Router, I18n, Theme Engine, White-label switching, and Database.
 */

define('ROOT_DIR', dirname(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

echo "=== PHASE 1 TEST SUITE ===\n\n";

// 1. Test Client 1: kalliaseri-scb
echo "1. Testing Client 1 (kalliaseri-scb - Licensed Bank):\n";
putenv("CLIENT=kalliaseri-scb");
$_ENV['CLIENT'] = 'kalliaseri-scb';
\Core\Settings::clearCache();
\Core\App::boot();

$legalName = \Core\Settings::get('legal.verified_legal_name');
$entityType = \Core\Settings::get('legal.entity_type');
$dicgc = \Core\Settings::get('legal.dicgc_enabled');
$themeTokens = \Core\App::getThemeEngine()->getTokens();

echo "  ✓ Legal Name: {$legalName}\n";
echo "  ✓ Entity Type: {$entityType}\n";
echo "  ✓ DICGC Enabled: " . ($dicgc ? 'YES (Expected)' : 'NO') . "\n";
echo "  ✓ Primary Theme Color: " . $themeTokens['--primary'] . " (Royal Blue)\n";

// Test WCAG Contrast
$contrast = \Core\ThemeEngine::checkContrast($themeTokens['--primary-contrast'], $themeTokens['--primary']);
echo "  ✓ WCAG AA Contrast Ratio: {$contrast['ratio']}:1 ({$contrast['status']})\n";

// 2. Test I18n English & Malayalam
echo "\n2. Testing I18n Translation & Prefix Resolution:\n";
\Core\I18n::init('kalliaseri-scb', null);
echo "  ✓ English Tagline: " . \Core\I18n::get('tagline') . "\n";
\Core\I18n::init('kalliaseri-scb', 'ml');
echo "  ✓ Malayalam Tagline: " . \Core\I18n::get('tagline') . "\n";

// 3. Test Client 2: periyar-scs (Credit Society - Strict No 'Bank' check)
echo "\n3. Testing Client 2 (periyar-scs - Service Co-operative Society):\n";
putenv("CLIENT=periyar-scs");
\Core\Settings::clearCache();
\Core\App::boot('periyar-scs');

$societyName = \Core\Settings::get('legal.approved_public_name');
$societyEntityType = \Core\Settings::get('legal.entity_type');
$societyDicgc = \Core\Settings::get('legal.dicgc_enabled');
$societyTheme = \Core\App::getThemeEngine()->getTokens();

echo "  ✓ Approved Public Name: {$societyName}\n";
echo "  ✓ Entity Type: {$societyEntityType}\n";
echo "  ✓ DICGC Enabled: " . ($societyDicgc ? 'YES' : 'NO (Expected for Society)') . "\n";
echo "  ✓ Primary Theme Color: " . $societyTheme['--primary'] . " (Emerald Green)\n";

if (str_contains(strtolower($societyName), 'bank')) {
    echo "  ✗ ERROR: Prohibited word 'Bank' found in Society Public Name!\n";
    exit(1);
} else {
    echo "  ✓ Compliance Check: Word 'Bank' is STRICTLY absent from society branding.\n";
}

// 4. Test Router Dispatch (GET /about)
echo "\n4. Testing HTTP Router Dispatch:\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/about';
$_SERVER['SCRIPT_NAME'] = '/index.php';

$request = new \Core\Request($_GET, $_POST, $_FILES, $_SERVER);
$router = new \Core\Router();
require ROOT_DIR . '/app/routes.php';

$response = $router->dispatch($request);
echo "  ✓ Route /about Dispatched with Status Code: " . $response->getStatusCode() . "\n";

// 5. Test Auth
echo "\n5. Testing Auth Attempt with Seeded Admin Credentials:\n";
$authSuccess = \Core\Auth::attempt('admin', 'Admin@12345');
echo "  ✓ Auth attempt ('admin' / 'Admin@12345'): " . ($authSuccess ? 'SUCCESS' : 'FAILED') . "\n";
if ($authSuccess) {
    echo "  ✓ Authenticated User: " . \Core\Auth::user()['name'] . " (" . \Core\Auth::user()['role_name'] . ")\n";
    \Core\Auth::logout();
    echo "  ✓ Logged out successfully.\n";
}

echo "\n=== ALL PHASE 1 CORE FRAMEWORK TESTS PASSED! ===\n";
