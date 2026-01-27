<?php
// includes/sidebar.php
require_once __DIR__ . '/../config/config.php';
?>
<?php
// active state helper
function isActive($path, $current)
{
    return $path === $current;
}
function isActiveCat($slug, $parts)
{
    return isset($parts[0]) && $parts[0] === 'tools' && isset($parts[1]) && $parts[1] === $slug;
}

$curr = $route ?? '';
$parts = $routeParts ?? [];

$activeClass = 'bg-primary text-white shadow-lg shadow-primary/20 relative';
$activeIcon = 'text-white';
$inactiveClass = 'text-gray-400 hover:text-white hover:bg-white/5';
$inactiveIcon = 'text-gray-400 group-hover:text-primary';
?>
<!-- Sidebar -->
<aside id="sidebar"
    class="sidebar-transition fixed inset-y-0 left-0 z-40 bg-secondary text-white w-64 lg:static transform -translate-x-full lg:translate-x-0 overflow-hidden flex flex-col shrink-0 border-r border-white/5 shadow-2xl">
    <!-- Compact Header -->
    <div class="pt-6 px-4 flex justify-between items-center h-16 shrink-0">
        <p class="sidebar-expand-only text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] opacity-50">
            Navigation</p>
        <button id="sidebarCollapseBtn" class="p-2 rounded-xl hover:bg-white/10 text-gray-400 transition-all group">
            <i class="fas fa-angles-left group-[.collapsed]:rotate-180 transition-transform"></i>
        </button>
    </div>

    <!-- Scrollable Area -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <nav class="px-4 py-4 space-y-6">
            <!-- Main Menu -->
            <div class="space-y-1">
                <?php $isDash = ($curr === '' || $curr === '/'); ?>
                <a href="<?php echo url(); ?>"
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isDash ? $activeClass : $inactiveClass; ?>">
                    <i
                        class="fas fa-th-large w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isDash ? $activeIcon : $inactiveIcon; ?>"></i>
                    <span class="sidebar-expand-only">Dashboard</span>
                    <?php if ($isDash): ?>
                        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full sidebar-expand-only"></div>
                    <?php endif; ?>
                </a>

                <?php $isTools = ($curr === 'tools'); ?>
                <a href="<?php echo url('tools'); ?>"
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isTools ? $activeClass : $inactiveClass; ?>">
                    <i
                        class="fas fa-th-list w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isTools ? $activeIcon : $inactiveIcon; ?>"></i>
                    <span class="sidebar-expand-only">Browse Tools</span>
                    <?php if ($isTools): ?>
                        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full sidebar-expand-only"></div>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Suggestion / Popular Tools -->
            <div>
                <p
                    class="sidebar-expand-only px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3 opacity-40">
                    Popular Tools</p>
                <div class="space-y-1">
                    <a href="<?php echo getToolUrl('json-formatter', $tools['json-formatter']); ?>"
                        class="flex items-center px-4 py-2.5 text-xs font-bold text-gray-400 hover:text-white hover:bg-white/5 rounded-2xl group transition-all">
                        <i
                            class="fas fa-bolt w-6 text-center mr-4 text-primary/40 group-hover:text-primary transition-colors"></i>
                        <span class="sidebar-expand-only">JSON Formatter</span>
                    </a>
                </div>
            </div>

            <!-- Categories Group -->
            <div>
                <p
                    class="sidebar-expand-only px-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-3 opacity-50">
                    Categories</p>
                <div class="space-y-1">
                    <?php foreach ($categories as $id => $name): ?>
                        <?php
                        $isActive = isActiveCat($id, $parts);
                        $iconClass = match ($id) {
                            'text' => 'fa-font',
                            'developer' => 'fa-code',
                            'image' => 'fa-image',
                            'converters' => 'fa-exchange-alt',
                            'tailwind' => 'fa-wind',
                            default => 'fa-cube'
                        };
                        ?>
                        <a href="<?php echo url('tools/' . $id); ?>"
                            class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isActive ? $activeClass : $inactiveClass; ?>">
                            <i
                                class="fas <?php echo $iconClass; ?> w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isActive ? $activeIcon : $inactiveIcon; ?>"></i>
                            <span class="sidebar-expand-only"><?php echo $name; ?></span>
                            <?php if ($isActive): ?>
                                <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full sidebar-expand-only"></div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Support & Community -->
            <div class="mt-auto pt-6 border-t border-white/5">
                <?php $isSupport = ($curr === 'support'); ?>
                <a href="<?php echo url('support'); ?>"
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isSupport ? $activeClass : $inactiveClass; ?>">
                    <i
                        class="fas fa-life-ring w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isSupport ? $activeIcon : 'text-emerald-400/50 group-hover:text-emerald-400'; ?>"></i>
                    <span class="sidebar-expand-only">Help & Support</span>
                    <?php if ($isSupport): ?>
                        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full sidebar-expand-only"></div>
                    <?php endif; ?>
                </a>
            </div>
        </nav>
    </div>
</aside>

<style>
    #sidebar.collapsed {
        width: 88px;
    }

    #sidebar.collapsed .sidebar-expand-only {
        display: none;
    }

    #sidebar:not(.collapsed) .sidebar-collapse-only {
        display: none;
    }

    #sidebar:not(.collapsed) #sidebarCollapseBtn {
        transform: rotate(0deg);
    }

    #sidebar.collapsed #sidebarCollapseBtn {
        transform: rotate(180deg);
        margin: 0 auto;
    }

    /* Ensure no scrollbar unless necessary */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
    }
</style>