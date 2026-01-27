<?php
// web/public/sitemap.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

header("Content-Type: application/xml; charset=utf-8");

// Get Tools Database (Simulated)
// In a real app, this would be a DB query. We reuse the massive array from index.php by including it contextually or redefining.
// For simplicity/robustness here, we'll redefine the essential list or include a shared data file. 
// Ideally, `tools.php` or `data.php` should hold this array.
// For now, I'll extract the logic to include index.php but stop execution? No, index.php routes.
// Better approach: Create a data/tools.php file?
// To avoid refactoring index.php right now, I will manually reconstruct the categories which is safer.
// WAIT: index.php has the array. I should really move that array to a config file.

// REFACTOR: Moving tools array to a separate file first.
include __DIR__ . '/../config/tools.php';

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Home -->
    <url>
        <loc>
            <?php echo url(); ?>
        </loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- All Tools Directory -->
    <url>
        <loc>
            <?php echo url('tools'); ?>
        </loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Support Page -->
    <url>
        <loc>
            <?php echo url('support'); ?>
        </loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <!-- Categories -->
    <?php foreach ($categories as $slug => $name): ?>
        <url>
            <loc>
                <?php echo url('tools/' . $slug); ?>
            </loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>

    <!-- Individual Tools -->
    <?php foreach ($tools as $slug => $tool): ?>
        <url>
            <loc>
                <?php echo getToolUrl($slug, $tool); ?>
            </loc>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    <?php endforeach; ?>
</urlset>