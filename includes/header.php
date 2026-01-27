<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME . ' - Free Developer Tools & Utilities'; ?>
    </title>
    <meta name="description"
        content="<?php echo isset($metaDescription) ? htmlspecialchars($metaDescription) : 'Free, secure, and client-side developer tools. Word counter, JSON formatter, Base64 converter, and more.'; ?>">
    <meta name="keywords"
        content="<?php echo isset($metaKeywords) ? htmlspecialchars($metaKeywords) : 'developer tools, text utilities, image converters, tailwind generator, secure tools'; ?>">
    <meta name="canonical" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : url(); ?>">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="<?php echo url('favicon.ico'); ?>" type="image/x-icon">

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle : APP_NAME; ?>">
    <meta property="og:description"
        content="<?php echo isset($metaDescription) ? htmlspecialchars($metaDescription) : 'Free developer tools for everyday tasks.'; ?>">
    <meta property="og:url" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : url(); ?>">
    <meta property="og:type" content="website">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "<?php echo isset($pageTitle) ? $pageTitle : APP_NAME; ?>",
        "applicationCategory": "DeveloperApplication",
        "operatingSystem": "Web",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "description": "<?php echo isset($metaDescription) ? htmlspecialchars($metaDescription) : 'Free, secure, and client-side developer tools.'; ?>"
    }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#c026d3',
                        secondary: '#1e152e',
                        accent: '#ec4899',
                        surface: '#f8f9fc',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
    </style>
    <?php
    // Inject Head Script if enabled
    // We assume $pdo is available or we fetch it. 
    // To be safe and efficient, we can check if it's already loaded or fetch.
    if (!isset($settings['ad_code_head']) && isset($pdo)) {
        $settings['ad_code_head'] = $pdo->query("SELECT value FROM settings WHERE `key`='ad_code_head'")->fetchColumn();
    }
    if (!empty($settings['ad_code_head'])) {
        echo $settings['ad_code_head'];
    }
    ?>
</head>

