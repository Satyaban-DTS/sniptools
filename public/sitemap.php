<?php
// web/public/sitemap.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

header("Content-Type: application/xml; charset=utf-8");

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

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Home -->
    <url>
        <loc><?php echo url(); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- All Tools Directory -->
    <url>
        <loc><?php echo url('tools'); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Categories -->
    <?php foreach ($categories as $catId): ?>
        <url>
            <loc><?php echo url('tools/' . $catId); ?></loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>

    <!-- Individual Tools -->
    <?php foreach ($tools as $slug => $tool): ?>
        <url>
            <loc><?php echo getToolUrl($slug, $tool); ?></loc>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    <?php endforeach; ?>
</urlset>