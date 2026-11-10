<?php
declare(strict_types=1);

/**
 * Comprehensive Automated Verification Suite for Services Co-operative Bank Template
 */

define('ROOT_DIR', dirname(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

use Core\App;
use Core\Database;
use Core\Settings;
use Core\I18n;
use Core\ThemeEngine;
use Core\Auth;
use Core\Request;
use Core\Router;

echo "=========================================================\n";
echo "   SERVICES CO-OPERATIVE BANK TEMPLATE - TEST SUITE      \n";
echo "=========================================================\n\n";

$passCount = 0;
$failCount = 0;

function assertTest(string $description, bool $condition): void {
    global $passCount, $failCount;
    if ($condition) {
        echo "  [PASS] {$description}\n";
        $passCount++;
    } else {
        echo "  [FAIL] {$description}\n";
        $failCount++;
    }
}

// 1. Boot Client 1: kalliaseri-scb
echo "1. TESTING CLIENT 1: KALLIASERI URBAN CO-OP BANK (Licensed Bank)\n";
putenv("CLIENT=kalliaseri-scb");
$_ENV['CLIENT'] = 'kalliaseri-scb';
Settings::clearCache();
App::boot('kalliaseri-scb');

assertTest("Client slug is kalliaseri-scb", Settings::clientSlug() === 'kalliaseri-scb');
assertTest("Entity type is licensed_bank", Settings::get('legal.entity_type') === 'licensed_bank');
assertTest("DICGC is enabled for licensed bank", Settings::get('legal.dicgc_enabled') === true);
assertTest("Approved public name set", str_contains(Settings::get('legal.approved_public_name'), 'Kalliaseri'));

$themeTokens = App::getThemeEngine()->getTokens();
$contrast = ThemeEngine::checkContrast($themeTokens['--primary-contrast'], $themeTokens['--primary']);
assertTest("WCAG AA Contrast ratio is >= 4.5:1 (Got: {$contrast['ratio']}:1)", $contrast['ratio'] >= 4.5);

echo "\n2. TESTING CLIENT 2: PERIYAR SERVICE CO-OP SOCIETY (Credit Society)\n";
putenv("CLIENT=periyar-scs");
$_ENV['CLIENT'] = 'periyar-scs';
Settings::clearCache();
App::boot('periyar-scs');

assertTest("Client slug is periyar-scs", Settings::clientSlug() === 'periyar-scs');
assertTest("Entity type is credit_society", Settings::get('legal.entity_type') === 'credit_society');
assertTest("DICGC is disabled for society", Settings::get('legal.dicgc_enabled') === false);

$societyPublicName = Settings::get('legal.approved_public_name');
assertTest("Strict Compliance: Word 'Bank' is STRICTLY absent from society name", !str_contains(strtolower($societyPublicName), 'bank'));

$societyTheme = App::getThemeEngine()->getTokens();
$societyContrast = ThemeEngine::checkContrast($societyTheme['--primary-contrast'], $societyTheme['--primary']);
assertTest("Society Theme WCAG AA Contrast ratio is >= 4.5:1 (Got: {$societyContrast['ratio']}:1)", $societyContrast['ratio'] >= 4.5);

// Reset to Kalliaseri for database and route checks
putenv("CLIENT=kalliaseri-scb");
$_ENV['CLIENT'] = 'kalliaseri-scb';
Settings::clearCache();
App::boot('kalliaseri-scb');

echo "\n3. TESTING DATABASE INTEGRITY & SCHEMES (kalliaseri-scb)\n";
$branches = Database::fetchAll("SELECT * FROM branches WHERE client_slug = 'kalliaseri-scb' AND status = 'active'");
assertTest("4 active branches found", count($branches) === 4);

$products = Database::fetchAll("SELECT * FROM products WHERE client_slug = 'kalliaseri-scb' AND status = 'published'");
assertTest("All schemes and services published (Found " . count($products) . ")", count($products) >= 10);

$rates = Database::fetchAll("SELECT * FROM product_rates WHERE client_slug = 'kalliaseri-scb' AND is_active = 1");
assertTest("Deposit and Loan rate schedules present (Found " . count($rates) . ")", count($rates) >= 8);

$downloads = Database::fetchAll("SELECT * FROM downloads WHERE client_slug = 'kalliaseri-scb' AND status = 'active'");
assertTest("Downloadable forms present (Found " . count($downloads) . ")", count($downloads) >= 5);

$news = Database::fetchAll("SELECT * FROM news WHERE client_slug = 'kalliaseri-scb' AND status = 'published'");
assertTest("Published news notices present (Found " . count($news) . ")", count($news) >= 2);

$tenders = Database::fetchAll("SELECT * FROM tenders WHERE client_slug = 'kalliaseri-scb'");
assertTest("Public tenders present (Found " . count($tenders) . ")", count($tenders) >= 2);

$careers = Database::fetchAll("SELECT * FROM careers WHERE client_slug = 'kalliaseri-scb'");
assertTest("Career vacancies present (Found " . count($careers) . ")", count($careers) >= 2);

echo "\n4. TESTING BILINGUAL LOCALIZATION (I18N)\n";
I18n::init('kalliaseri-scb', null);
assertTest("English locale active", current_lang() === 'en');
assertTest("English translation for 'nav_services'", __('nav_services') === 'Services');

I18n::init('kalliaseri-scb', 'ml');
assertTest("Malayalam locale active", current_lang() === 'ml');
assertTest("Malayalam translation for 'nav_services'", __('nav_services') === 'സേവനങ്ങൾ');
I18n::init('kalliaseri-scb', null);

echo "\n5. TESTING AUTHENTICATION & SECURITY\n";
$loginSuccess = Auth::attempt('admin', 'Admin@12345');
assertTest("Admin login authentication succeeded", $loginSuccess);
assertTest("Auth::check() returns true", Auth::check());
assertTest("Auth user role is super_admin", Auth::hasRole('super_admin'));
Auth::logout();
assertTest("Auth::logout() clears session", !Auth::check());

echo "\n6. TESTING HTTP DISPATCH ROUTING\n";
$router = new Router();
require ROOT_DIR . '/app/routes.php';

$testUrls = [
    '/' => 200,
    '/about' => 200,
    '/board' => 200,
    '/chairperson-message' => 200,
    '/services' => 200,
    '/products/gold-loan' => 200,
    '/products/housing-loan' => 200,
    '/products/fixed-deposit' => 200,
    '/interest-rates' => 200,
    '/calculators' => 200,
    '/branches' => 200,
    '/service-request' => 200,
    '/downloads' => 200,
    '/achievements' => 200,
    '/welfare' => 200,
    '/tenders' => 200,
    '/careers' => 200,
    '/contact' => 200,
    '/admin/login' => 200,
];

foreach ($testUrls as $url => $expectedStatus) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $url;
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $request = new Request($_GET, $_POST, $_FILES, $_SERVER);
    $response = $router->dispatch($request);
    assertTest("Public Route '{$url}' dispatched status {$response->getStatusCode()}", $response->getStatusCode() === $expectedStatus);
}

echo "\n7. TESTING PROTECTED ADMIN CMS ROUTES (Authenticated)\n";
Auth::attempt('admin', 'Admin@12345');

$adminUrls = [
    '/admin' => 200,
    '/admin/enquiries' => 200,
    '/admin/branches' => 200,
    '/admin/products' => 200,
    '/admin/rates' => 200,
    '/admin/theme' => 200,
    '/admin/news' => 200,
    '/admin/downloads' => 200,
    '/admin/announcements' => 200,
    '/admin/board' => 200,
    '/admin/pages' => 200,
    '/admin/banners' => 200,
    '/admin/settings' => 200,
    '/admin/audit' => 200,
];

foreach ($adminUrls as $url => $expectedStatus) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $url;
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $request = new Request($_GET, $_POST, $_FILES, $_SERVER);
    $response = $router->dispatch($request);
    assertTest("Admin Route '{$url}' dispatched status {$response->getStatusCode()}", $response->getStatusCode() === $expectedStatus);
}

Auth::logout();

echo "\n=========================================================\n";
echo "SUMMARY: {$passCount} Passed, {$failCount} Failed\n";
echo "=========================================================\n";

if ($failCount === 0) {
    echo ">>> ALL INTEGRATION AND UNIT TESTS PASSED PERFECTLY! <<<\n";
    exit(0);
} else {
    echo ">>> SOME TESTS FAILED! <<<\n";
    exit(1);
}
