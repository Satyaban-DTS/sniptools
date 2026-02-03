<?php
// views/admin/layout_header.php
require_once __DIR__ . '/../../includes/auth.php';
checkAdmin();

$currentRoute = $subRoute ?? '';
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $pageTitle ?? 'Admin Dashboard'; ?> -
        <?php echo APP_NAME; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .admin-sidebar-item.active {
            background: rgba(192, 38, 211, 0.1);
            color: #c026d3;
        }

        /* Tooltip styles */
        .sidebar-tooltip {
            position: fixed;
            padding: 8px 12px;
            background: #1f2937;
            color: white;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s, transform 0.2s;
            z-index: 9999;
            display: none;
        }

        .sidebar-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #1f2937;
        }

        /* Hide internal tooltips - only global tooltip should show */
        .admin-sidebar-item .sidebar-tooltip {
            display: none !important;
            opacity: 0 !important;
        }

        /* Admin Sidebar Collapse Styles */
        #adminSidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #adminSidebar.collapsed {
            width: 80px;
        }

        #adminSidebar.collapsed .sidebar-text,
        #adminSidebar.collapsed nav p {
            display: none;
        }

        #adminSidebar.collapsed .admin-sidebar-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
            margin-left: 12px;
            margin-right: 12px;
        }

        #adminSidebar.collapsed .admin-sidebar-item i {
            margin-right: 0;
        }

        #adminSidebar.collapsed .logo-text {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            const collapseBtn = document.getElementById('sidebarCollapseBtnDesktop');

            // Restore state
            if (localStorage.adminSidebarCollapsed === 'true') {
                sidebar.classList.add('collapsed');
            }

            if (collapseBtn) {
                collapseBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('collapsed');
                    localStorage.adminSidebarCollapsed = sidebar.classList.contains('collapsed');
                    // Reset tooltips on toggle to avoid ghosting
                    if (globalTooltip) globalTooltip.style.display = 'none';
                });
            }

            // Global Tooltip Logic
            const sidebarItems = document.querySelectorAll('.admin-sidebar-item');
            const globalTooltip = document.createElement('div');
            globalTooltip.className = 'sidebar-tooltip';
            globalTooltip.style.position = 'fixed';
            globalTooltip.style.zIndex = '9999';
            document.body.appendChild(globalTooltip);

            sidebarItems.forEach(item => {
                const tooltipText = item.querySelector('.sidebar-tooltip');
                if (!tooltipText) return;
                const text = tooltipText.textContent;

                item.addEventListener('mouseenter', function () {
                    if (sidebar.classList.contains('collapsed')) {
                        const rect = item.getBoundingClientRect();
                        globalTooltip.textContent = text;
                        globalTooltip.style.left = (rect.right + 12) + 'px';
                        globalTooltip.style.top = (rect.top + rect.height / 2) + 'px';
                        globalTooltip.style.transform = 'translateY(-50%)';
                        globalTooltip.style.display = 'block';
                        setTimeout(() => globalTooltip.style.opacity = '1', 10);
                    }
                });

                item.addEventListener('mouseleave', function () {
                    globalTooltip.style.opacity = '0';
                    setTimeout(() => {
                        if (globalTooltip.style.opacity === '0') {
                            globalTooltip.style.display = 'none';
                        }
                    }, 200);
                });
            });
        });
    </script>
</head>

