<?php
// web/views/tool-layout.php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-4 lg:p-8 custom-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Tool Header -->
        <div class="mb-8">
            <nav class="flex mb-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 items-center">
                <a href="<?php echo url('tools'); ?>" class="hover:text-primary transition-colors">Tools</a>
                <i class="fas fa-chevron-right text-[8px] mx-3 opacity-30"></i>
                <a href="<?php echo url('tools/' . $toolCategorySlug); ?>"
                    class="hover:text-primary transition-colors"><?php echo $toolCategory; ?></a>
                <i class="fas fa-chevron-right text-[8px] mx-3 opacity-30"></i>
                <span class="text-primary"><?php echo $toolName; ?></span>
            </nav>
            <div class="flex items-center space-x-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-white dark:bg-gray-800 shadow-sm flex items-center justify-center border border-gray-100 dark:border-gray-700">
                    <i class="fas <?php echo $toolIcon; ?> text-2xl text-primary"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-secondary dark:text-white tracking-tight">
                        <?php echo $toolName; ?>
                    </h1>
                    <p class="text-sm text-gray-400 font-medium">
                        <?php echo $toolDescription; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tool Content -->
        <?php
        $sidebarAd = $settings['ad_code_sidebar'] ?? '';
        $hasSidebarAd = ($settings['ads_enabled'] ?? '1') == '1' && !empty($sidebarAd);
        ?>
        <div class="grid grid-cols-1 <?php echo $hasSidebarAd ? 'lg:grid-cols-4' : ''; ?> gap-8">
            <div
                class="<?php echo $hasSidebarAd ? 'lg:col-span-3' : 'lg:col-span-4'; ?> bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden p-8 lg:p-10">
                <?php include $toolView; ?>
            </div>

            <?php if ($hasSidebarAd): ?>
                <!-- Sidebar Ad -->
                <div class="lg:col-span-1 space-y-6">
                    <?php
                    $placement = 'tool_sidebar';
                    include __DIR__ . '/../includes/ad-unit.php';
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tool Footer/Tips -->
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-primary/5 rounded-[2rem] p-6 border border-primary/10">
                <h3 class="text-sm font-black text-primary uppercase tracking-widest mb-3">Pro Tip</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    <?php echo $toolTip; ?>
                </p>
            </div>
            <div class="bg-secondary/5 rounded-[2rem] p-6 border border-secondary/10">
                <h3 class="text-sm font-black text-secondary dark:text-white uppercase tracking-widest mb-3">Privacy
                    First</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    This tool runs entirely in your browser. None of your data is sent to our servers.
                </p>
            </div>
        </div>

        <!-- Tool Content Section -->
        <?php
        $contentFile = __DIR__ . '/tools/content/' . $toolSlug . '.php';
        if (file_exists($contentFile)) {
            include $contentFile;
        } else {
            // Optional: Default/Placeholder content or nothing
        }
        ?>
    </div>
    <?php include __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>