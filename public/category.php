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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($catTools as $slug => $tool): ?>
                <a href="<?php echo getToolUrl($slug, $tool); ?>"
                    class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-2xl transition-all group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary mb-8 transition-all">
                        <i class="fas <?php echo $tool['icon']; ?> text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h3 class="text-xl font-black mb-3 group-hover:text-primary transition-colors">
                        <?php echo $tool['name']; ?>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed font-medium">
                        <?php echo $tool['desc']; ?>
                    </p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>