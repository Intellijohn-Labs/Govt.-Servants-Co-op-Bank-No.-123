<?php
declare(strict_types=1);

/**
 * Application Routes Definition
 * Supports GET, POST, Route Groups, Middleware pipelines, and Named Routes
 */

use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\ContactController;
use App\Controllers\ProductController;
use App\Controllers\RateController;
use App\Controllers\CalculatorController;
use App\Controllers\BranchController;
use App\Controllers\ServiceRequestController;
use App\Controllers\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\EnquiryController;
use App\Controllers\Admin\BranchAdminController;
use App\Controllers\Admin\ProductAdminController;
use App\Controllers\Admin\RateAdminController;
use App\Controllers\Admin\ThemeAdminController;
use App\Controllers\Admin\ContentAdminController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

/** @var \Core\Router $router */

// --- 1. Public Frontend Routes ---
$router->get('/', [HomeController::class, 'index'], [], 'home');

// Pages & Governance
$router->get('/about', [PageController::class, 'about'], [], 'about');
$router->get('/board', [PageController::class, 'board'], [], 'board');
$router->get('/chairperson-message', [PageController::class, 'chairpersonMessage'], [], 'chairperson.message');
$router->get('/achievements', [PageController::class, 'achievements'], [], 'achievements');
$router->get('/welfare', [PageController::class, 'welfare'], [], 'welfare');
$router->get('/legal-framework', [PageController::class, 'legal'], [], 'legal');
$router->get('/privacy-policy', [PageController::class, 'privacy'], [], 'privacy');
$router->get('/terms', [PageController::class, 'terms'], [], 'terms');
$router->get('/sitemap', [PageController::class, 'sitemap'], [], 'sitemap');

// Services & Schemes
$router->get('/services', [ProductController::class, 'services'], [], 'services');
$router->get('/products/{slug}', [ProductController::class, 'show'], [], 'products.show');
$router->get('/services/{slug}', [ProductController::class, 'show'], [], 'services.show');

// Interest Rates & Calculators
$router->get('/interest-rates', [RateController::class, 'index'], [], 'rates');
$router->get('/calculators', [CalculatorController::class, 'index'], [], 'calculators');

// Branch Directory
$router->get('/branches', [BranchController::class, 'index'], [], 'branches');

// Service Request & Applications
$router->get('/service-request', [ServiceRequestController::class, 'show'], [], 'service_request.show');
$router->post('/service-request', [ServiceRequestController::class, 'submit'], [CsrfMiddleware::class], 'service_request.submit');

// Publications, News, Careers & Tenders
$router->get('/downloads', [PageController::class, 'downloads'], [], 'downloads');
$router->get('/news', [PageController::class, 'newsIndex'], [], 'news.index');
$router->get('/news/{slug}', [PageController::class, 'newsShow'], [], 'news.show');
$router->get('/tenders', [PageController::class, 'tenders'], [], 'tenders');
$router->get('/careers', [PageController::class, 'careers'], [], 'careers');
$router->get('/search', [PageController::class, 'search'], [], 'search');

// Contact & Enquiries
$router->get('/contact', [ContactController::class, 'show'], [], 'contact.show');
$router->post('/contact', [ContactController::class, 'submit'], [CsrfMiddleware::class], 'contact.submit');
$router->get('/feedback', [ContactController::class, 'feedbackShow'], [], 'feedback.show');
$router->post('/feedback', [ContactController::class, 'feedbackSubmit'], [CsrfMiddleware::class], 'feedback.submit');
$router->get('/grievance', [ContactController::class, 'grievanceShow'], [], 'grievance.show');

// --- 2. Authentication Routes ---
$router->get('/admin/login', [AuthController::class, 'showLogin'], [], 'auth.login');
$router->post('/admin/login', [AuthController::class, 'login'], [CsrfMiddleware::class], 'auth.login.submit');
$router->post('/admin/logout', [AuthController::class, 'logout'], [CsrfMiddleware::class], 'auth.logout');

// --- 3. Protected Admin CMS Routes ---
$router->group(['prefix' => '/admin', 'middleware' => [AuthMiddleware::class]], function (\Core\Router $r) {
    // Dashboard
    $r->get('/', [DashboardController::class, 'index'], [], 'admin.dashboard');
    $r->get('', [DashboardController::class, 'index'], [], 'admin.dashboard_root');

    // Operations: Enquiries & Applications
    $r->get('/enquiries', [EnquiryController::class, 'index'], [], 'admin.enquiries');
    $r->post('/enquiries/update', [EnquiryController::class, 'updateStatus'], [CsrfMiddleware::class], 'admin.enquiries.update');

    // Operations: Branches
    $r->get('/branches', [BranchAdminController::class, 'index'], [], 'admin.branches');
    $r->post('/branches/save', [BranchAdminController::class, 'save'], [CsrfMiddleware::class], 'admin.branches.save');

    // Financial Catalog: Products Catalogue
    $r->get('/products', [ProductAdminController::class, 'index'], [], 'admin.products');
    $r->post('/products/toggle', [ProductAdminController::class, 'toggle'], [CsrfMiddleware::class], 'admin.products.toggle');

    // Financial Catalog: Unified Rate Engine
    $r->get('/rates', [RateAdminController::class, 'index'], [], 'admin.rates');
    $r->post('/rates/save', [RateAdminController::class, 'save'], [CsrfMiddleware::class], 'admin.rates.save');
    $r->post('/rates/delete', [RateAdminController::class, 'delete'], [CsrfMiddleware::class], 'admin.rates.delete');

    // Administration: Theming & Accessibility
    $r->get('/theme', [ThemeAdminController::class, 'index'], [], 'admin.theme');
    $r->post('/theme/apply', [ThemeAdminController::class, 'applyPreset'], [CsrfMiddleware::class], 'admin.theme.apply');

    // Publishing & Content: News & Events
    $r->get('/news', [ContentAdminController::class, 'news'], [], 'admin.news');
    $r->post('/news/save', [ContentAdminController::class, 'saveNews'], [CsrfMiddleware::class], 'admin.news.save');

    // Publishing & Content: Downloads & Forms
    $r->get('/downloads', [ContentAdminController::class, 'downloads'], [], 'admin.downloads');
    $r->post('/downloads/save', [ContentAdminController::class, 'saveDownload'], [CsrfMiddleware::class], 'admin.downloads.save');

    // Publishing & Content: Announcements
    $r->get('/announcements', [ContentAdminController::class, 'announcements'], [], 'admin.announcements');

    // Governance: Board of Directors
    $r->get('/board', [ContentAdminController::class, 'board'], [], 'admin.board');

    // Publishing & Content: Pages & Governance
    $r->get('/pages', [ContentAdminController::class, 'pages'], [], 'admin.pages');

    // Publishing & Content: Banners
    $r->get('/banners', [ContentAdminController::class, 'banners'], [], 'admin.banners');

    // Administration: Settings & Compliance
    $r->get('/settings', [ContentAdminController::class, 'settings'], [], 'admin.settings');

    // Administration: Security Audit Log
    $r->get('/audit', [ContentAdminController::class, 'audit'], [], 'admin.audit');
});
