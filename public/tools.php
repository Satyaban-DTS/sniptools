<?php
// web/public/tools.php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-8 lg:p-12 custom-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-14">
            <nav
                class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-6 px-2">
                <a href="<?php echo url(); ?>" class="hover:text-primary transition-colors">Home</a>
                <i class="fas fa-chevron-right text-[8px] opacity-30"></i>
                <span class="text-secondary dark:text-white">All Tools Directory</span>
            </nav>
            <h1 class="text-4xl lg:text-5xl font-black text-secondary dark:text-white tracking-tighter mb-4">
                Explore the Toolbox
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl font-medium leading-relaxed">
                A comprehensive collection of high-performance developer utilities. Fast, secure, and built for modern
                workflows.
            </p>
        </div>

        <!-- Section List -->
        <div class="space-y-24">
            <?php foreach ($categories as $catId => $catName): ?>
                <?php
                $catTools = array_filter($tools, function ($t) use ($catId) {
                    return isset($t['category']) && $t['category'] === $catId;
                });
                if (empty($catTools))
                    continue;
                ?>
                <section>
                    <div
                        class="flex items-center justify-between mb-8 px-2 border-b border-gray-100 dark:border-gray-800 pb-6">
                        <div>
                            <h2 class="text-2xl font-black text-secondary dark:text-white tracking-tight">
                                <?php echo $catName; ?>
                            </h2>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em] mt-1 opacity-80">
                                <?php echo count($catTools); ?> Total Tools
                            </p>
                        </div>
                        <a href="<?php echo url('tools/' . $catId); ?>"
                            class="text-[10px] font-black text-primary uppercase tracking-widest hover:text-accent transition-colors">
                            Category Page <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach ($catTools as $slug => $tool): ?>
                            <a href="<?php echo getToolUrl($slug, $tool); ?>"
                                class="group relative bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-[180px]">

                                <div>
                                    <div
                                        class="h-12 w-12 rounded-2xl bg-<?php echo $color; ?>-50 dark:bg-<?php echo $color; ?>-900/20 text-<?php echo $color; ?>-500 flex items-center justify-center text-xl mb-4 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                                        <i class="fas <?php echo $tool['icon']; ?>"></i>
                                    </div>

                                    <h3
                                        class="font-black text-lg text-secondary dark:text-white mb-2 group-hover:text-primary transition-colors line-clamp-1">
                                        <?php echo $tool['name']; ?>
                                    </h3>

                                    <p class="text-xs text-gray-500 font-medium leading-relaxed line-clamp-2 mb-4">
                                        <?php echo $tool['desc']; ?>
                                    </p>
                                </div>

                                <div
                                    class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-700/50">
                                    <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest group-hover:text-<?php echo $color; ?>-500 transition-colors">Open
                                        Tool</span>
                                    <div
                                        class="w-6 h-6 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all scale-75 opacity-0 group-hover:scale-100 group-hover:opacity-100">
                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>