<?php
// web/public/index.php

// 1. Initial Setup
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
header('Permissions-Policy: browsing-topics=()');

// Support for PHP built-in server
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;
    if (is_file($file))
        return false;
}

$route = getRoute();
$routeParts = explode('/', trim($route, '/'));

// 2. Load Tools Config (Hardcoded Fallback)
require_once __DIR__ . '/../config/tools.php';
// Default categories from config.php are in $categories (defined in config.php)

// 3. Database Connection & Dynamic Data
require_once __DIR__ . '/../includes/db.php';

try {
    // A. Fetch Settings
    $settingsRaw = $pdo->query("SELECT `key`, value FROM settings")->fetchAll(PDO::FETCH_ASSOC);
    $settings = [];
    foreach ($settingsRaw as $s) {
        $settings[$s['key']] = $s['value'];
    }

    // B. Maintenance Check
    if (($settings['maintenance_mode'] ?? '0') === '1' && strpos($route, 'admin') === false) {
        http_response_code(503);
        require_once __DIR__ . '/../views/maintenance.php';
        exit;
    }

    // C. Visit Tracking
    if (strpos($route, 'admin') === false) {
        $page = $route === '' ? 'home' : $route;
        $ip = get_client_ip();
        $sessId = session_id();
        $pdo->prepare("INSERT INTO visits (page, ip_hash) VALUES (?, ?)")
            ->execute([$page, md5($ip . ($_SERVER['HTTP_USER_AGENT'] ?? ''))]);
    }

    // D. Fetch Tools from DB
    $toolsDB = $pdo->query("SELECT id, slug, name, description, icon, category_id, meta_keywords, view_count, created_at FROM tools WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC);

    // Only overwrite if we found tools in DB
    if (!empty($toolsDB)) {
        $tools = []; // Clear hardcoded $tools
        foreach ($toolsDB as $t) {
            $tools[$t['slug']] = [
                'id' => $t['id'],
                'name' => $t['name'],
                'desc' => $t['description'],
                'icon' => $t['icon'],
                'category' => $t['category_id'],
                'keywords' => $t['meta_keywords'],
                'views' => $t['view_count'],
                'created_at' => $t['created_at']
            ];
        }
    }

    // E. Fetch Categories from DB
    $catsDBFromDB = $pdo->query("SELECT * FROM categories ORDER BY sort_order")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($catsDBFromDB)) {
        $catsDB = $catsDBFromDB;
        // Update $categories mapping too
        $categories = [];
        foreach ($catsDB as $c) {
            $categories[$c['id']] = $c['name'];
        }
    } else {
        // Fallback to hardcoded categories from config.php if Table/Rows missing
        $catsDB = [];
        foreach ($categories as $id => $name) {
            $catsDB[] = ['id' => $id, 'name' => $name, 'icon' => 'fa-cube', 'sort_order' => 0];
        }
    }

    // F. Fetch Trending Tools
    $trendingToolsQ = $pdo->query("SELECT * FROM tools WHERE is_active = 1 ORDER BY view_count DESC LIMIT 5");
    $trendingTools = $trendingToolsQ->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // If DB fails, we still have hardcoded $tools and $categories from include
    if (!isset($catsDB)) {
        $catsDB = [];
        foreach ($categories as $id => $name) {
            $catsDB[] = ['id' => $id, 'name' => $name, 'icon' => 'fa-cube', 'sort_order' => 0];
        }
    }
    if (!isset($trendingTools))
        $trendingTools = array_slice($tools, 0, 5);
}

// Ensure $catsDB is NEVER undefined
if (!isset($catsDB))
    $catsDB = [];

// --- CORE ROUTING ---

if (strpos($route, 'admin') === 0) {
    include __DIR__ . '/admin_router.php';
    exit;
}

if (in_array($route, ['diag.php', 'hard_reset.php', 'security_reset.php', 'test.php'])) {
    if (file_exists(__DIR__ . '/' . $route)) {
        include __DIR__ . '/' . $route;
        exit;
    }
}

if (empty($route) || $route === '/') {
    include __DIR__ . '/dashboard.php';
    exit;
}
if ($route === 'sitemap.xml') {
    include __DIR__ . '/sitemap.php';
    exit;
}
if ($route === 'robots.txt') {
    include __DIR__ . '/robots.php';
    exit;
}
if ($route === 'tools') {
    $pageTitle = "All Tools";
    include __DIR__ . '/tools.php';
    exit;
}

if (strpos($route, 'api/') === 0) {
    $apiFile = __DIR__ . '/' . $route;
    if (file_exists($apiFile)) {
        include $apiFile;
        exit;
    }
}

if ($route === 'support') {
    $pageTitle = "Help & Support";
    include __DIR__ . '/../views/support.php';
    exit;
}

if (in_array($route, ['about', 'privacy', 'terms', 'contact'])) {
    $pageTitle = ucfirst($route);
    include __DIR__ . '/../views/' . $route . '.php';
    exit;
}

// Nested Tool Routes
if ($routeParts[0] === 'tools' && isset($routeParts[1]) && isset($routeParts[2])) {
    $toolSlug = $routeParts[2];
    if (isset($tools[$toolSlug])) {
        $tool = $tools[$toolSlug];
        $pageTitle = $tool['name'];
        if (!isset($_SESSION['recent_tools']))
            $_SESSION['recent_tools'] = [];
        array_unshift($_SESSION['recent_tools'], $toolSlug);
        $_SESSION['recent_tools'] = array_slice(array_unique($_SESSION['recent_tools']), 0, 3);

        @$pdo->prepare("UPDATE tools SET view_count = view_count + 1 WHERE id = ?")->execute([$tool['id']]);

        $toolCategorySlug = $routeParts[1];
        $toolCategory = $categories[$toolCategorySlug] ?? $toolCategorySlug;
        $toolView = __DIR__ . '/../views/tools/' . $toolSlug . '.php';
        $toolName = $tool['name'];
        $toolDescription = $tool['desc'] ?? '';
        $toolIcon = $tool['icon'] ?? 'fa-cube';
        $toolTip = $tool['tip'] ?? 'Tip: This tool runs 100% in your browser for maximum privacy.';

        include __DIR__ . '/../views/tool-layout.php';
    } else {
        http_response_code(404);
        include __DIR__ . '/dashboard.php';
    }
    exit;
}

// Category Routes
if ($routeParts[0] === 'tools' && isset($routeParts[1])) {
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

// Default 404
http_response_code(404);
include __DIR__ . '/dashboard.php';