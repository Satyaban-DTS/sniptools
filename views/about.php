<?php include_once __DIR__ . '/../includes/header.php'; ?>
<?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-8 custom-scrollbar">
    <div class="max-w-4xl mx-auto min-h-[calc(100vh-250px)]">
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 lg:p-12 mb-12">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-8 tracking-tight">About SnipTools</h1>

            <div class="prose dark:prose-invert max-w-none">
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    SnipTools is a curated collection of modern, privacy-focused web utilities designed for developers
                    and content creators.
                    Our mission is to provide fast, reliable, and secure tools that run directly in your browser.
                </p>

                <h2 class="text-2xl font-black text-gray-800 dark:text-white mt-12 mb-6">Why SnipTools?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    <div
                        class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <i class="fas fa-shield-alt text-primary text-2xl mb-4"></i>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Privacy First</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Most of our tools run entirely client-side.
                            Your data never leaves your browser.</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <i class="fas fa-bolt text-accent text-2xl mb-4"></i>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Fast & Responsive</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Built with modern web technologies for
                            instant, lag-free performance.</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <i class="fas fa-eye-slash text-blue-500 text-2xl mb-4"></i>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">No Clutter</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Clean, distraction-free interface focused
                            entirely on utility.</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <i class="fas fa-comment-alt text-emerald-500 text-2xl mb-4"></i>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Open for Feedback</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">We actively listen to our users. Your
                            suggestions shape our roadmap.</p>
                    </div>
                </div>

                <h2 class="text-2xl font-black text-gray-800 dark:text-white mt-12 mb-6">Our Tech Stack</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    SnipTools is built using a lightweight yet powerful stack of PHP, Tailwind CSS, and vanilla
                    JavaScript.
                    By avoiding heavy frameworks where possible, we ensure maximum speed and compatibility across all
                    devices.
                </p>
            </div>
        </div>
    </div>
    <?php include_once __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>