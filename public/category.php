<?php
// web/public/category.php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

$categorySlug = $categorySlug ?? 'developer'; // Fallback or handle error
$catTools = array_filter($tools, function ($t) use ($categorySlug) {
    return isset($t['category']) && $t['category'] === $categorySlug;
});
?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-8 lg:p-12 custom-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumbs -->
        <nav
            class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-8 px-2">
            <a href="<?php echo url('tools'); ?>" class="hover:text-primary transition-colors">Tools</a>
            <i class="fas fa-chevron-right text-[8px] opacity-30"></i>
            <span class="text-secondary dark:text-white">
                <?php echo $pageTitle; ?>
            </span>
        </nav>

        <div class="mb-14">
            <h1 class="text-4xl lg:text-5xl font-black text-secondary dark:text-white tracking-tighter mb-4">
                <?php echo $pageTitle; ?>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl font-medium leading-relaxed">
                Browse our collection of high-performance
                <?php echo strtolower($pageTitle); ?> designed for modern web development workflows.
            </p>
        </div>

        <!-- Category Header Ad -->
        <div class="mb-14">
            <?php
            $placement = 'header';
            include __DIR__ . '/../includes/ad-unit.php';
            ?>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 animate-slide-up">
            <?php foreach ($catTools as $slug => $tool): ?>
                <a href="<?php echo getToolUrl($slug, $tool); ?>"
                    class="group relative bg-white dark:bg-[#1a1c2e] p-6 rounded-[2rem] border border-gray-100 dark:border-white/[0.05] hover:border-primary/50 shadow-sm hover:shadow-[0_20px_50px_rgba(192,38,211,0.1)] hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col items-center text-center">

                    <!-- Decorative Radial Glow -->
                    <div
                        class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/15 transition-all duration-700">
                    </div>

                    <div class="relative mb-6">
                        <div
                            class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-primary/30">
                            <i
                                class="fas <?php echo $tool['icon']; ?> text-2xl group-hover:scale-110 transition-transform"></i>
                        </div>
                    </div>

                    <div class="relative z-10 w-full flex flex-col items-center">
                        <h3
                            class="font-black text-base text-secondary dark:text-white group-hover:text-primary transition-colors tracking-tight uppercase mb-2">
                            <?php echo $tool['name']; ?>
                        </h3>
                        <p
                            class="text-[11px] text-gray-500 dark:text-gray-400 font-medium line-clamp-2 opacity-70 italic mb-4">
                            "<?php echo $tool['desc']; ?>"
                        </p>

                        <div
                            class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-gray-50 dark:bg-white/5 border border-transparent group-hover:border-primary/20 transition-all">
                            <i class="fas fa-bolt text-[10px] text-primary/50"></i>
                            <span
                                class="text-[9px] font-black text-gray-400 group-hover:text-primary uppercase tracking-widest">Execute
                                Node</span>
                        </div>
                    </div>

                    <!-- Decorative Bottom Bar -->
                    <div
                        class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-transparent via-primary to-transparent w-full opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="pb-10"></div>
    <?php include __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>