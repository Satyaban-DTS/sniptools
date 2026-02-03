<?php
// web/public/tools.php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-8 custom-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-14 animate-slide-up">
            <nav
                class="flex items-center space-x-2 text-[9px] font-black uppercase tracking-[0.3em] text-gray-400 mb-6 px-2 opacity-60">
                <a href="<?php echo url(); ?>" class="hover:text-primary transition-colors">Workspace</a>
                <i class="fas fa-chevron-right text-[6px] opacity-30"></i>
                <span class="text-secondary dark:text-white">Directory</span>
            </nav>

            <h1
                class="text-3xl lg:text-4xl font-black text-secondary dark:text-white tracking-tighter mb-4 leading-tight">
                The Utility <span
                    class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Showcase</span>
            </h1>

            <p class="text-gray-500 dark:text-gray-400 text-sm max-w-2xl font-medium leading-relaxed">
                Streamlined collection of high-performance developer utilities optimized for speed and security.
            </p>
        </div>

        <!-- Section List -->
        <div class="space-y-32">
            <?php
            $index = 0;
            foreach ($catsDB as $cat):
                $catId = $cat['id'];
                $catName = $cat['name'];
                $catIcon = $cat['icon'] ?? 'fa-folder';

                $catTools = array_filter($tools, function ($t) use ($catId) {
                    return isset($t['category']) && $t['category'] === $catId;
                });
                if (empty($catTools))
                    continue;
                $index++;

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
                <section class="animate-slide-up" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                    <div class="flex items-center justify-between mb-10 px-2 group">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-<?php echo $accentColor; ?>-500/10 flex items-center justify-center text-<?php echo $accentColor; ?>-500 border border-<?php echo $accentColor; ?>-500/20 transition-transform group-hover:rotate-6">
                                <i class="fas <?php echo $catIcon; ?> text-lg"></i>
                            </div>
                            <div>
                                <h2
                                    class="text-2xl font-black text-secondary dark:text-white tracking-tighter uppercase italic">
                                    <?php echo $catName; ?>
                                </h2>
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.3em] mt-1 opacity-50">
                                    <?php echo count($catTools); ?> Active Nodes In Repository
                                </p>
                            </div>
                        </div>
                        <a href="<?php echo url('tools/' . $catId); ?>"
                            class="text-[9px] font-black text-gray-400 uppercase tracking-widest hover:text-<?php echo $accentColor; ?>-500 transition-all flex items-center group/link">
                            View Deep Repo <i
                                class="fas fa-arrow-right ml-3 text-[8px] group-hover/link:translate-x-2 transition-transform"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <?php foreach ($catTools as $slug => $tool): ?>
                            <a href="<?php echo getToolUrl($slug, $tool); ?>"
                                class="group relative bg-white dark:bg-[#1a1c2e] p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/[0.05] hover:border-<?php echo $accentColor; ?>-500/50 shadow-sm hover:shadow-[0_20px_50px_rgba(var(--<?php echo $accentColor; ?>-rgb, 192, 38, 211), 0.1)] hover:-translate-y-2 transition-all duration-500 flex flex-col items-start overflow-hidden">

                                <!-- Hover Glow -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-<?php echo $accentColor; ?>-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>

                                <div
                                    class="w-14 h-14 bg-gray-50 dark:bg-white/[0.03] rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-<?php echo $accentColor; ?>-500 group-hover:text-white group-hover:rotate-6 transition-all duration-500 mb-6 shadow-inner">
                                    <i class="fas <?php echo $tool['icon']; ?> text-xl"></i>
                                </div>

                                <div class="relative z-10 w-full mb-6">
                                    <h3
                                        class="font-black text-base text-secondary dark:text-white group-hover:text-<?php echo $accentColor; ?>-500 transition-colors tracking-tight uppercase">
                                        <?php echo $tool['name']; ?>
                                    </h3>
                                    <p
                                        class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed font-medium line-clamp-2 mt-2 italic opacity-70">
                                        "<?php echo $tool['desc']; ?>"
                                    </p>
                                </div>

                                <!-- Action Indicator -->
                                <div
                                    class="relative z-10 w-full flex items-center justify-between text-[8px] font-black uppercase tracking-widest text-gray-400 group-hover:text-<?php echo $accentColor; ?>-500 transition-colors pt-5 border-t border-gray-100 dark:border-white/5">
                                    <span>Execute Utility</span>
                                    <i class="fas fa-bolt opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

        <!-- Suggest a Tool CTA -->
        <div class="mt-32 mb-20 animate-slide-up" style="animation-delay: 0.6s;">
            <div
                class="relative glass-card rounded-[3rem] p-10 lg:p-16 border-primary/20 bg-gradient-to-br from-primary/5 to-accent/5 overflow-hidden text-center">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-[100px] -mr-32 -mt-32 animate-pulse">
                </div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <div class="inline-flex items-center space-x-2 px-4 py-1.5 bg-primary/10 rounded-full mb-8">
                        <i class="fas fa-lightbulb text-[10px] text-primary"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-primary">Community
                            Driven</span>
                    </div>
                    <h2
                        class="text-3xl lg:text-4xl font-black text-secondary dark:text-white leading-tight tracking-tighter mb-6">
                        Missing your favorite utility? <br>
                        <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">We build
                            what you need.</span>
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium leading-relaxed mb-10">
                        Our goal is to be the ultimate toolbox for developers. If there's a tool that's missing from our
                        directory, let us know and we'll prioritize its development.
                    </p>
                    <button onclick="openFeedbackModal('Tool Suggestion: ', 'suggestion')"
                        class="px-10 py-4 bg-primary text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-xl shadow-primary/30 hover:scale-105 hover:rotate-1 active:scale-95 transition-all btn-shine">
                        🚀 Suggest a New Tool
                    </button>
                </div>
            </div>
        </div>

    </div>
    <div class="pb-10"></div>
    <?php include __DIR__ . '/../includes/visual_footer.php'; ?>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>