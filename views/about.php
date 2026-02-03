<?php include_once __DIR__ . '/../includes/header.php'; ?>
<?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-8 custom-scrollbar">
    <div class="max-w-4xl mx-auto min-h-[calc(100vh-250px)]">
        <div
            class="bg-white dark:bg-[#1a1c2e] rounded-[3rem] shadow-2xl border border-gray-100 dark:border-white/[0.05] p-10 lg:p-20 mb-12 relative overflow-hidden animate-slide-up">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-32 -mt-32"></div>

            <header class="relative z-10 mb-16">
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-primary/10 rounded-full mb-6">
                    <i class="fas fa-fingerprint text-[10px] text-primary"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest text-primary">Our DNA</span>
                </div>
                <h1
                    class="text-5xl lg:text-6xl font-black text-secondary dark:text-white mb-6 tracking-tighter uppercase italic">
                    About <span
                        class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">SnipTools</span>
                </h1>
                <p class="text-xl text-gray-500 dark:text-gray-400 font-medium leading-relaxed max-w-2xl">
                    A curated collection of high-performance web utilities designed to empower modern development
                    workflows without compromising privacy.
                </p>
            </header>

            <div class="relative z-10">
                <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mb-10 opacity-60">
                    Architectural Principles</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20 text-center md:text-left">
                    <div
                        class="group p-8 rounded-[2.5rem] bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/5 hover:border-primary/30 transition-all duration-500">
                        <div
                            class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 mx-auto md:mx-0 group-hover:bg-primary group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-shield-halved text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-black text-secondary dark:text-white mb-3 uppercase tracking-tight">
                            Privacy First</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-medium">99% of our
                            utilities execute strictly on the client-side. Your sensitive parameters never touch our
                            cloud infrastructure.</p>
                    </div>

                    <div
                        class="group p-8 rounded-[2.5rem] bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/5 hover:border-accent/30 transition-all duration-500">
                        <div
                            class="w-14 h-14 bg-accent/10 rounded-2xl flex items-center justify-center text-accent mb-6 mx-auto md:mx-0 group-hover:bg-accent group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-bolt-lightning text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-black text-secondary dark:text-white mb-3 uppercase tracking-tight">Zero
                            Latency</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-medium">Built with
                            optimized vanilla JS kernels for near-instant execution, bypassing the overhead of heavy
                            virtual machines.</p>
                    </div>

                    <div
                        class="group p-8 rounded-[2.5rem] bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/5 hover:border-blue-500/30 transition-all duration-500">
                        <div
                            class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500 mb-6 mx-auto md:mx-0 group-hover:bg-blue-500 group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-eye-slash text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-black text-secondary dark:text-white mb-3 uppercase tracking-tight">Pure
                            Utility</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-medium">Eliminating the
                            noise. SnipTools provides a surgically clean environment focused entirely on the task at
                            hand.</p>
                    </div>

                    <div
                        class="group p-8 rounded-[2.5rem] bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/5 hover:border-emerald-500/30 transition-all duration-500">
                        <div
                            class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 mb-6 mx-auto md:mx-0 group-hover:bg-emerald-500 group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-satellite-dish text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-black text-secondary dark:text-white mb-3 uppercase tracking-tight">
                            Community Fed</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-medium">Our roadmap is
                            dictated by you. Every signal from the feedback hub directly influences the next generation
                            of nodes.</p>
                    </div>
                </div>

                <div
                    class="p-10 lg:p-14 bg-secondary dark:bg-black rounded-[3rem] text-white relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-transparent to-accent/10"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                        <div class="flex-1">
                            <h2 class="text-3xl font-black mb-6 tracking-tight uppercase">The Stack</h2>
                            <p class="text-gray-400 text-lg leading-relaxed font-medium">
                                SnipTools leverages a precision-engineered stack of PHP, Tailwind CSS, and Vanilla
                                JavaScript. By avoiding framework abstraction, we achieve peak performance and universal
                                compatibility.
                            </p>
                        </div>
                        <div class="flex -space-x-4">
                            <div
                                class="w-20 h-20 rounded-full bg-white/5 backdrop-blur-md border border-white/10 flex items-center justify-center text-2xl">
                                <i class="fab fa-php"></i>
                            </div>
                            <div
                                class="w-20 h-20 rounded-full bg-white/5 backdrop-blur-md border border-white/10 flex items-center justify-center text-2xl">
                                <i class="fab fa-js"></i>
                            </div>
                            <div
                                class="w-20 h-20 rounded-full bg-white/5 backdrop-blur-md border border-white/10 flex items-center justify-center text-2xl">
                                <i class="fas fa-wind"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-10"></div>
    <?php include_once __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>