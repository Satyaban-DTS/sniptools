<?php
// web/public/robots.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

header("Content-Type: text/plain");
?>
User-agent: *
Allow: /
Disallow: /admin
Disallow: /api/
Sitemap: <?php echo url('sitemap.xml'); ?>