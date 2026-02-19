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
    <link rel="canonical" href="<?php echo isset($canonicalUrl) ? $canonicalUrl : url(); ?>">
    <meta name="robots" content="index, follow">

    <!-- PWA Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?php echo url('sw.js'); ?>')
                    .then(reg => console.log('SW Registered'))
                    .catch(err => console.log('SW Error', err));
            });
        }
    </script>

    <!-- Open Graph / SEO -->
    <meta property="og:site_name" content="<?php echo APP_NAME; ?>">
    <meta property="og:type" content="<?php echo isset($toolName) ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME; ?>">
    <meta property="og:description"
        content="<?php echo isset($metaDescription) ? htmlspecialchars($metaDescription) : 'Premium client-side developer tools for modern web workflows.'; ?>">
    <meta property="og:url" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : url(); ?>">
    <meta property="og:image"
        content="<?php echo isset($toolIcon) ? url('assets/og-tools.png') : url('assets/og-main.png'); ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME; ?>">
    <meta name="twitter:description"
        content="<?php echo isset($metaDescription) ? htmlspecialchars($metaDescription) : 'Premium client-side developer tools for modern web workflows.'; ?>">
    <meta name="twitter:image"
        content="<?php echo isset($toolIcon) ? url('assets/og-tools.png') : url('assets/og-main.png'); ?>">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "<?php echo isset($pageTitle) ? $pageTitle : APP_NAME; ?>",
      "url": "<?php echo isset($canonicalUrl) ? $canonicalUrl : url(); ?>",
      "description": "<?php echo isset($pageDescription) ? $pageDescription : 'Premium client-side developer tools for modern web workflows.'; ?>",
      "applicationCategory": "DeveloperApplication",
      "operatingSystem": "Web",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
      }
    }
    </script>

    <!-- Performance Optimizations: Preconnect and Optimized Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet">
    </noscript>

    <!-- External Assets with Performance Hints -->
    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        media="print" onload="this.media='all'">

    <script>
        // Immediate Theme Application to prevent FOUC
        (function () {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
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
        :root {
            --primary: #c026d3;
            --accent: #ec4899;
            --secondary: #1e152e;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-display: swap;
            -webkit-font-smoothing: antialiased;
            background-color: #f8f9fc;
        }

        .dark body {
            background-color: #0f111a;
        }

        .sidebar-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glassmorphism Utilities */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .glass-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-up {
            animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Shine Effect for Buttons */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }

        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent,
                    rgba(255, 255, 255, 0.1),
                    transparent);
            transform: rotate(45deg);
            transition: 0.5s;
        }

        .btn-shine:hover::after {
            left: 100%;
            top: 100%;
        }

        /* Neon Glow */
        .neon-glow {
            box-shadow: 0 0 15px rgba(192, 38, 211, 0.2);
        }

        .dark .neon-glow {
            box-shadow: 0 0 25px rgba(192, 38, 211, 0.1);
        }

        /* Critical Layout Speed */
        .hero-gradient {
            background: linear-gradient(to right, #1e152e, #2d1b4e) !important;
        }

        @media (max-width: 640px) {
            .animate-slide-up {
                animation-duration: 0.3s !important;
            }

            h1 {
                font-size: 1.875rem !important;
                line-height: 2.25rem !important;
            }

            .hero-text {
                color: #9ca3af !important;
                font-size: 0.875rem !important;
            }
        }
    </style>
</head>

<body
    class="bg-[#f8f9fc] dark:bg-[#0f111a] text-gray-900 dark:text-gray-100 transition-colors duration-200 overflow-hidden">
    <div class="flex flex-col h-screen">
        <!-- Navigation -->
        <header
            class="sticky top-0 z-30 w-full bg-white dark:bg-gray-800/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 h-16 shrink-0 flex items-center shadow-sm dark:shadow-none transition-colors">
            <div class="w-full px-6 flex items-center justify-between">
                <!-- Brand & Logo -->
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggleMobile" aria-label="Toggle Navigation Menu"
                        class="p-2 lg:hidden rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-bars text-sm" aria-hidden="true"></i>
                    </button>
                    <a href="<?php echo url(); ?>" class="flex items-center space-x-2.5 group"
                        aria-label="<?php echo APP_NAME; ?> Home">
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-primary to-accent rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform overflow-hidden">
                            <i class="fas fa-bolt text-white text-base" aria-hidden="true"></i>
                        </div>
                        <div class="hidden sm:block" style="min-width: 120px; min-height: 32px;">
                            <span
                                class="text-lg font-black tracking-tighter text-secondary dark:text-white uppercase">Snip<span
                                    class="text-primary italic">Tools</span></span>
                            <p class="text-[8px] font-bold text-gray-400 tracking-widest uppercase -mt-1 opacity-60">
                                Professional Utilities</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Search -->
                <div class="hidden md:block flex-1 max-w-xl mx-8 relative z-50">
                    <div class="relative w-full group">
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors pointer-events-none z-10">
                            <i class="fas fa-search text-xs" aria-hidden="true"></i>
                        </div>
                        <label for="mainSearch" class="sr-only">Search Tools</label>
                        <input type="text" id="mainSearch" placeholder="Type / to search tools..."
                            class="w-full pl-11 pr-14 py-2.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:bg-white dark:focus:bg-gray-900 focus:border-primary dark:focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all text-sm outline-none placeholder:text-gray-400 font-medium shadow-inner dark:shadow-none">
                        <div
                            class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center space-x-1 pointer-events-none">
                            <kbd class="px-1.5 py-0.5 rounded-md border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-[10px] text-gray-400 font-sans shadow-sm"
                                aria-hidden="true">
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
                <div class="flex items-center space-x-3">
                    <button id="darkModeToggleHeader" aria-label="Toggle Dark Mode"
                        class="p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 hover:text-primary transition-all">
                        <i class="fas fa-moon dark:hidden text-sm" aria-hidden="true"></i>
                        <i class="fas fa-sun hidden dark:block text-yellow-500 text-sm" aria-hidden="true"></i>
                    </button>
                    <div class="h-6 w-[1px] bg-gray-200 dark:bg-gray-700 mx-1"></div>
                    <button onclick="document.getElementById('freeForeverModal').classList.remove('hidden')"
                        aria-label="Learn about Free Forever"
                        class="bg-secondary dark:bg-white dark:text-secondary text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider hover:scale-105 active:scale-95 transition-all shadow-xl shadow-secondary/20 dark:shadow-white/10 flex items-center">
                        <i class="fas fa-heart text-red-500 mr-1.5 animate-pulse text-xs" aria-hidden="true"></i>
                        Free Forever
                    </button>
                </div>
            </div>
        </header>

        <!-- Search logic moved to footer for performance -->

        <div id="freeForeverModal"
            class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-secondary/80 backdrop-blur-xl transition-all duration-500">
            <div class="glass-card rounded-[3rem] w-full max-w-lg p-10 shadow-2xl relative scale-100 animate-slide-up">
                <button onclick="document.getElementById('freeForeverModal').classList.add('hidden')"
                    class="absolute top-8 right-8 p-3 rounded-2xl hover:bg-white/10 text-gray-400 hover:text-white transition-all">
                    <i class="fas fa-times"></i>
                </button>

                <div class="text-center mb-10">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-primary to-accent rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-white shadow-2xl shadow-primary/20 animate-bounce">
                        <i class="fas fa-heart text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-secondary dark:text-white mb-3 tracking-tighter">Powered by
                        Community</h2>
                    <p
                        class="text-[11px] text-gray-500 dark:text-gray-400 font-black uppercase tracking-[0.2em] opacity-60">
                        SnipTools is 100% Free Forever</p>
                </div>

                <div class="space-y-4 mb-10">
                    <div class="flex items-start bg-white/50 dark:bg-white/5 p-6 rounded-3xl border border-white/20">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 mr-4">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-secondary dark:text-white uppercase tracking-tight">100%
                                Free & Open</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 font-medium leading-relaxed">No
                                subscriptions, no hidden fees. Just great tools for everyone.</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-white/50 dark:bg-white/5 p-6 rounded-3xl border border-white/20">
                        <div
                            class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary mr-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-secondary dark:text-white uppercase tracking-tight">
                                Privacy First</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 font-medium leading-relaxed">
                                Tools run locally in your browser. Your data never leaves your device.</p>
                        </div>
                    </div>
                </div>

                <button onclick="document.getElementById('freeForeverModal').classList.add('hidden')"
                    class="w-full py-5 bg-gradient-to-r from-primary to-accent text-white rounded-[1.5rem] font-black uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-primary/30 btn-shine">
                    Awesome, I'm In! 🚀
                </button>

                <p class="text-[9px] text-center text-gray-400 mt-6 font-black uppercase tracking-[0.3em] opacity-40">
                    Handcrafted for modern developers</p>
            </div>
        </div>

        <div class="flex-1 flex overflow-hidden relative">