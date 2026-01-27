<?php
// web/public/dashboard.php
$pageTitle = "Modern Web Utilities for Developers";
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

// Reuse the existing dashboard content from the previous index.php
?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-8 lg:p-12 custom-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div
            class="mb-14 relative group overflow-hidden bg-gradient-to-r from-secondary to-[#2d1b4e] rounded-[2.5rem] p-10 lg:px-16 lg:py-16 text-white shadow-2xl">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-primary/20 rounded-full blur-[100px] -mr-40 -mt-40 group-hover:bg-primary/30 transition-all duration-700">
            </div>
            <div class="relative z-10 max-w-3xl">
                <div
                    class="inline-flex items-center space-x-2 px-3 py-1 bg-white/5 backdrop-blur-md rounded-full border border-white/10 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-300">Phase 2: Live
                        Tools</span>
                </div>
                <h1 class="text-4xl lg:text-6xl font-black mb-6 leading-[1.1] tracking-tighter">
                    Built for speed. <br>
                    Designed for <span
                        class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent italic">Security.</span>
                </h1>
                <p class="text-gray-400 text-lg mb-10 leading-relaxed max-w-xl">
                    High-performance developer tools with clean URLs and encrypted data paths. Open-source, robust, and
                    completely free.
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="<?php echo url('tools'); ?>"
                        class="px-8 py-4 bg-primary text-white rounded-2xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/30 hover:scale-105 active:scale-95 transition-all">
                        Explore Toolbox
                    </a>
                    <a href="<?php echo url('tools/text/case-converter'); ?>"
                        class="px-8 py-4 bg-white/5 backdrop-blur-sm dark:bg-gray-800 text-gray-300 rounded-2xl text-sm font-bold border border-white/10 hover:bg-white/10 transition-all">
                        Start with Case Converter
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex absolute right-20 top-1/2 -translate-y-1/2 flex-col items-center space-y-6">
                <div
                    class="w-24 h-24 bg-white/5 backdrop-blur-md rounded-[2rem] border border-white/10 flex items-center justify-center -rotate-6 transform hover:rotate-0 transition-transform duration-500">
                    <i class="fas fa-lock text-3xl text-primary/40"></i>
                </div>
                <div
                    class="w-32 h-32 bg-white/5 backdrop-blur-md rounded-[2.5rem] border border-white/10 flex items-center justify-center rotate-12 translate-x-12 transform hover:rotate-0 transition-transform duration-500">
                    <i class="fas fa-link text-4xl text-accent/40"></i>
                </div>
            </div>
        </div>

        <!-- Category Cards Grid -->
        <div id="browse-tools" class="mb-8 px-2 scroll-mt-20">
            <h2 class="text-2xl font-black text-secondary dark:text-white tracking-tight">Browse by Category</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1 opacity-60">Handpicked for
                developers</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
            <?php foreach ($categories as $catId => $catName): ?>
                <?php
                $count = count(array_filter($tools, function ($t) use ($catId) {
                    return isset($t['category']) && $t['category'] === $catId;
                }));
                if ($count === 0)
                    continue;

                // Simple logic to pick an icon or color based on category
                $catIcon = 'fa-folder';
                $catColor = 'text-primary';
                $catBg = 'bg-primary/5';
                if ($catId === 'text') {
                    $catIcon = 'fa-font';
                    $catColor = 'text-fuchsia-500';
                    $catBg = 'bg-fuchsia-500/5';
                }
                if ($catId === 'developer') {
                    $catIcon = 'fa-code';
                    $catColor = 'text-blue-500';
                    $catBg = 'bg-blue-500/5';
                }
                if ($catId === 'converters') {
                    $catIcon = 'fa-repeat';
                    $catColor = 'text-orange-500';
                    $catBg = 'bg-orange-500/5';
                }
                if ($catId === 'tailwind') {
                    $catIcon = 'fa-wind';
                    $catColor = 'text-cyan-500';
                    $catBg = 'bg-cyan-500/5';
                    $color = 'cyan';
                }
                ?>
                <a href="<?php echo url('tools/' . $catId); ?>"
                    class="group relative bg-white dark:bg-gray-800 rounded-[2rem] p-8 border border-gray-100 dark:border-gray-700/50 shadow-lg shadow-gray-200/50 dark:shadow-none hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 flex flex-col items-start justify-between min-h-[220px] overflow-hidden">

                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-<?php echo $color; ?>-500/5 rounded-full blur-3xl -mr-10 -mt-10 group-hover:bg-<?php echo $color; ?>-500/10 transition-colors">
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-<?php echo $color; ?>-50 dark:bg-<?php echo $color; ?>-900/20 flex items-center justify-center text-<?php echo $color; ?>-500 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <i class="fas <?php echo $catIcon; ?> text-3xl"></i>
                    </div>

                    <div class="relative z-10 w-full">
                        <h3
                            class="text-2xl font-black text-secondary dark:text-white mb-2 group-hover:text-primary transition-colors">
                            <?php echo $catName; ?>
                        </h3>
                        <div class="flex items-center justify-between w-full mt-2">
                            <span
                                class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-<?php echo $color; ?>-500 transition-colors"><?php echo $count; ?>
                                Tools</span>
                            <div
                                class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all scale-75 opacity-0 group-hover:scale-100 group-hover:opacity-100">
                                <i class="fas fa-arrow-right text-xs"></i>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Dashboard Ad -->
        <div class="mt-12 max-w-2xl mx-auto">
            <?php
            $placement = 'dashboard_footer';
            include __DIR__ . '/../includes/ad-unit.php';
            ?>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>