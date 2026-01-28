<?php include_once __DIR__ . '/../includes/header.php'; ?>
<?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-8 custom-scrollbar">
    <div class="max-w-4xl mx-auto min-h-[calc(100vh-250px)]">
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 lg:p-12 mb-12">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-8 tracking-tight">Terms of Service</h1>

            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                <p class="mb-8 font-bold text-primary uppercase tracking-widest text-xs">Last updated:
                    <?php echo date('F Y'); ?></p>

                <p class="mb-6">
                    By accessing and using SnipTools, you accept and agree to be bound by the terms and provision of
                    this agreement.
                </p>

                <h2 class="text-2xl font-black text-gray-800 dark:text-white mt-12 mb-6">Use License</h2>
                <p class="mb-6">
                    Permission is granted to use the tools and services on SnipTools for personal and commercial
                    purposes.
                    You may not attempt to reverse engineer any software contained on SnipTools' website.
                </p>

                <h2 class="text-2xl font-black text-gray-800 dark:text-white mt-12 mb-6">Disclaimer</h2>
                <p class="mb-4">
                    The materials on SnipTools are provided "as is". SnipTools makes no warranties, expressed or
                    implied, and hereby disclaims and negates all other warranties.
                    Further, SnipTools does not warrant or make any representations concerning the accuracy, likely
                    results, or reliability of the use of the materials on its website.
                </p>

                <p class="mb-6">
                    We are not responsible for any data loss or damages resulting from the use of our tools. Please
                    always keep backups of your original files before processing them.
                </p>
            </div>
        </div>
    </div>
    <?php include_once __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>