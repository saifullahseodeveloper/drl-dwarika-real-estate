<?php
declare(strict_types=1);

/**
 * DRL Dwarika Real Estate LLC — Front Controller Bootstrap
 * Hostinger Shared Hosting & LiteSpeed / Apache Compatible
 */

define('APP_ROOT', dirname(__DIR__));

// Global template helpers (e, format_price, etc.)
require_once APP_ROOT . '/app/Core/helpers.php';

// PSR-4 Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = APP_ROOT . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;
use App\Core\Session;

// Start session
Session::start();

// Document latency & CDN Edge Caching for public GET requests
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && !str_starts_with($requestUri, '/admin')) {
    header('Cache-Control: public, max-age=300, s-maxage=3600, stale-while-revalidate=86400');
    header('X-Content-Type-Options: nosniff');
}

// Initialize Router
$router = new Router();

// ==========================================
// 1. PUBLIC FRONTEND ROUTES
// ==========================================
$router->get('/', 'Frontend\\HomeController@index');
$router->get('/about-us', 'Frontend\\PageController@about');
$router->get('/founders', 'Frontend\\FoundersController@index');
$router->get('/agents', 'Frontend\\AgentController@index');
$router->get('/agents/{slug}', 'Frontend\\AgentController@show');
$router->get('/contact-us', 'Frontend\\PageController@contact');
$router->get('/testimonials', 'Frontend\\PageController@testimonials');

// Property routes
$router->get('/properties', 'Frontend\\PropertyController@index');
$router->get('/properties/buy', 'Frontend\\PropertyController@buy');
$router->get('/properties/rent', 'Frontend\\PropertyController@rent');
$router->get('/properties/off-plan', 'Frontend\\PropertyController@offPlan');
$router->get('/properties/commercial', 'Frontend\\PropertyController@commercial');
$router->get('/property/{slug}', 'Frontend\\PropertyController@show');

// Services routes
$router->get('/services', 'Frontend\\ServiceController@index');
$router->get('/services/buy-property', function() {
    (new \App\Controllers\Frontend\ServiceController())->show('buy-property');
});
$router->get('/services/sell-property', function() {
    (new \App\Controllers\Frontend\ServiceController())->show('sell-property');
});
$router->get('/services/property-consultancy', function() {
    (new \App\Controllers\Frontend\ServiceController())->show('property-consultancy');
});
$router->get('/services/investment-advisory', function() {
    (new \App\Controllers\Frontend\ServiceController())->show('investment-advisory');
});
$router->get('/services/{slug}', 'Frontend\\ServiceController@show');

// Taxonomies
$router->get('/locations/{slug}', 'Frontend\\LocationController@show');
$router->get('/property-types/{slug}', 'Frontend\\PropertyTypeController@show');

// Enquiries
$router->post('/enquiry/submit', 'Frontend\\LeadController@submit');

// Live AI Concierge Knowledge Base API
$router->get('/api/chatbot-knowledge', 'Frontend\\ApiController@chatbotKnowledge');

// Technical SEO
$router->get('/sitemap.xml', 'Frontend\\SeoController@sitemap');
$router->get('/robots.txt', 'Frontend\\SeoController@robots');

// ==========================================
// 2. ADMIN SECURE ROUTES
// ==========================================
$router->get('/admin/login', 'Admin\\AuthController@showLogin');
$router->post('/admin/login', 'Admin\\AuthController@login');
$router->get('/admin/logout', 'Admin\\AuthController@logout');

$router->get('/admin', function() {
    header('Location: /admin/dashboard');
    exit;
}, ['auth']);

$router->get('/admin/dashboard', 'Admin\\DashboardController@index', ['auth']);

// Admin Property CRUD
$router->get('/admin/properties', 'Admin\\PropertyController@index', ['auth']);
$router->get('/admin/properties/create', 'Admin\\PropertyController@create', ['auth']);
$router->post('/admin/properties/create', 'Admin\\PropertyController@store', ['auth']);
$router->get('/admin/properties/edit/{id}', 'Admin\\PropertyController@edit', ['auth']);
$router->post('/admin/properties/edit/{id}', 'Admin\\PropertyController@update', ['auth']);
$router->post('/admin/properties/delete/{id}', 'Admin\\PropertyController@delete', ['auth']);

// Admin Leads
$router->get('/admin/leads', 'Admin\\LeadController@index', ['auth']);
$router->post('/admin/leads/update-status/{id}', 'Admin\\LeadController@updateStatus', ['auth']);

// Admin Content
$router->get('/admin/services', 'Admin\\ContentController@services', ['auth']);
$router->get('/admin/testimonials', 'Admin\\ContentController@testimonials', ['auth']);
$router->get('/admin/locations', 'Admin\\ContentController@locations', ['auth']);

// Admin Agents & Founders
$router->get('/admin/agents', 'Admin\\AgentController@index', ['auth']);
$router->get('/admin/agents/create', 'Admin\\AgentController@create', ['auth']);
$router->post('/admin/agents/create', 'Admin\\AgentController@store', ['auth']);
$router->get('/admin/agents/edit/{id}', 'Admin\\AgentController@edit', ['auth']);
$router->post('/admin/agents/edit/{id}', 'Admin\\AgentController@update', ['auth']);
$router->post('/admin/agents/delete/{id}', 'Admin\\AgentController@delete', ['auth']);

$router->get('/admin/founders', 'Admin\\FounderController@index', ['auth']);
$router->get('/admin/founders/edit/{id}', 'Admin\\FounderController@edit', ['auth']);
$router->post('/admin/founders/edit/{id}', 'Admin\\FounderController@update', ['auth']);

// Admin SEO, Tools & Settings
$router->get('/admin/tools', 'Admin\\ToolsController@index', ['auth']);
$router->get('/admin/seo', 'Admin\\SeoController@index', ['auth']);
$router->get('/admin/settings', 'Admin\\SettingsController@index', ['auth']);
$router->post('/admin/settings', 'Admin\\SettingsController@update', ['auth']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';

$router->dispatch($method, $uri);