<body class="bg-[#f8f9fc] dark:bg-[#0f111a] text-gray-900 dark:text-gray-100 min-h-screen flex flex-col lg:flex-row">

    <!-- Mobile Header -->
    <header
        class="lg:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-2.5 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center space-x-2.5">
            <div class="w-7 h-7 bg-primary rounded-lg flex items-center justify-center">
                <i class="fas fa-hammer text-white text-xs"></i>
            </div>
            <span class="font-black uppercase tracking-tighter text-sm">Admin Panel</span>
        </div>
        <button id="mobileMenuBtn" class="text-gray-500 hover:text-primary transition-colors">
            <i class="fas fa-bars text-lg"></i>
        </button>
    </header>

    <!-- Sidebar Layout -->
    <aside id="adminSidebar"
        class="fixed inset-y-0 left-0 z-40 w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full lg:translate-x-0 lg:static transition-colors duration-300 ease-in-out flex flex-col shadow-2xl lg:shadow-none">
        <!-- Logo Section -->
        <div class="p-4 border-b border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
            <a href="<?php echo url(); ?>" class="flex items-center space-x-2.5 group overflow-hidden">
                <div
                    class="w-9 h-9 bg-gradient-to-br from-primary to-accent rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform shrink-0">
                    <i class="fas fa-hammer text-white text-base"></i>
                </div>
                <div class="logo-text">
                    <span class="text-lg font-black tracking-tighter uppercase whitespace-nowrap">Admin<span
                            class="text-primary italic">Panel</span></span>
                </div>
            </a>
            <button id="sidebarCollapseBtnDesktop"
                class="hidden lg:flex w-8 h-8 items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 border border-gray-200 dark:border-gray-600 transition-colors">
                <i class="fas fa-angles-left text-xs group-[.collapsed]:rotate-180"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            <p class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2 opacity-50">Operations
            </p>

            <a href="<?php echo url('admin/dashboard'); ?>"
                class="admin-sidebar-item relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold transition-all hover:bg-gray-50 dark:hover:bg-white/5 <?php echo ($currentRoute === 'dashboard') ? 'active' : 'text-gray-500 dark:text-gray-400'; ?>">
                <i class="fas fa-chart-line w-6 mr-3 text-lg opacity-70"></i>
                <span class="sidebar-text">Dashboard</span>
                <span class="sidebar-tooltip">Dashboard</span>
            </a>

            <a href="<?php echo url('admin/feedback'); ?>"
                class="admin-sidebar-item relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold transition-all hover:bg-gray-50 dark:hover:bg-white/5 <?php echo ($currentRoute === 'feedback') ? 'active' : 'text-gray-500 dark:text-gray-400'; ?>">
                <i class="fas fa-comments w-6 mr-3 text-lg opacity-70"></i>
                <span class="sidebar-text">User Feedback</span>
                <span class="sidebar-tooltip">User Feedback</span>
            </a>

            <a href="<?php echo url('admin/activity'); ?>"
                class="admin-sidebar-item relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold transition-all hover:bg-gray-50 dark:hover:bg-white/5 <?php echo ($currentRoute === 'activity') ? 'active' : 'text-gray-500 dark:text-gray-400'; ?>">
                <i class="fas fa-history w-6 mr-3 text-lg opacity-70"></i>
                <span class="sidebar-text">Activity Log</span>
                <span class="sidebar-tooltip">Activity Log</span>
            </a>

            <div class="pt-3">
                <p class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2 opacity-50">Content
                </p>

                <a href="<?php echo url('admin/categories'); ?>"
                    class="admin-sidebar-item relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold transition-all hover:bg-gray-50 dark:hover:bg-white/5 <?php echo ($currentRoute === 'categories') ? 'active' : 'text-gray-500 dark:text-gray-400'; ?>">
                    <i class="fas fa-folder w-6 mr-3 text-lg opacity-70"></i>
                    <span class="sidebar-text">Categories</span>
                    <span class="sidebar-tooltip">Categories</span>
                </a>

                <a href="<?php echo url('admin/tools'); ?>"
                    class="admin-sidebar-item relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold transition-all hover:bg-gray-50 dark:hover:bg-white/5 <?php echo ($currentRoute === 'tools') ? 'active' : 'text-gray-500 dark:text-gray-400'; ?>">
                    <i class="fas fa-wrench w-6 mr-3 text-lg opacity-70"></i>
                    <span class="sidebar-text">Tools</span>
                    <span class="sidebar-tooltip">Tools</span>
                </a>
            </div>

            <div class="pt-3">
                <p class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2 opacity-50">Settings
                </p>

                <a href="<?php echo url('admin/settings'); ?>"
                    class="admin-sidebar-item relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold transition-all hover:bg-gray-50 dark:hover:bg-white/5 <?php echo ($currentRoute === 'settings') ? 'active' : 'text-gray-500 dark:text-gray-400'; ?>">
                    <i class="fas fa-cog w-6 mr-3 text-lg opacity-70"></i>
                    <span class="sidebar-text">Site Settings</span>
                    <span class="sidebar-tooltip">Site Settings</span>
                </a>

                <a href="<?php echo url('admin/profile'); ?>"
                    class="admin-sidebar-item relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold transition-all hover:bg-gray-50 dark:hover:bg-white/5 <?php echo ($currentRoute === 'profile') ? 'active' : 'text-gray-500 dark:text-gray-400'; ?>">
                    <i class="fas fa-user-shield w-6 mr-3 text-lg opacity-70"></i>
                    <span class="sidebar-text">Profile</span>
                    <span class="sidebar-tooltip">Profile</span>
                </a>

                <a href="<?php echo url(); ?>" target="_blank"
                    class="relative flex items-center px-4 py-2 rounded-2xl text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-primary transition-all">
                    <i class="fas fa-external-link-alt w-6 mr-3 text-lg opacity-70"></i>
                    <span class="sidebar-text">View Live Site</span>
                    <span class="sidebar-tooltip">View Live Site</span>
                </a>
            </div>
        </nav>

        <!-- Profile / Logout Section -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-900/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div
                        class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary border border-primary/30 shrink-0">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex flex-col sidebar-text">
                        <span class="text-xs font-black uppercase tracking-wider whitespace-nowrap">
                            <?php echo htmlspecialchars($_SESSION['admin_user'] ?? 'Admin'); ?>
                        </span>
                        <span class="text-[10px] text-green-500 font-bold flex items-center whitespace-nowrap">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                            Online
                        </span>
                    </div>
                </div>
                <a href="<?php echo url('admin/logout'); ?>"
                    class="admin-sidebar-item relative p-2.5 rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm"
                    title="Logout">
                    <i class="fas fa-power-off"></i>
                    <span class="sidebar-tooltip">Logout</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Overlay for Mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <div id="adminContent" class="flex-1 overflow-y-auto p-6 lg:p-10 custom-scrollbar">
            <?php include_once __DIR__ . '/../../includes/toast_provider.php'; ?>