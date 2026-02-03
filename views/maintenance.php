<?php
// views/maintenance.php
// Standalone maintenance page - no global header/footer to avoid layout bloat
$siteName = 'SnipTools';
?>
<!DOCTYPE html>
<html lang="en" class="dark"> <!-- Defaulting to dark for premium feel -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - <?php echo $siteName; ?></title>
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
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f8f9fc] dark:bg-[#0f111a] min-h-screen flex items-center justify-center p-6 overflow-hidden">

    <!-- Background Accents -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-[10%] left-[15%] w-64 h-64 bg-primary/10 rounded-full blur-[100px] animate-pulse">
        </div>
        <div class="absolute bottom-[10%] right-[15%] w-96 h-96 bg-primary/5 rounded-full blur-[120px] animate-pulse"
            style="animation-delay: 2s;"></div>
    </div>

    <!-- Minimal Maintenance Box -->
    <div class="max-w-md w-full relative z-10">

        <!-- Logo Area -->
        <div class="flex flex-col items-center mb-10">
            <div
                class="w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-2xl flex items-center justify-center shadow-2xl shadow-primary/30 mb-4 animate-[bounce_3s_infinite]">
                <i class="fas fa-bolt text-white text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black tracking-tighter text-secondary dark:text-white uppercase transition-colors">
                Snip<span class="text-primary italic">Tools</span>
            </h2>
        </div>

        <!-- Glass Card -->
        <div
            class="bg-white dark:bg-white/[0.03] backdrop-blur-2xl border border-gray-100 dark:border-white/[0.08] rounded-[2.5rem] p-10 shadow-2xl text-center relative overflow-hidden">
            <!-- Top Gradient Line -->
            <div
                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary/40 to-transparent">
            </div>

            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-primary/10 text-primary mb-6">
                <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
            </div>

            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">
                Back <span class="text-primary tracking-normal italic">Very</span> Soon
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed font-medium">
                We're currently performing some quick technical upgrades to enhance your experience.
            </p>

            <!-- Progress/Status -->
            <div
                class="flex items-center justify-center space-x-3 mb-8 bg-gray-50 dark:bg-white/5 py-3 px-6 rounded-2xl border border-gray-100 dark:border-white/[0.05]">
                <span class="relative flex h-2.5 w-2.5">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary"></span>
                </span>
                <span
                    class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Maintenance
                    in Progress</span>
            </div>

            <div class="pt-8 border-t border-gray-100 dark:border-white/[0.05]">
                <p class="text-[11px] text-gray-400 font-bold mb-4">Urgent access needed?</p>
                <a href="/admin/login"
                    class="inline-flex items-center justify-center px-8 py-3 bg-secondary dark:bg-white dark:text-secondary text-white rounded-xl text-xs font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-lg">
                    Admin Login
                </a>
            </div>
        </div>

        <!-- Simple Footer -->
        <p class="mt-10 text-[10px] text-center text-gray-400 font-bold uppercase tracking-[0.3em] opacity-50">
            &copy; <?php echo date('Y'); ?> SnipTools Engine
        </p>
    </div>

    <script>
        // Force dark mode implementation from local storage if available
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</body>

</html>