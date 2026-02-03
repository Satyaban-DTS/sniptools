<?php
// web/views/tool-layout.php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-4 lg:p-8 custom-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Tool Header -->
        <div class="mb-10 animate-fade-in">
            <nav
                class="flex mb-8 text-[9px] font-black uppercase tracking-[0.3em] text-gray-400 items-center opacity-60">
                <a href="<?php echo url('tools'); ?>" class="hover:text-primary transition-colors">Workspace</a>
                <i class="fas fa-chevron-right text-[6px] mx-4 opacity-30"></i>
                <a href="<?php echo url('tools/' . $toolCategorySlug); ?>"
                    class="hover:text-primary transition-colors"><?php echo $toolCategory; ?></a>
                <i class="fas fa-chevron-right text-[6px] mx-4 opacity-30"></i>
                <span class="text-secondary dark:text-white">Active Node</span>

                <div class="ml-auto hidden md:flex items-center space-x-3">
                    <button onclick="shareTool('<?php echo addslashes($toolName); ?>')"
                        class="group flex items-center space-x-2 px-5 py-2.5 rounded-2xl bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-white/20 dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/10 transition-all duration-300">
                        <div
                            class="w-6 h-6 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all text-primary">
                            <i class="fas fa-share-nodes text-[10px]"></i>
                        </div>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest text-secondary dark:text-gray-300 group-hover:text-primary transition-colors">Share</span>
                    </button>

                    <button onclick="openFeedbackModal('<?php echo addslashes($toolName); ?>')"
                        class="group flex items-center space-x-2 px-5 py-2.5 rounded-2xl bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-white/20 dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 hover:border-red-500/30 hover:shadow-lg hover:shadow-red-500/10 transition-all duration-300">
                        <div
                            class="w-6 h-6 rounded-lg bg-red-500/10 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-all text-red-500">
                            <i class="fas fa-bug text-[10px]"></i>
                        </div>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest text-secondary dark:text-gray-300 group-hover:text-red-500 transition-colors">Report
                            Bug</span>
                    </button>
                </div>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center gap-8 group">
                <div
                    class="w-20 h-20 rounded-[2rem] bg-white dark:bg-[#1a1c2e] shadow-xl flex items-center justify-center border border-gray-100 dark:border-white/5 transition-all duration-500 group-hover:rotate-6 group-hover:scale-110">
                    <i class="fas <?php echo $toolIcon; ?> text-3xl text-primary"></i>
                </div>
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <h1
                            class="text-4xl lg:text-5xl font-black text-secondary dark:text-white tracking-tighter uppercase italic">
                            <?php echo $toolName; ?>
                        </h1>
                        <button onclick="toggleFavorite('<?php echo $toolSlug; ?>')" id="favBtn"
                            class="w-12 h-12 rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-300 hover:text-yellow-500 transition-all shadow-sm flex items-center justify-center">
                            <i class="fas fa-star text-xl" id="favIcon"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-lg leading-relaxed max-w-3xl">
                        <?php echo $toolDescription; ?>
                    </p>
                </div>
            </div>
        </div>

        <script>
            function getFavorites() {
                try {
                    return JSON.parse(localStorage.getItem('sniptools_favorites')) || [];
                } catch (e) { return []; }
            }

            function updateFavUI() {
                const favs = getFavorites();
                const btn = document.getElementById('favBtn');
                const icon = document.getElementById('favIcon');
                if (favs.includes('<?php echo $toolSlug; ?>')) {
                    icon.classList.remove('far'); // Just in case we use far
                    icon.classList.add('fas', 'text-yellow-500');
                    btn.classList.add('border-yellow-500/20');
                } else {
                    icon.classList.remove('text-yellow-500');
                    btn.classList.remove('border-yellow-500/20');
                }
            }

            function toggleFavorite(slug) {
                let favs = getFavorites();
                if (favs.includes(slug)) {
                    favs = favs.filter(s => s !== slug);
                    showToast("Removed from favorites");
                } else {
                    favs.push(slug);
                    showToast("Added to favorites!");
                }
                localStorage.setItem('sniptools_favorites', JSON.stringify(favs));
                updateFavUI();

                // Dispatch event for sidebar update
                window.dispatchEvent(new Event('favoritesChanged'));
            }

            function shareTool(name) {
                const url = window.location.href;
                const text = `Check out this ${name} on SnipTools!`;

                if (navigator.share) {
                    navigator.share({
                        title: name,
                        text: text,
                        url: url,
                    }).catch(console.error);
                } else {
                    navigator.clipboard.writeText(url).then(() => {
                        showToast("Link copied to clipboard!");
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', updateFavUI);
        </script>

        <!-- Tool Content -->
        <?php
        $sidebarAd = $settings['ad_code_sidebar'] ?? '';
        $hasSidebarAd = ($settings['ads_enabled'] ?? '1') == '1' && ($settings['ads_sidebar_enabled'] ?? '1') == '1' && !empty($sidebarAd);
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
    <div class="pb-10"></div>
    <?php include __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>