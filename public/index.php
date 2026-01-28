<?php
// web/public/index.php
// Start Session Global
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Support for PHP built-in server
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;
    if (is_file($file)) {
        return false;
    }
}
require_once __DIR__ . '/../config/config.php';

$route = getRoute(); // From functions.php
$routeParts = explode('/', trim($route, '/'));

// --- TOOL DATABASE (Simulated for Phase 2) ---
// --- TOOL DATABASE ---
require_once __DIR__ . '/../config/tools.php';
// --- TOOL DATABASE ---
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php'; // DB Connection

// 1. Load Essential Settings from DB
$settingsRaw = $pdo->query("SELECT `key`, value FROM settings WHERE `key` IN ('site_name', 'ads_enabled', 'maintenance_mode', 'ad_code_head')")->fetchAll();
$settings = [];
foreach ($settingsRaw as $s)
    $settings[$s['key']] = $s['value'];

// Check Maintenance Mode
if (($settings['maintenance_mode'] ?? '0') === '1' && strpos($route, 'admin') === false) {
    die("<h1>Under Maintenance</h1><p>We'll be back shortly.</p>");
}

// 2. Track Visit (Simple)
$page = $route === '' ? 'home' : $route;
// Simple daily tracking to avoid massive DB growth - only insert if IP+Page combo doesn't exist today? 
// For now, just insert all for granularity, or maybe check session?
// Let's just do a simple insert.
$pdo->prepare("INSERT INTO visits (page, ip_hash) VALUES (?, ?)")
    ->execute([$page, md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])]);


// 3. Load Active Tools for Routing/Display
$toolsDB = $pdo->query("SELECT id, slug, name, description, icon, category_id FROM tools WHERE is_active = 1")->fetchAll();
$tools = [];
foreach ($toolsDB as $t) {
    $tools[$t['slug']] = [
        'id' => $t['id'],
        'name' => $t['name'],
        'desc' => $t['description'],
        'icon' => $t['icon'],
        'category' => $t['category_id']
    ];
}
// Also load categories from DB for sidebar
$catsDB = $pdo->query("SELECT * FROM categories ORDER BY sort_order")->fetchAll();
$categories = [];
foreach ($catsDB as $c)
    $categories[$c['id']] = $c['name'];


// --- CORE ROUTER ---


// 2. Admin Panel Routes
if (strpos($route, 'admin') === 0) {
    include __DIR__ . '/admin_router.php';
    exit;
}

// 2. Dashboard (Home)
if (empty($route) || $route === '/') {
    include __DIR__ . '/dashboard.php';
    exit;
}

// SEO Routes (for PHP built-in server which ignores .htaccess)
if ($route === 'sitemap.xml') {
    include __DIR__ . '/sitemap.php';
    exit;
}
if ($route === 'robots.txt') {
    include __DIR__ . '/robots.php';
    exit;
}

// 2. All Tools Landing Page (/tools)
if ($route === 'tools') {
    $pageTitle = "All Tools";
    include __DIR__ . '/tools.php';
    exit;
}

// 3. Support Page
if ($route === 'support') {
    $pageTitle = "Help & Support";
    include __DIR__ . '/../views/support.php';
    exit;
}

// 4. Static Pages (About, Privacy, Terms)
if (in_array($route, ['about', 'privacy', 'terms'])) {
    $pageTitle = ucfirst($route);
    if ($route === 'privacy')
        $pageTitle = 'Privacy Policy';
    if ($route === 'terms')
        $pageTitle = 'Terms of Service';

    include __DIR__ . '/../views/' . $route . '.php';
    exit;
}

// 2. Nested Tool Routes (/tools/text/word-counter)
if ($routeParts[0] === 'tools' && isset($routeParts[1]) && isset($routeParts[2])) {
    $catSlug = $routeParts[1];
    $toolSlug = $routeParts[2];

    if (isset($tools[$toolSlug]) && $tools[$toolSlug]['category'] === $catSlug) {
        $tool = $tools[$toolSlug];
        $pageTitle = $tool['name']; // Set page title to tool name
        $toolName = $tool['name'];
        $toolIcon = $tool['icon'];
        $toolDescription = $tool['desc'];
        $toolTip = $tool['tip'] ?? 'Tip: This tool runs 100% in your browser for maximum privacy.';
        $toolCategory = $categories[$catSlug] ?? $catSlug;
        $toolCategorySlug = $catSlug;

        // SEO Variables
        $metaDescription = $tool['desc'] . " No server uploads, 100% client-side privacy.";
        $metaKeywords = strtolower($toolName) . ", " . $catSlug . ", developer tools, free online utils";
        $canonicalUrl = getToolUrl($toolSlug, $tool);

        // SEO Variables
        $metaDescription = $tool['desc'] . " No server uploads, 100% client-side privacy.";
        $metaKeywords = strtolower($toolName) . ", " . $catSlug . ", developer tools, free online utils";
        $canonicalUrl = getToolUrl($toolSlug, $tool);

        // Tracking: Recently Used Tools (Session)
        // Session started globally at top
        if (!isset($_SESSION['recent_tools'])) {
            $_SESSION['recent_tools'] = [];
        }
        // Remove if exists
        $key = array_search($toolSlug, $_SESSION['recent_tools']);
        if ($key !== false) {
            unset($_SESSION['recent_tools'][$key]);
        }
        // Add to front
        array_unshift($_SESSION['recent_tools'], $toolSlug);
        // Keep max 3
        $_SESSION['recent_tools'] = array_slice($_SESSION['recent_tools'], 0, 3);

        $toolView = __DIR__ . '/../views/tools/' . $toolSlug . '.php';

        if (file_exists($toolView)) {
            // Increment Tool View Count
            $pdo->prepare("UPDATE tools SET view_count = view_count + 1 WHERE id = ?")->execute([$tool['id']]);

            include __DIR__ . '/../views/tool-layout.php';
        } else {
            echo "Tool UI coming soon!";
        }
    } else {
        http_response_code(404);
        include __DIR__ . '/dashboard.php';
    }
    exit;
}

// 3. Category Landing Pages (/tools/text)
if ($routeParts[0] === 'tools' && isset($routeParts[1]) && !isset($routeParts[2])) {
    $catSlug = $routeParts[1];
    if (isset($categories[$catSlug])) {
        $pageTitle = $categories[$catSlug];
        $categorySlug = $catSlug;
        include __DIR__ . '/category.php';
    } else {
        http_response_code(404);
        include __DIR__ . '/dashboard.php';
    }
    exit;
}

// 4. Legacy/Support Routes or others
if ($routeParts[0] === 'category' && isset($routeParts[1])) {
    header("Location: " . url('tools/' . $routeParts[1]));
    exit;
}

// 4. Default 404
http_response_code(404);
include __DIR__ . '/dashboard.php'; // Fail back to dashboard for now