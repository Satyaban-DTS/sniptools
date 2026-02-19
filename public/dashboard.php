<?php
// web/public/dashboard.php
$pageTitle = "Modern Web Utilities for Developers";
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

// Reuse the existing dashboard content from the previous index.php
?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-8 custom-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Quick Stats & Greeting -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4 animate-slide-up">
            <div>
                <h2 class="text-2xl font-black text-secondary dark:text-white tracking-tighter flex items-center">
                    <span class="mr-2">👋</span> <span id="greetingText">Good Day</span>, Dev!
                </h2>
                <script>
                    (function () {
                        const h = new Date().getHours();
                        const g = h < 12 ? 'Good Morning' : (h < 18 ? 'Good Afternoon' : 'Good Evening');
                        document.getElementById('greetingText').textContent = g;
                    })();
                </script>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.3em] opacity-60">Ready to speed up
                    your workflow?</p>
            </div>

            <div class="flex items-center space-x-3" role="list">
                <div role="listitem"
                    class="glass-card px-4 py-2.5 rounded-2xl flex items-center space-x-3 border-white/10 shadow-sm group hover:border-primary/30 transition-all">
                    <div
                        class="w-8 h-8 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-xs group-hover:bg-primary group-hover:text-white transition-all">
                        <i class="fas fa-bolt" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-secondary dark:text-white uppercase tracking-tight">30+
                            tools</p>
                        <p class="text-[8px] text-gray-500 font-bold uppercase opacity-60">Handpicked</p>
                    </div>
                </div>
                <div role="listitem"
                    class="glass-card px-4 py-2.5 rounded-2xl flex items-center space-x-3 border-white/10 shadow-sm group hover:border-emerald-500/30 transition-all">
                    <div
                        class="w-8 h-8 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 text-xs group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <i class="fas fa-shield-virus" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-secondary dark:text-white uppercase tracking-tight">100%
                            Secure</p>
                        <p class="text-[8px] text-gray-500 font-bold uppercase opacity-60">Client-Side</p>
                    </div>
                </div>
                <div role="listitem"
                    class="glass-card px-4 py-2.5 rounded-2xl flex items-center space-x-3 border-white/10 shadow-sm group hover:border-blue-500/30 transition-all">
                    <div
                        class="w-8 h-8 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 text-xs group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <i class="fas fa-wifi-slash" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-secondary dark:text-white uppercase tracking-tight">Offline
                        </p>
                        <p class="text-[8px] text-gray-500 font-bold uppercase opacity-60">PWA Ready</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="mb-24 relative group overflow-hidden bg-secondary hero-gradient rounded-[3rem] p-10 lg:px-16 lg:py-14 text-white shadow-2xl animate-slide-up"
            style="animation-delay: 0.1s;">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-primary/20 rounded-full blur-[100px] -mr-40 -mt-40 group-hover:bg-primary/30 transition-all duration-700">
            </div>
            <div class="relative z-10 max-w-3xl">
                <div
                    class="inline-flex items-center space-x-2 px-3 py-1 bg-white/5 backdrop-blur-md rounded-full border border-white/10 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-300">
                        <?php echo htmlspecialchars($settings['cta_badge'] ?? 'Phase 2: Live Tools'); ?>
                    </span>
                </div>
                <h1 class="text-3xl lg:text-5xl font-black mb-4 leading-[1.1] tracking-tighter" fetchpriority="high">
                    <?php echo $settings['cta_title'] ?? 'Built for speed. <br> Designed for <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent italic">Security.</span>'; ?>
                </h1>
                <p class="text-gray-400 text-base mb-8 leading-relaxed max-w-xl hero-text">
                    <?php echo htmlspecialchars($settings['cta_description'] ?? 'High-performance developer tools with clean URLs and encrypted data paths.'); ?>
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="<?php echo htmlspecialchars(url($settings['cta_button_link'] ?? 'tools')); ?>"
                        class="px-8 py-4 bg-primary text-white rounded-2xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/30 hover:scale-105 active:scale-95 transition-all btn-shine">
                        <?php echo htmlspecialchars($settings['cta_button_text'] ?? 'Explore Toolbox'); ?>
                    </a>
                    <a href="<?php echo htmlspecialchars(url($settings['cta2_button_link'] ?? 'tools/text/case-converter')); ?>"
                        class="px-8 py-4 bg-white/5 backdrop-blur-sm dark:bg-gray-800 text-gray-300 rounded-2xl text-sm font-bold border border-white/10 hover:bg-white/10 transition-all">
                        <?php echo htmlspecialchars($settings['cta2_button_text'] ?? 'Start with Case Converter'); ?>
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

        <!-- Pick up where you left off -->
        <?php
        if (session_status() === PHP_SESSION_NONE)
            @session_start();
        $recentSlugs = $_SESSION['recent_tools'] ?? [];
        if (!empty($recentSlugs)):
            $recentSlugsFiltered = array_slice($recentSlugs, 0, 4);
            ?>
            <div class="mb-24 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="flex items-center space-x-3 mb-8 px-2">
                    <div class="h-[2px] w-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-black text-secondary dark:text-white tracking-tight uppercase">Continue Working
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?php foreach ($recentSlugsFiltered as $slug):
                        if (!isset($tools[$slug]))
                            continue;
                        $t = $tools[$slug];
                        ?>
                        <a href="<?php echo getToolUrl($slug, $t); ?>" aria-label="Open tool: <?php echo $t['name']; ?>"
                            class="glass-card flex items-center p-5 rounded-3xl border-white/10 hover:border-blue-500/30 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 group">
                            <div
                                class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 mr-4 group-hover:bg-blue-500 group-hover:text-white transition-all shadow-inner">
                                <i class="fas <?php echo $t['icon']; ?> text-lg" aria-hidden="true"></i>
                            </div>
                            <div class="min-w-0">
                                <h4
                                    class="text-sm font-black text-secondary dark:text-white truncate group-hover:text-blue-500 transition-colors">
                                    <?php echo $t['name']; ?>
                                </h4>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5 opacity-60">Last
                                    used</p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Trending Tools Section -->
        <?php if (!empty($trendingTools)): ?>
            <div class="mb-24 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between mb-10 px-2">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="h-1 w-12 bg-gradient-to-r from-accent to-primary rounded-full"></div>
                            <h2
                                class="text-2xl font-black text-secondary dark:text-white tracking-tighter uppercase italic">
                                Trending Now</h2>
                        </div>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.4em] opacity-50 ml-15">Most
                            active developer utilities</p>
                    </div>
                </div>

                <!-- Container with padding to prevent clipping of hover animations -->
                <div class="px-2 py-4 -mx-2 overflow-x-auto lg:overflow-visible no-scrollbar">
                    <div class="flex lg:grid lg:grid-cols-5 gap-6 min-w-max lg:min-w-0">
                        <?php foreach ($trendingTools as $t): ?>
                            <a href="<?php echo url("tools/{$t['category_id']}/{$t['slug']}"); ?>"
                                class="group relative w-72 lg:w-auto bg-white dark:bg-[#1a1c2e] p-8 rounded-[3rem] border border-gray-100 dark:border-white/[0.05] hover:border-accent/50 shadow-sm hover:shadow-[0_20px_50px_rgba(236,72,153,0.15)] hover:-translate-y-2 transition-all duration-500 overflow-visible flex flex-col items-center text-center">

                                <!-- Glowing Background Effect -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-accent/5 to-primary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-[3rem]">
                                </div>

                                <div class="relative mb-6">
                                    <div
                                        class="w-20 h-20 bg-accent/10 rounded-[2rem] flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white group-hover:rotate-6 transition-all duration-500 shadow-inner group-hover:shadow-xl group-hover:shadow-accent/30">
                                        <i class="fas <?php echo $t['icon']; ?> text-3xl"></i>
                                    </div>
                                    <?php if (is_new_tool($t['created_at'])): ?>
                                        <div class="absolute -top-2 -right-2 flex h-6 w-6">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span
                                                class="relative inline-flex rounded-full h-6 w-6 bg-emerald-500 border-4 border-white dark:border-[#1a1c2e] shadow-sm"></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="relative z-10 flex flex-col items-center w-full">
                                    <h3
                                        class="text-base font-black text-secondary dark:text-white group-hover:text-accent transition-colors mb-3 tracking-tight">
                                        <?php echo $t['name']; ?>
                                    </h3>

                                    <div class="flex items-center justify-center gap-2">
                                        <?php if (is_new_tool($t['created_at'])): ?>
                                            <span
                                                class="text-[8px] font-black bg-emerald-500/10 text-emerald-500 px-3 py-1 rounded-full uppercase tracking-[0.2em] border border-emerald-500/20">New</span>
                                        <?php endif; ?>
                                        <div
                                            class="flex items-center space-x-1 px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 border border-transparent group-hover:border-accent/20 transition-all">
                                            <span
                                                class="text-[8px] font-black text-gray-500 group-hover:text-accent uppercase tracking-[0.2em]"><?php echo number_format($t['view_count']); ?>
                                                Uses</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Decorative Bottom Accent -->
                                <div
                                    class="absolute bottom-6 w-12 h-1 bg-gray-100 dark:bg-white/10 rounded-full group-hover:bg-accent group-hover:w-16 transition-all duration-500">
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Category Cards Grid -->
            <div id="browse-tools" class="mb-12 mt-32 px-2 scroll-mt-24 animate-slide-up"
                style="animation-delay: 0.3s;">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="h-1 w-12 bg-gradient-to-r from-primary to-accent rounded-full"></div>
                    <h2 class="text-3xl font-black text-secondary dark:text-white tracking-tighter uppercase italic">
                        Toolbox Repositories</h2>
                </div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.4em] opacity-50 ml-15">
                    High-performance classification nodes</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 animate-slide-up mb-32">
                <?php
                // We use $catsDB from index.php
                foreach ($catsDB as $cat):
                    $catId = $cat['id'];
                    $catName = $cat['name'];
                    $catIcon = $cat['icon'] ?? 'fa-folder';

                    $count = count(array_filter($tools, function ($t) use ($catId) {
                        return isset($t['category']) && $t['category'] === $catId;
                    }));

                    if ($count === 0)
                        continue;

                    // Color mapping for a premium multi-chrome look
                    $colors = [
                        'text' => 'fuchsia',
                        'developer' => 'blue',
                        'converters' => 'orange',
                        'tailwind' => 'cyan',
                        'image' => 'rose'
                    ];
                    $accentColor = $colors[$catId] ?? 'primary';
                    ?>
                    <a href="<?php echo url('tools/' . $catId); ?>"
                        class="group relative bg-white dark:bg-[#1a1c2e] p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/[0.05] hover:border-<?php echo $accentColor; ?>-500/50 transition-all duration-500 flex flex-col items-start overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-<?php echo $accentColor; ?>-500/10 hover:-translate-y-2">

                        <!-- Decorative Pulse Background -->
                        <div
                            class="absolute -right-6 -top-6 w-32 h-32 bg-<?php echo $accentColor; ?>-500/5 rounded-full blur-3xl group-hover:bg-<?php echo $accentColor; ?>-500/15 transition-all duration-700">
                        </div>

                        <!-- Icon Node -->
                        <div
                            class="relative z-10 w-16 h-16 rounded-[1.5rem] bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/[0.05] flex items-center justify-center text-gray-400 group-hover:bg-<?php echo $accentColor; ?>-500 group-hover:text-white group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-inner group-hover:shadow-xl group-hover:shadow-<?php echo $accentColor; ?>-500/30 mb-6">
                            <i class="fas <?php echo $catIcon; ?> text-2xl"></i>
                        </div>

                        <!-- Classification Data -->
                        <div class="relative z-10 w-full">
                            <h3
                                class="text-xl font-black text-secondary dark:text-white group-hover:text-<?php echo $accentColor; ?>-500 transition-colors tracking-tight uppercase">
                                <?php echo $catName; ?>
                            </h3>
                            <div class="flex items-center mt-3 space-x-3">
                                <span
                                    class="text-[9px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-white/5 py-1 px-2.5 rounded-lg border border-transparent group-hover:border-<?php echo $accentColor; ?>-500/20">
                                    <?php echo $count; ?> Nodes
                                </span>
                                <span class="h-1 w-1 bg-gray-300 dark:bg-gray-700 rounded-full"></span>
                                <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Active</span>
                            </div>
                        </div>

                        <!-- Decorative Bottom Bar -->
                        <div
                            class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-transparent via-<?php echo $accentColor; ?>-500 to-transparent w-full opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Why SnipTools Section -->
            <!-- Why SnipTools Luxury Section -->
            <div class="mt-20 mb-32 relative animate-fade-in">
                <div
                    class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-primary/5 rounded-full blur-[120px] -z-10 opacity-60">
                </div>

                <div class="text-center mb-20">
                    <div
                        class="inline-flex items-center space-x-3 px-4 py-1.5 bg-white/5 backdrop-blur-md rounded-full border border-white/10 mb-8 mx-auto">
                        <i class="fas fa-crown text-[10px] text-yellow-500"></i>
                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">The SnipTools
                            Protocol</span>
                    </div>
                    <h2
                        class="text-5xl lg:text-6xl font-black text-secondary dark:text-white tracking-tighter uppercase italic mb-6">
                        Engineered for <span
                            class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Elite
                            Performance</span>
                    </h2>
                    <p
                        class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl mx-auto font-medium leading-relaxed italic">
                        "Redefining the developer utility standard through architectural purity and uncompromising
                        privacy."
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <!-- Privacy -->
                    <div
                        class="group relative p-10 rounded-[3rem] bg-white dark:bg-[#1a1c2e] border border-gray-100 dark:border-white/[0.05] hover:border-primary/50 transition-all duration-500 shadow-sm hover:shadow-2xl overflow-hidden">
                        <div
                            class="absolute -right-8 -top-8 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/20 transition-all duration-700">
                        </div>
                        <div
                            class="relative z-10 w-20 h-20 bg-primary/10 rounded-[2rem] flex items-center justify-center text-primary mb-8 group-hover:bg-primary group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner group-hover:shadow-xl group-hover:shadow-primary/30">
                            <i class="fas fa-shield-halved text-3xl"></i>
                        </div>
                        <h3
                            class="relative z-10 text-2xl font-black text-secondary dark:text-white mb-4 uppercase tracking-tight">
                            Sovereignty</h3>
                        <p class="relative z-10 text-gray-500 dark:text-gray-400 leading-relaxed font-medium text-sm">
                            Your parameters never touch our cloud. Every cycle executes strictly within your local
                            sandbox environment, ensuring total data sovereignty.
                        </p>
                    </div>

                    <!-- Speed -->
                    <div
                        class="group relative p-10 rounded-[3rem] bg-white dark:bg-[#1a1c2e] border border-gray-100 dark:border-white/[0.05] hover:border-accent/50 transition-all duration-500 shadow-sm hover:shadow-2xl overflow-hidden">
                        <div
                            class="absolute -right-8 -top-8 w-32 h-32 bg-accent/5 rounded-full blur-3xl group-hover:bg-accent/20 transition-all duration-700">
                        </div>
                        <div
                            class="relative z-10 w-20 h-20 bg-accent/10 rounded-[2rem] flex items-center justify-center text-accent mb-8 group-hover:bg-accent group-hover:text-white group-hover:-rotate-12 transition-all duration-500 shadow-inner group-hover:shadow-xl group-hover:shadow-accent/30">
                            <i class="fas fa-bolt-lightning text-3xl"></i>
                        </div>
                        <h3
                            class="relative z-10 text-2xl font-black text-secondary dark:text-white mb-4 uppercase tracking-tight">
                            Velocity</h3>
                        <p class="relative z-10 text-gray-500 dark:text-gray-400 leading-relaxed font-medium text-sm">
                            Bypassing framework abstraction. Our utility nodes are optimized for near-instant execution,
                            delivering Warp-speed results across all devices.
                        </p>
                    </div>

                    <!-- Free -->
                    <div
                        class="group relative p-10 rounded-[3rem] bg-white dark:bg-[#1a1c2e] border border-gray-100 dark:border-white/[0.05] hover:border-emerald-500/50 transition-all duration-500 shadow-sm hover:shadow-2xl overflow-hidden">
                        <div
                            class="absolute -right-8 -top-8 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all duration-700">
                        </div>
                        <div
                            class="relative z-10 w-20 h-20 bg-emerald-500/10 rounded-[2rem] flex items-center justify-center text-emerald-500 mb-8 group-hover:bg-emerald-500 group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner group-hover:shadow-xl group-hover:shadow-emerald-300/30">
                            <i class="fas fa-gem text-3xl"></i>
                        </div>
                        <h3
                            class="relative z-10 text-2xl font-black text-secondary dark:text-white mb-4 uppercase tracking-tight">
                            Eternity</h3>
                        <p class="relative z-10 text-gray-500 dark:text-gray-400 leading-relaxed font-medium text-sm">
                            A perpetual license for the collective. SnipTools is and will always remain free, evolving
                            through community-driven logic and open-source spirit.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-24 max-w-2xl mx-auto">
            <?php
            $placement = 'dashboard_footer';
            include __DIR__ . '/../includes/ad-unit.php';
            ?>
        </div>
    </div>

    <div class="pb-10"></div>
    <?php include __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>