<body
    class="bg-[#f8f9fc] dark:bg-[#0f111a] text-gray-900 dark:text-gray-100 transition-colors duration-200 overflow-hidden">
    <div class="flex flex-col h-screen">
        <!-- Navigation -->
        <header
            class="sticky top-0 z-30 w-full bg-white dark:bg-gray-800/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 h-20 shrink-0 flex items-center shadow-sm dark:shadow-none transition-colors">
            <div class="w-full px-8 flex items-center justify-between">
                <!-- Brand & Logo -->
                <div class="flex items-center space-x-6">
                    <button id="sidebarToggleMobile"
                        class="p-2 lg:hidden rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="<?php echo url(); ?>" class="flex items-center space-x-3 group">
                        <div
                            class="w-11 h-11 bg-gradient-to-br from-primary to-accent rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform">
                            <i class="fas fa-bolt text-white text-xl"></i>
                        </div>
                        <div class="hidden sm:block">
                            <span
                                class="text-2xl font-black tracking-tighter text-secondary dark:text-white uppercase">Snip<span
                                    class="text-primary italic">Tools</span></span>
                            <p class="text-[9px] font-bold text-gray-400 tracking-widest uppercase -mt-1 opacity-60">
                                Professional Utilities</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Search -->
                <div class="hidden md:block flex-1 max-w-xl mx-12 relative z-50">
                    <div class="relative w-full group">
                        <div
                            class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors pointer-events-none z-10">
                            <i class="fas fa-search text-sm"></i>
                        </div>
                        <input type="text" id="mainSearch" placeholder="Type / to search tools..."
                            class="w-full pl-14 pr-16 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:bg-white dark:focus:bg-gray-900 focus:border-primary dark:focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all text-sm outline-none placeholder:text-gray-400 font-medium shadow-inner dark:shadow-none">
                        <div
                            class="absolute right-5 top-1/2 -translate-y-1/2 flex items-center space-x-1 pointer-events-none">
                            <kbd
                                class="px-2 py-1 rounded-md border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-[10px] text-gray-400 font-sans shadow-sm">
                                /
                            </kbd>
                        </div>

                        <!-- Search Dropdown Results -->
                        <div id="searchResults"
                            class="hidden absolute top-full left-0 right-0 mt-3 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-2xl overflow-hidden max-h-[400px] overflow-y-auto custom-scrollbar">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-4">
                    <button id="darkModeToggleHeader"
                        class="p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-primary transition-all">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:block text-yellow-500"></i>
                    </button>
                    <div class="h-8 w-[1px] bg-gray-200 dark:bg-gray-700 mx-2"></div>
                    <button onclick="document.getElementById('freeForeverModal').classList.remove('hidden')"
                        class="bg-secondary dark:bg-white dark:text-secondary text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-wider hover:scale-105 active:scale-95 transition-all shadow-xl shadow-secondary/20 dark:shadow-white/10 flex items-center">
                        <i class="fas fa-heart text-red-500 mr-2 animate-pulse"></i>
                        Free Forever
                    </button>
                </div>
            </div>
        </header>

        <!-- Search Logic -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const searchInput = document.getElementById('mainSearch');
                const resultsContainer = document.getElementById('searchResults');
                const toolsData = [
                    // Generate tools list from PHP
                    <?php
                    if (isset($tools)) {
                        foreach ($tools as $slug => $data) {
                            $cat = $data['category'] ?? 'uncategorized';
                            echo "{ name: '" . addslashes($data['name']) . "', slug: '$slug', category: '$cat', icon: '" . $data['icon'] . "', desc: '" . addslashes($data['desc']) . "' },";
                        }
                    }
                    ?>
                ];

                // Keyboard Shortcut
                document.addEventListener('keydown', (e) => {
                    if (e.key === '/' && document.activeElement !== searchInput) {
                        e.preventDefault();
                        searchInput.focus();
                    }
                    if (e.key === 'Escape') {
                        resultsContainer.classList.add('hidden');
                        searchInput.blur();
                    }
                });

                searchInput.addEventListener('input', (e) => {
                    const query = e.target.value.toLowerCase().trim();
                    if (query.length === 0) {
                        resultsContainer.classList.add('hidden');
                        return;
                    }

                    const filtered = toolsData.filter(tool =>
                        tool.name.toLowerCase().includes(query) ||
                        tool.desc.toLowerCase().includes(query)
                    );

                    if (filtered.length > 0) {
                        resultsContainer.innerHTML = filtered.map(tool => `
                            <a href="<?php echo url('tools/'); ?>${tool.category}/${tool.slug}" class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-50 dark:border-gray-700/50 last:border-0 transition-colors group">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                    <i class="fas ${tool.icon}"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">${tool.name}</h4>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 line-clamp-1">${tool.desc}</p>
                                </div>
                            </a>
                        `).join('');
                        resultsContainer.classList.remove('hidden');
                    } else {
                        resultsContainer.innerHTML = `
                            <div class="p-8 text-center text-gray-400">
                                <i class="fas fa-search mb-2 text-xl"></i>
                                <p class="text-xs font-bold">No tools found for "${query}"</p>
                            </div>
                        `;
                        resultsContainer.classList.remove('hidden');
                    }
                });

                // Click outside to close
                document.addEventListener('click', (e) => {
                    if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                        resultsContainer.classList.add('hidden');
                    }
                });
            });
        </script>

        <!-- Free Forever Modal -->
        <div id="freeForeverModal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-opacity">
            <div
                class="bg-white dark:bg-gray-800 rounded-[2rem] w-full max-w-lg p-8 shadow-2xl border border-gray-100 dark:border-gray-700 relative scale-100 animate-[fadeIn_0.2s_ease-out]">
                <button onclick="document.getElementById('freeForeverModal').classList.add('hidden')"
                    class="absolute top-6 right-6 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 transition-colors">
                    <i class="fas fa-times"></i>
                </button>

                <div class="text-center mb-6">
                    <div
                        class="w-16 h-16 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4 text-red-500 animate-bounce">
                        <i class="fas fa-heart text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-secondary dark:text-white mb-2">Powered by Community</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">SnipTools is tailored for
                        developers, by developers.</p>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex items-start bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-bold text-secondary dark:text-white">100% Free & Open</h4>
                            <p class="text-xs text-gray-500 mt-1">No subscriptions, no hidden fees. Just great tools.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl">
                        <i class="fas fa-shield-alt text-primary mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-bold text-secondary dark:text-white">Privacy First</h4>
                            <p class="text-xs text-gray-500 mt-1">Tools run locally in your browser. Your data never
                                leaves your device.</p>
                        </div>
                    </div>
                </div>

                <button onclick="document.getElementById('freeForeverModal').classList.add('hidden')"
                    class="w-full py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-xl font-bold uppercase tracking-wider hover:scale-[1.02] active:scale-95 transition-all">
                    Awesome, I'm In! 🚀
                </button>

                <p class="text-[10px] text-center text-gray-400 mt-4 font-bold uppercase tracking-widest">Spread the
                    word to support us</p>
            </div>
        </div>

        <div class="flex-1 flex overflow-hidden relative">