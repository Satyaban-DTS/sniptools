<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-10 custom-scrollbar">
    <div class="max-w-4xl mx-auto">
        <!-- Elegant Header -->
        <div class="mb-14 animate-slide-up">
            <div class="flex items-center space-x-4 mb-4">
                <div class="h-1 w-12 bg-emerald-500 rounded-full"></div>
                <h1
                    class="text-4xl lg:text-5xl font-black text-secondary dark:text-white tracking-tighter uppercase italic">
                    Support Hub
                </h1>
            </div>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.4em] opacity-50 ml-16">
                Direct transmission & global knowledge base
            </p>
        </div>

        <!-- Sleek Support Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-24 animate-slide-up" style="animation-delay: 0.1s;">
            <!-- Community -->
            <a href="#"
                class="group relative bg-white dark:bg-[#1a1c2e] p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/[0.05] hover:border-primary/50 transition-all duration-500 flex items-center space-x-6 overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-primary/5">
                <div
                    class="absolute -right-6 -top-6 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-all duration-700">
                </div>
                <div
                    class="relative z-10 w-16 h-16 rounded-2xl bg-gray-50 dark:bg-white/[0.03] flex items-center justify-center text-gray-400 group-hover:bg-primary group-hover:text-white group-hover:rotate-6 transition-all duration-500 shadow-inner">
                    <i class="fab fa-discord text-2xl"></i>
                </div>
                <div class="relative z-10 flex-1 min-w-0">
                    <h3
                        class="text-xl font-black text-secondary dark:text-white group-hover:text-primary transition-colors uppercase tracking-tight">
                        Deep Sync</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 opacity-60">2,400+
                        Active Terminals</p>
                </div>
                <div
                    class="relative z-10 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500">
                    <i class="fas fa-chevron-right text-xs text-primary"></i>
                </div>
            </a>

            <!-- GitHub -->
            <a href="#"
                class="group relative bg-white dark:bg-[#1a1c2e] p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/[0.05] hover:border-secondary/50 transition-all duration-500 flex items-center space-x-6 overflow-hidden shadow-sm hover:shadow-2xl">
                <div
                    class="absolute -right-6 -top-6 w-32 h-32 bg-gray-500/5 rounded-full blur-3xl group-hover:bg-gray-500/10 transition-all duration-700">
                </div>
                <div
                    class="relative z-10 w-16 h-16 rounded-2xl bg-gray-50 dark:bg-white/[0.03] flex items-center justify-center text-gray-400 group-hover:bg-secondary dark:group-hover:bg-white group-hover:text-white group-hover:rotate-6 transition-all duration-500 shadow-inner">
                    <i class="fab fa-github text-2xl"></i>
                </div>
                <div class="relative z-10 flex-1 min-w-0">
                    <h3
                        class="text-xl font-black text-secondary dark:text-white group-hover:text-primary transition-colors uppercase tracking-tight">
                        Git Repository</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 opacity-60">Logic &
                        Fault Reporting</p>
                </div>
                <div
                    class="relative z-10 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500">
                    <i class="fas fa-chevron-right text-xs text-primary"></i>
                </div>
            </a>
        </div>

        <!-- Redesigned FAQs -->
        <div class="max-w-3xl animate-slide-up" style="animation-delay: 0.2s;">
            <div class="flex items-center space-x-3 mb-10 px-4">
                <div class="h-4 w-[2px] bg-primary rounded-full"></div>
                <h3 class="text-sm font-black text-secondary dark:text-white uppercase tracking-[0.3em]">Knowledge
                    Directory</h3>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <details
                    class="group bg-white dark:bg-[#1a1c2e] rounded-[2rem] border border-gray-100 dark:border-white/[0.05] transition-all overflow-hidden shadow-sm">
                    <summary class="flex items-center justify-between p-7 cursor-pointer list-none">
                        <span
                            class="text-base font-black text-secondary dark:text-gray-200 group-hover:text-primary transition-colors uppercase tracking-tight">
                            Perpetual Access License?
                        </span>
                        <div
                            class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/[0.03] flex items-center justify-center transition-all group-open:rotate-180 group-hover:bg-primary/10 group-hover:text-primary">
                            <i class="fas fa-plus text-[10px] group-open:hidden"></i>
                            <i class="fas fa-minus text-[10px] hidden group-open:block"></i>
                        </div>
                    </summary>
                    <div
                        class="px-7 pb-8 text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-medium max-w-2xl italic opacity-80">
                        SnipTools operates under a zero-cost philosophy. Every utility node in our repository is free,
                        open-source, and accessible to the global developer collective without subscription barriers.
                    </div>
                </details>

                <!-- FAQ Item 2 -->
                <details
                    class="group bg-white dark:bg-[#1a1c2e] rounded-[2rem] border border-gray-100 dark:border-white/[0.05] transition-all overflow-hidden shadow-sm">
                    <summary class="flex items-center justify-between p-7 cursor-pointer list-none">
                        <span
                            class="text-base font-black text-secondary dark:text-gray-200 group-hover:text-primary transition-colors uppercase tracking-tight">
                            Encryption & Data Sovereignty?
                        </span>
                        <div
                            class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/[0.03] flex items-center justify-center transition-all group-open:rotate-180 group-hover:bg-primary/10 group-hover:text-primary">
                            <i class="fas fa-plus text-[10px] group-open:hidden"></i>
                            <i class="fas fa-minus text-[10px] hidden group-open:block"></i>
                        </div>
                    </summary>
                    <div
                        class="px-7 pb-8 text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-medium max-w-2xl italic opacity-80">
                        Our nodes are strictly client-side. All processing cycles occur within your local sandbox
                        environment. No plaintext parameters, sensitive keys, or temporary files are ever cached on our
                        remote infrastructure.
                    </div>
                </details>

                <!-- FAQ Item 3 -->
                <details
                    class="group bg-white dark:bg-[#1a1c2e] rounded-[2rem] border border-gray-100 dark:border-white/[0.05] transition-all overflow-hidden shadow-sm">
                    <summary class="flex items-center justify-between p-7 cursor-pointer list-none">
                        <span
                            class="text-base font-black text-secondary dark:text-gray-200 group-hover:text-primary transition-colors uppercase tracking-tight">
                            Protocol Contribution?
                        </span>
                        <div
                            class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/[0.03] flex items-center justify-center transition-all group-open:rotate-180 group-hover:bg-primary/10 group-hover:text-primary">
                            <i class="fas fa-plus text-[10px] group-open:hidden"></i>
                            <i class="fas fa-minus text-[10px] hidden group-open:block"></i>
                        </div>
                    </summary>
                    <div
                        class="px-7 pb-8 text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-medium max-w-2xl italic opacity-80">
                        Contribute the future. You are encouraged to fork our repository, refine the logic, and submit
                        pull requests for new utility clusters. We prioritize community-driven innovation above all.
                    </div>
                </details>
            </div>
        </div>
    </div>
    <div class="pb-10"></div>
    <?php include __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>