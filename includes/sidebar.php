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

    <!-- Sidebar Search -->
    <div class="px-4 mb-2 sidebar-expand-only">
        <div class="relative group">
            <div
                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors text-[10px]">
                <i class="fas fa-filter"></i>
            </div>
            <input type="text" id="sidebarFilter" placeholder="Quick filter..."
                class="w-full bg-white/5 border border-white/5 rounded-xl py-2 pl-9 pr-4 text-xs font-bold text-white placeholder:text-gray-500 outline-none focus:border-primary/30 transition-all">
        </div>
    </div>

    <!-- Scrollable Area -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <nav class="px-4 py-4 space-y-6">
            <!-- Main Menu -->
            <div class="space-y-1">
                <?php $isDash = ($curr === '' || $curr === '/'); ?>
                <a href="<?php echo url(); ?>"
                    class="relative flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isDash ? $activeClass : $inactiveClass; ?>">
                    <i
                        class="fas fa-th-large w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isDash ? $activeIcon : $inactiveIcon; ?>"></i>
                    <span class="sidebar-expand-only">Dashboard</span>
                    <span class="sidebar-tooltip">Dashboard</span>
                    <?php if ($isDash): ?>
                        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full sidebar-expand-only"></div>
                    <?php endif; ?>
                </a>

                <?php $isTools = ($curr === 'tools'); ?>
                <a href="<?php echo url('tools'); ?>"
                    class="relative flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isTools ? $activeClass : $inactiveClass; ?>">
                    <i
                        class="fas fa-th-list w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isTools ? $activeIcon : $inactiveIcon; ?>"></i>
                    <span class="sidebar-expand-only">Browse Tools</span>
                    <span class="sidebar-tooltip">Browse Tools</span>
                    <?php if ($isTools): ?>
                        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full sidebar-expand-only"></div>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Favorites (Client-Side) -->
            <div id="favoritesSection" class="hidden">
                <p
                    class="sidebar-expand-only px-4 text-[10px] font-black text-yellow-500 uppercase tracking-[0.3em] mb-3 opacity-60">
                    My Favorites</p>
                <div id="favoritesList" class="space-y-1">
                    <!-- Populated by JS -->
                </div>
            </div>

            <!-- Recent Tools (Session Based) -->
            <?php
            if (session_status() === PHP_SESSION_NONE) {
                @session_start();
            }
            $recentSlugs = $_SESSION['recent_tools'] ?? [];
            if (!empty($recentSlugs) && ($settings['show_recent_tools'] ?? '1') === '1'):
                ?>
                <div>
                    <p
                        class="sidebar-expand-only px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3 opacity-40">
                        Recent Tools</p>
                    <div class="space-y-1">
                        <?php foreach ($recentSlugs as $slug):
                            if (!isset($tools[$slug]))
                                continue;
                            $t = $tools[$slug];
                            ?>
                            <a href="<?php echo getToolUrl($slug, $t); ?>"
                                class="relative flex items-center px-4 py-2.5 text-xs font-bold text-gray-400 hover:text-white hover:bg-white/5 rounded-2xl group transition-all">
                                <i
                                    class="fas <?php echo $t['icon']; ?> w-6 text-center mr-4 text-primary/40 group-hover:text-primary transition-colors"></i>
                                <span class="sidebar-expand-only line-clamp-1"><?php echo $t['name']; ?></span>
                                <span class="sidebar-tooltip"><?php echo $t['name']; ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Categories Group -->
            <div>
                <p
                    class="sidebar-expand-only px-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-4 opacity-50">
                    Repositories</p>
                <div class="space-y-1">
                    <?php
                    // Use $catsDB fetched in index.php
                    foreach ($catsDB as $cat):
                        $id = $cat['id'];
                        $name = $cat['name'];
                        $iconClass = $cat['icon'] ?? 'fa-cube';
                        $isActive = isActiveCat($id, $parts);
                        ?>
                        <a href="<?php echo url('tools/' . $id); ?>"
                            class="relative flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isActive ? $activeClass : $inactiveClass; ?>">
                            <i
                                class="fas <?php echo $iconClass; ?> w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isActive ? $activeIcon : $inactiveIcon; ?>"></i>
                            <span class="sidebar-expand-only"><?php echo $name; ?></span>
                            <span class="sidebar-tooltip"><?php echo $name; ?></span>
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
                    class="relative flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all group <?php echo $isSupport ? $activeClass : $inactiveClass; ?>">
                    <i
                        class="fas fa-life-ring w-6 text-center mr-4 group-hover:scale-110 transition-transform <?php echo $isSupport ? $activeIcon : $inactiveIcon; ?>"></i>
                    <span class="sidebar-expand-only">Help & Support</span>
                    <span class="sidebar-tooltip">Help & Support</span>
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

    /* Tooltip styles for collapsed sidebar */
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
        transition: opacity 0.2s;
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
    a .sidebar-tooltip {
        display: none !important;
        opacity: 0 !important;
    }

    /* Only show tooltips when sidebar is collapsed */
    #sidebar.collapsed a:hover .sidebar-tooltip {
        display: block;
        opacity: 1;
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
        border-radius: 10px;
    }
