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

// Determine Ad Code and check if specific location is enabled
$adCode = '';
if ($placement === 'dashboard_footer') {
    if (($settings['ads_footer_enabled'] ?? '1') !== '1')
        return;
    $adCode = $settings['ad_code_footer'] ?? '';
}
if ($placement === 'tool_sidebar') {
    if (($settings['ads_sidebar_enabled'] ?? '1') !== '1')
        return;
    $adCode = $settings['ad_code_sidebar'] ?? '';
}
if ($placement === 'header') {
    if (($settings['ads_header_enabled'] ?? '1') !== '1')
        return;
    $adCode = $settings['ad_code_header'] ?? '';
}
if (empty($adCode))
    return;
?>
<!-- Ad Unit: <?php echo htmlspecialchars($placement); ?> -->
<div
    class="ad-container my-8 p-6 bg-white dark:bg-white/[0.02] rounded-3xl border border-gray-100 dark:border-white/[0.05] text-center relative group min-h-[120px] flex items-center justify-center overflow-hidden shadow-sm">

    <!-- Background Accents -->
    <div
        class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
    </div>
    <div
        class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-primary/10 transition-all duration-500">
    </div>

    <!-- Ad Content -->
    <div class="relative z-10 w-full">
        <div class="flex items-center justify-center space-x-2 mb-4 opacity-40">
            <div class="h-[1px] w-8 bg-gray-400"></div>
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">Institutional Sponsor</span>
            <div class="h-[1px] w-8 bg-gray-400"></div>
        </div>

        <!-- Dynamic Ad Code -->
        <div class="ad-output">
            <?php echo $adCode; // Output raw HTML ?>
        </div>
    </div>
</div>