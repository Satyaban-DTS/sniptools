<?php
// web/public/sitemap.php
ob_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Silence DB connection errors for sitemap to prevent plain-text output
// We'll try to load it manually to handle errors gracefully
try {
    require_once __DIR__ . '/../includes/db.php';
} catch (Exception $e) {
    // DB failure will be handled below via empty arrays
}

// Ensure BASE_URL is absolute for the sitemap
if (empty(BASE_URL) || strpos(BASE_URL, 'http') === false) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    if (!defined('ABS_URL'))
        define('ABS_URL', rtrim($protocol . $host, '/'));
} else {
    if (!defined('ABS_URL'))
        define('ABS_URL', rtrim(BASE_URL, '/'));
}

// Wrapper to ensure absolute URLs in sitemap
function sitemap_url($path = '')
{
    return ABS_URL . '/' . ltrim($path, '/');
}

// Ensure no output before XML declaration
ob_clean();
header("Content-Type: application/xml; charset=utf-8");

try {
    if (!isset($pdo)) throw new Exception("Database not available");
    
    // Load Tools from DB
    $toolsDB = $pdo->query("SELECT slug, category_id, created_at FROM tools WHERE is_active = 1")->fetchAll();
    
    $tools = [];
    foreach ($toolsDB as $t) {
        $tools[$t['slug']] = ['category' => $t['category_id']];
    }

    // Load Categories from DB
    $activeCategoryIds = array_unique(array_column($toolsDB, 'category_id'));
    $catsDB = $pdo->query("SELECT id FROM categories ORDER BY sort_order")->fetchAll();
    $categories = [];
    foreach ($catsDB as $c) {
        if (in_array($c['id'], $activeCategoryIds)) {
            $categories[] = $c['id'];
        }
    }
} catch (Exception $e) {
    // Fallback if DB fails or tables missing
    $tools = [];
    $categories = [];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Home -->
    <url>
        <loc><?php echo sitemap_url(); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- All Tools Directory -->
    <url>
        <loc><?php echo sitemap_url('tools'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Static Pages -->
    <?php foreach (['about', 'privacy', 'terms', 'contact', 'support'] as $page): ?>
        <url>
            <loc><?php echo sitemap_url($page); ?></loc>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>

    <!-- Categories -->
    <?php foreach ($categories as $catId): ?>
        <url>
            <loc><?php echo sitemap_url('tools/' . $catId); ?></loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>

    <!-- Individual Tools -->
    <?php foreach ($tools as $slug => $tool): ?>
        <url>
            <loc><?php echo sitemap_url("tools/" . ($tool['category'] ?? 'uncategorized') . "/{$slug}"); ?></loc>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    <?php endforeach; ?>
</urlset>
<?php
ob_end_flush();
// No closing tag to prevent accidental whitespace