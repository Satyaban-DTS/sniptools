<?php
// web/views/tools/tailwind-components.php
?>
<div class="space-y-12 pb-20">
    <!-- Buttons Section -->
    <section class="space-y-6">
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] px-1">Modern Buttons</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Glass Button -->
            <div
                class="p-8 bg-gray-50 dark:bg-gray-900/30 rounded-[2.5rem] border border-transparent hover:border-primary/10 transition-all flex flex-col items-center justify-center space-y-6 group">
                <button
                    class="px-8 py-3.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-sm font-bold shadow-xl">Glassmorphism</button>
                <button onclick="copyComponent('glass-btn')"
                    class="text-[10px] font-black text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">Copy
                    Code</button>
                <template id="glass-btn">
                    <button
                        class="px-8 py-3.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-sm font-bold shadow-xl">Glassmorphism</button>
                </template>
            </div>

            <!-- Gradient Button -->
            <div
                class="p-8 bg-gray-50 dark:bg-gray-900/30 rounded-[2.5rem] border border-transparent hover:border-primary/10 transition-all flex flex-col items-center justify-center space-y-6 group">
                <button
                    class="px-8 py-3.5 bg-gradient-to-r from-primary to-accent text-white rounded-2xl text-sm font-bold shadow-lg shadow-primary/25 hover:scale-105 transition-all">Gradient
                    Glow</button>
                <button onclick="copyComponent('grad-btn')"
                    class="text-[10px] font-black text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">Copy
                    Code</button>
                <template id="grad-btn">
                    <button
                        class="px-8 py-3.5 bg-gradient-to-r from-primary to-accent text-white rounded-2xl text-sm font-bold shadow-lg shadow-primary/25 hover:scale-105 transition-all">Gradient
                        Glow</button>
                </template>
            </div>

            <!-- Neu-Dark Button -->
            <div
                class="p-8 bg-gray-50 dark:bg-gray-900/30 rounded-[2.5rem] border border-transparent hover:border-primary/10 transition-all flex flex-col items-center justify-center space-y-6 group">
                <button
                    class="px-8 py-3.5 bg-gray-900 text-gray-400 rounded-2xl text-sm font-bold border border-white/5 shadow-[5px_5px_15px_rgba(0,0,0,0.5),-5px_-5px_15px_rgba(255,255,255,0.02)] active:shadow-inner transition-all">Neu-Dark</button>
                <button onclick="copyComponent('neu-btn')"
                    class="text-[10px] font-black text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">Copy
                    Code</button>
                <template id="neu-btn">
                    <button
                        class="px-8 py-3.5 bg-gray-900 text-gray-400 rounded-2xl text-sm font-bold border border-white/5 shadow-[5px_5px_15px_rgba(0,0,0,0.5),-5px_-5px_15px_rgba(255,255,255,0.02)] active:shadow-inner transition-all">Neu-Dark</button>
                </template>
            </div>
        </div>
    </section>

    <!-- Inputs Section -->
    <section class="space-y-6">
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] px-1">Modern Inputs</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Animated Label Input -->
            <div
                class="p-10 bg-gray-50 dark:bg-gray-900/30 rounded-[3rem] border border-transparent hover:border-primary/10 transition-all space-y-8 group">
                <div class="relative w-full">
                    <input type="text" placeholder=" "
                        class="peer w-full px-5 py-4 bg-transparent border-2 border-gray-200 dark:border-gray-800 rounded-2xl outline-none focus:border-primary transition-all text-sm font-medium">
                    <label
                        class="absolute left-5 top-4 text-gray-400 text-sm transition-all peer-focus:-top-2.5 peer-focus:left-4 peer-focus:text-xs peer-focus:px-2 peer-focus:bg-white dark:peer-focus:bg-gray-900 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:text-xs peer-not-placeholder-shown:px-2 peer-not-placeholder-shown:bg-white dark:peer-not-placeholder-shown:bg-gray-900">Full
                        Name</label>
                </div>
                <button onclick="copyComponent('input-anim')"
                    class="text-[10px] font-black text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">Copy
                    HTML</button>
                <template id="input-anim">
                    <div class="relative w-full">
                        <input type="text" placeholder=" "
                            class="peer w-full px-5 py-4 bg-transparent border-2 border-gray-200 dark:border-gray-800 rounded-2xl outline-none focus:border-primary transition-all text-sm font-medium">
                        <label
                            class="absolute left-5 top-4 text-gray-400 text-sm transition-all peer-focus:-top-2.5 peer-focus:left-4 peer-focus:text-xs peer-focus:px-2 peer-focus:bg-white dark:peer-focus:bg-gray-900 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:text-xs peer-not-placeholder-shown:px-2 peer-not-placeholder-shown:bg-white dark:peer-not-placeholder-shown:bg-gray-900">Full
                            Name</label>
                    </div>
                </template>
            </div>

            <!-- Search Field -->
            <div
                class="p-10 bg-gray-50 dark:bg-gray-900/30 rounded-[3rem] border border-transparent hover:border-primary/10 transition-all space-y-8 group">
                <div class="relative">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search resources..."
                        class="w-full pl-12 pr-6 py-4 bg-gray-100 dark:bg-gray-800/50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-sm font-medium transition-all">
                </div>
                <button onclick="copyComponent('search-field')"
                    class="text-[10px] font-black text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">Copy
                    HTML</button>
                <template id="search-field">
                    <div class="relative">
                        <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search resources..."
                            class="w-full pl-12 pr-6 py-4 bg-gray-100 dark:bg-gray-800/50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-sm font-medium transition-all">
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- Cards Section -->
    <section class="space-y-6">
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] px-1">Modern Cards</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Stats Card -->
            <div
                class="p-8 bg-gray-50 dark:bg-gray-900/30 rounded-[3rem] border border-transparent hover:border-primary/10 transition-all space-y-8 group">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-white/5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span
                            class="text-xs font-black text-green-500 bg-green-500/10 px-3 py-1 rounded-full">+14.2%</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Global Analytics</p>
                        <p class="text-2xl font-black text-secondary dark:text-white">$42,900</p>
                    </div>
                </div>
                <button onclick="copyComponent('stats-card')"
                    class="text-[10px] font-black text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">Copy
                    Full Card HTML</button>
                <template id="stats-card">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-white/5 space-y-4">
                        <div class="flex items-center justify-between">
                            <div
                                class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span
                                class="text-xs font-black text-green-500 bg-green-500/10 px-3 py-1 rounded-full">+14.2%</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Global Analytics
                            </p>
                            <p class="text-2xl font-black text-secondary dark:text-white">$42,900</p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</div>

<script>
    function copyComponent(id) {
        const template = document.getElementById(id);
        const html = template.innerHTML.trim();
        navigator.clipboard.writeText(html);

        // Notification logic could be added
    }
</script>