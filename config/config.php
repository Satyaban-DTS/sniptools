<?php
// config/config.php

define('APP_NAME', 'SnipTools');
// Auto-detect BASE_URL
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$scriptDir = rtrim($scriptDir, '/');
// If we are in /public, we want the parent as base, or if index is in root?
// Actually, for this architecture, 'url()' function appends path.
// If index.php is at root (via .htaccess rewrite), SCRIPT_NAME might still be /index.php
// Let's use a simpler approach: relative to root.

// Identify if running on localhost or production
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
    define('BASE_URL', ''); // Files are now in root
} else {
    define('BASE_URL', ''); // Root for production subdomain
}

require_once __DIR__ . '/../includes/functions.php';

// Database Configuration (Shared Hosting)
// Database Configuration
define('DB_DRIVER', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'sniptools_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Tool Categories
$categories = [
    'text' => 'Text Tools',
    'developer' => 'Developer Tools',
    'image' => 'Image Tools',
    'converters' => 'Converters',
    'tailwind' => 'Tailwind Tools'
];