</style>

<script>
    // Trending/Favorites Logic
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        if (!sidebar) return;

        // 1. Tooltips Logic (Existing)
        const globalTooltip = document.createElement('div');
        globalTooltip.className = 'sidebar-tooltip';
        globalTooltip.style.position = 'fixed';
        globalTooltip.style.zIndex = '9999';
        document.body.appendChild(globalTooltip);

        function attachTooltipEvents(element) {
            const tooltipText = element.querySelector('.sidebar-tooltip');
            if (!tooltipText) return;
            const text = tooltipText.textContent;

            element.addEventListener('mouseenter', function () {
                if (sidebar.classList.contains('collapsed')) {
                    const rect = element.getBoundingClientRect();
                    globalTooltip.textContent = text;
                    globalTooltip.style.left = (rect.right + 12) + 'px';
                    globalTooltip.style.top = (rect.top + rect.height / 2) + 'px';
                    globalTooltip.style.transform = 'translateY(-50%)';
                    globalTooltip.style.display = 'block';
                    globalTooltip.style.opacity = '1';
                }
            });

            element.addEventListener('mouseleave', function () {
                globalTooltip.style.opacity = '0';
                setTimeout(() => {
                    globalTooltip.style.display = 'none';
                }, 200);
            });
        }

        const links = sidebar.querySelectorAll('a[class*="relative"]');
        links.forEach(attachTooltipEvents);

        // 2. Favorites Persistence Logic
        const toolsData = {
            <?php
            foreach ($tools as $slug => $data) {
                $isNew = is_new_tool($data['created_at']);
                echo "'$slug': { name: '" . addslashes($data['name']) . "', icon: '" . $data['icon'] . "', url: '" . getToolUrl($slug, $data) . "', isNew: " . ($isNew ? 'true' : 'false') . " },";
            }
            ?>
        };

        function renderFavorites() {
            const favs = JSON.parse(localStorage.getItem('sniptools_favorites')) || [];
            const container = document.getElementById('favoritesSection');
            const list = document.getElementById('favoritesList');

            if (favs.length === 0) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');
            list.innerHTML = favs.map(slug => {
                const t = toolsData[slug];
                if (!t) return '';
                return `
                    <a href="${t.url}" class="relative flex items-center px-4 py-2.5 text-xs font-bold text-gray-400 hover:text-white hover:bg-white/5 rounded-2xl group transition-all">
                        <i class="fas ${t.icon} w-6 text-center mr-4 text-yellow-500/40 group-hover:text-yellow-500 transition-colors"></i>
                        <span class="sidebar-expand-only line-clamp-1 flex-1">${t.name}</span>
                        ${t.isNew ? '<span class="sidebar-expand-only text-[7px] bg-emerald-500 text-white px-1 py-0.5 rounded ml-auto">NEW</span>' : ''}
                        <span class="sidebar-tooltip">${t.name}</span>
                    </a>
                `;
            }).join('');

            // Re-attach tooltips for new elements
            list.querySelectorAll('a').forEach(attachTooltipEvents);
        }

        renderFavorites();
        window.addEventListener('favoritesChanged', renderFavorites);

        // 3. Sidebar Filter Logic
        const sidebarFilter = document.getElementById('sidebarFilter');
        if (sidebarFilter) {
            sidebarFilter.addEventListener('input', function (e) {
                const query = e.target.value.toLowerCase().trim();
                const navItems = sidebar.querySelectorAll('nav a');
                const pLabels = sidebar.querySelectorAll('nav p');

                navItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(query)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Hide labels if all items under them are hidden
                // This is a bit complex since they are siblings, but we can do a simple check
                pLabels.forEach(label => {
                    let next = label.nextElementSibling;
                    let hasVisible = false;
                    while (next && next.tagName !== 'P') {
                        if (next.tagName === 'A' && !next.classList.contains('hidden')) hasVisible = true;
                        if (next.id === 'favoritesList') {
                            if (next.querySelectorAll('a:not(.hidden)').length > 0) hasVisible = true;
                        }
                        if (next.querySelectorAll('a:not(.hidden)').length > 0) hasVisible = true;
                        next = next.nextElementSibling;
                    }
                    if (hasVisible) label.classList.remove('hidden');
                    else label.classList.add('hidden');
                });
            });
        }

        // Re-attach listeners on sidebar toggle
        const toggleBtn = document.getElementById('sidebarCollapseBtn');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                globalTooltip.style.display = 'none';
            });
        }
    });
</script>