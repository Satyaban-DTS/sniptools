<?php
// web/includes/ad-unit.php
// Connect to DB if not already connected (should be from index/config)
if (!isset($pdo) && file_exists(__DIR__ . '/db.php')) {
    require_once __DIR__ . '/db.php';
}

// Fetch settings if not already fetched
if (!isset($settings) && isset($pdo)) {
    $sStmt = $pdo->query("SELECT * FROM settings");
    $settingsRaw = $sStmt->fetchAll();
    $settings = [];
    foreach ($settingsRaw as $s)
        $settings[$s['key']] = $s['value'];
}

// Check if Ads are enabled globally
$adsEnabled = $settings['ads_enabled'] ?? '1';
if ($adsEnabled !== '1')
    return;

$placement = $placement ?? 'default';

// Determine Ad Code
$adCode = '';
if ($placement === 'dashboard_footer')
    $adCode = $settings['ad_code_footer'] ?? '';
if ($placement === 'tool_sidebar')
    $adCode = $settings['ad_code_sidebar'] ?? '';
if ($placement === 'header')
    $adCode = $settings['ad_code_header'] ?? '';
if (empty($adCode))
    return;
?>
<!-- Ad Unit: <?php echo htmlspecialchars($placement); ?> -->
<div
    class="ad-container my-6 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50 text-center relative group min-h-[100px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 pattern-grid opacity-5 dark:opacity-10"></div>

    <!-- Ad Content -->
    <div class="relative z-10 w-full">
        <span
            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2 opacity-50">Advertisement</span>

        <!-- Dynamic Ad Code -->
        <div class="ad-output">
            <?php echo $adCode; // Output raw HTML ?>
        </div>
    </div>
</div>