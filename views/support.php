<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-10 custom-scrollbar">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div
                class="w-16 h-16 rounded-2xl bg-emerald-500/10 flex items-center justify-center mx-auto mb-6 text-emerald-500 animate-bounce">
                <i class="fas fa-life-ring text-3xl"></i>
            </div>
            <h1 class="text-4xl font-black text-secondary dark:text-white mb-4 tracking-tight">How can we help?</h1>
            <p class="text-gray-500 text-lg">Browse our FAQs or reach out to the community.</p>
        </div>

        <!-- Support Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <!-- Community -->
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all group">
                <div
                    class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fab fa-discord"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary dark:text-white mb-2">Join the Community</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">Connect with other developers,
                    share utility ideas, and report bugs directly to our team.</p>
                <a href="#"
                    class="inline-flex items-center text-primary font-bold uppercase tracking-wider text-xs hover:underline">
                    Join Discord <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>

            <!-- GitHub Issues -->
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all group">
                <div
                    class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fab fa-github"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary dark:text-white mb-2">Report a Bug</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">Found something broken? Open an
                    issue on our GitHub repository and we'll fix it ASAP.</p>
                <a href="#"
                    class="inline-flex items-center text-secondary dark:text-white font-bold uppercase tracking-wider text-xs hover:underline">
                    Open Issue <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- FAQs -->
        <div class="space-y-4">
            <h3 class="text-xl font-black text-secondary dark:text-white mb-6 px-4">Frequently Asked Questions</h3>

            <details
                class="group bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                    <span class="font-bold text-secondary dark:text-white">Is SnipTools really free?</span>
                    <span class="transition group-open:rotate-180">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </span>
                </summary>
                <div class="px-6 pb-6 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Yes! SnipTools is 100% free and open-source. We believe essential developer utilities should be
                    accessible to everyone without paywalls or subscriptions.
                </div>
            </details>

            <details
                class="group bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                    <span class="font-bold text-secondary dark:text-white">Is my data safe?</span>
                    <span class="transition group-open:rotate-180">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </span>
                </summary>
                <div class="px-6 pb-6 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Absolutely. All data processing (like image compression, JSON formatting, etc.) happens entirely
                    within your browser. No data is ever sent to our servers.
                </div>
            </details>

            <details
                class="group bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                    <span class="font-bold text-secondary dark:text-white">Can I contribute new tools?</span>
                    <span class="transition group-open:rotate-180">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </span>
                </summary>
                <div class="px-6 pb-6 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    We'd love that! Check out our GitHub repository to submit pull requests for new tools or
                    improvements to existing ones.
                </div>
            </details>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>