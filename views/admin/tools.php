<?php
// views/admin/tools.php
$pageTitle = "Tool Management";
$subRoute = 'tools';

// 1. Handle POST actions first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create_tool') {
            $name = trim($_POST['name']);
            $slug = trim($_POST['slug']);
            $categoryId = trim($_POST['category_id']);
            $icon = trim($_POST['icon'] ?? 'fa-tools');
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            // Validate category exists
            $catCheck = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE id = ?");
            $catCheck->execute([$categoryId]);
            if ($catCheck->fetchColumn() == 0) {
                set_flash_message("Invalid category selected.", "error");
                header("Location: " . url('admin/tools'));
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO tools (name, slug, category_id, icon, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $slug, $categoryId, $icon, $isActive]);
            set_flash_message("Tool created successfully.");
            header("Location: " . url('admin/tools'));
            exit;
        }

        if ($_POST['action'] === 'update_tool') {
            $id = (int) $_POST['id'];
            $name = trim($_POST['name']);
            $slug = trim($_POST['slug']);
            $categoryId = trim($_POST['category_id']);
            $icon = trim($_POST['icon'] ?? 'fa-tools');
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            $stmt = $pdo->prepare("UPDATE tools SET name = ?, slug = ?, category_id = ?, icon = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $categoryId, $icon, $isActive, $id]);
            set_flash_message("Tool updated successfully.");
            header("Location: " . url('admin/tools'));
            exit;
        }

        if ($_POST['action'] === 'delete_tool') {
            $id = (int) $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM tools WHERE id = ?");
            $stmt->execute([$id]);
            set_flash_message("Tool deleted successfully.");
            header("Location: " . url('admin/tools'));
            exit;
        }

        if ($_POST['action'] === 'toggle_tool') {
            $id = (int) $_POST['id'];
            $currentState = (int) $_POST['current_state'];
            $newState = $currentState == 1 ? 0 : 1;

            $stmt = $pdo->prepare("UPDATE tools SET is_active = ? WHERE id = ?");
            $stmt->execute([$newState, $id]);
            set_flash_message("Tool visibility updated.");
            header("Location: " . url('admin/tools'));
            exit;
        }
    }
}

// 2. Fetch Data
$categories = $pdo->query("SELECT * FROM categories ORDER BY sort_order, name")->fetchAll();

// Fetch all tools grouped by category
$toolsListRaw = $pdo->query("SELECT t.*, c.name as cat_name FROM tools t LEFT JOIN categories c ON t.category_id = c.id ORDER BY c.sort_order, c.name, t.name")->fetchAll();
$toolsByCategory = [];
foreach ($toolsListRaw as $t) {
    if (!isset($toolsByCategory[$t['cat_name'] ?? 'Uncategorized']))
        $toolsByCategory[$t['cat_name'] ?? 'Uncategorized'] = [];
    $toolsByCategory[$t['cat_name'] ?? 'Uncategorized'][] = $t;
}

require_once __DIR__ . '/layout_header.php';
?>

<div class="space-y-8 pb-20 animate-fade-in">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Tool <span
                    class="text-primary italic">Inventory</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 opacity-60">Manage your toolbox
                and configure visibility</p>
        </div>
        <div class="flex items-center space-x-4">
            <div
                class="hidden md:flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 mr-2">Status:</span>
                <span
                    class="text-[10px] font-black uppercase text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded-md">Live</span>
            </div>
            <button onclick="openCreateModal()"
                class="px-8 py-3.5 bg-primary text-white rounded-2xl font-black text-sm hover:scale-105 transition-all shadow-xl shadow-primary/25 flex items-center">
                <i class="fas fa-plus-circle mr-3"></i> Deploy New Tool
            </button>
        </div>
    </header>

    <!-- Main Content: Accordion Style -->
    <div id="tool-management"
        class="bg-white dark:bg-gray-800 rounded-[3rem] border border-gray-100 dark:border-gray-700 shadow-2xl overflow-hidden">
        <div
            class="p-8 border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-primary/10 rounded-2xl text-primary">
                    <i class="fas fa-layer-group text-xl"></i>
                </div>
                <div>
                    <h2 class="font-black text-lg uppercase tracking-tight">Active Repositories</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Sourced from
                        <?php echo count($categories); ?> main categories
                    </p>
                </div>
            </div>
            <div class="px-4 py-2 bg-primary/10 rounded-xl">
                <span
                    class="text-xs font-black text-primary uppercase tracking-widest"><?php echo array_sum(array_map('count', $toolsByCategory)); ?>
                    Tools</span>
            </div>
        </div>

        <div class="tool-list-container divide-y divide-gray-100 dark:divide-gray-700/50">
            <?php if (empty($toolsByCategory)): ?>
                <div class="p-20 text-center">
                    <i class="fas fa-box-open text-6xl text-gray-100 dark:text-gray-700 mb-6"></i>
                    <p class="text-gray-400 font-bold uppercase tracking-widest">No tools assigned yet.</p>
                </div>
            <?php else: ?>
                <?php
                ksort($toolsByCategory);
                foreach ($toolsByCategory as $catName => $tools):
                    $catId = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $catName));
                    $catRow = array_values(array_filter($categories, fn($c) => $c['name'] === $catName))[0] ?? null;
                    ?>
                    <div class="cat-accordion group/acc" id="cat-group-<?php echo $catId; ?>">
                        <!-- Accordion Trigger -->
                        <button onclick="toggleAccordion('<?php echo $catId; ?>')"
                            class="w-full bg-gray-50/80 dark:bg-gray-900/40 px-10 py-6 flex items-center justify-between hover:bg-white dark:hover:bg-gray-800 transition-all text-left">
                            <div class="flex items-center space-x-6">
                                <div class="w-2 h-8 bg-primary rounded-full group-hover/acc:scale-y-125 transition-transform">
                                </div>
                                <div>
                                    <span
                                        class="text-base font-black uppercase tracking-[0.2em] text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars($catName); ?></span>
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mt-1.5 opacity-60">
                                        <?php echo count($tools); ?> Services Integrated
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-8">
                                <div class="hidden sm:flex -space-x-3">
                                    <?php foreach (array_slice($tools, 0, 4) as $t): ?>
                                        <div
                                            class="w-9 h-9 rounded-xl bg-white dark:bg-gray-700 border-2 border-gray-50 dark:border-gray-900 flex items-center justify-center text-xs text-gray-400 shadow-xl group-hover/acc:-translate-y-1 transition-transform">
                                            <i class="fas <?php echo htmlspecialchars($t['icon']); ?>"></i>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div id="icon-<?php echo $catId; ?>"
                                    class="w-10 h-10 rounded-2xl border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-400 transition-all duration-500 group-hover/acc:border-primary/30">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </button>

                        <!-- Accordion Content -->
                        <div id="content-<?php echo $catId; ?>" class="hidden overflow-hidden bg-white dark:bg-gray-800/10">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-gray-50/50 dark:bg-gray-900/30">
                                        <tr>
                                            <th
                                                class="px-12 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                Identify</th>
                                            <th
                                                class="px-12 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                Performance</th>
                                            <th
                                                class="px-12 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                Visibility</th>
                                            <th
                                                class="px-12 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                                                Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                                        <?php foreach ($tools as $tool): ?>
                                            <tr class="hover:bg-gray-50/30 dark:hover:bg-gray-700/20 transition-colors group/row">
                                                <td class="px-12 py-5">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mr-5 text-gray-400 group-hover/row:bg-primary group-hover/row:text-white transition-all shadow-lg group-hover/row:shadow-primary/25">
                                                            <i
                                                                class="fas <?php echo htmlspecialchars($tool['icon']); ?> text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <div class="flex items-center">
                                                                <span
                                                                    class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight"><?php echo htmlspecialchars($tool['name']); ?></span>
                                                                <?php if ($tool['is_featured']): ?>
                                                                    <i class="fas fa-star text-yellow-500 ml-2 text-[10px]"></i>
                                                                <?php endif; ?>
                                                            </div>
                                                            <p class="text-[10px] text-gray-400 font-mono mt-1 opacity-60">
                                                                /tools/<?php echo htmlspecialchars($tool['slug']); ?></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-12 py-5">
                                                    <div
                                                        class="inline-flex items-center px-3 py-1.5 rounded-xl bg-emerald-500/5 text-emerald-500 border border-emerald-500/10">
                                                        <i class="fas fa-bolt mr-2 text-[10px]"></i>
                                                        <span
                                                            class="text-[10px] font-black uppercase tracking-widest"><?php echo number_format($tool['view_count']); ?>
                                                            Hits</span>
                                                    </div>
                                                </td>
                                                <td class="px-12 py-5">
                                                    <form method="POST" class="inline">
                                                        <input type="hidden" name="csrf_token"
                                                            value="<?php echo generate_csrf_token(); ?>">
                                                        <input type="hidden" name="action" value="toggle_tool">
                                                        <input type="hidden" name="id" value="<?php echo $tool['id']; ?>">
                                                        <input type="hidden" name="current_state"
                                                            value="<?php echo $tool['is_active']; ?>">
                                                        <button type="submit"
                                                            class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all <?php echo $tool['is_active'] ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white' : 'bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white'; ?>">
                                                            <?php echo $tool['is_active'] ? 'Published' : 'Draft'; ?>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="px-12 py-5 text-right">
                                                    <div class="flex items-center justify-end space-x-3">
                                                        <button onclick='openEditModal(<?php echo json_encode($tool); ?>)'
                                                            class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700/50 text-gray-400 hover:bg-primary hover:text-white hover:scale-110 transition-all shadow-sm">
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </button>
                                                        <button
                                                            onclick="confirmDelete(<?php echo $tool['id']; ?>, '<?php echo htmlspecialchars($tool['name']); ?>')"
                                                            class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700/50 text-gray-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all shadow-sm">
                                                            <i class="fas fa-trash text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>

<!-- Global Tool Action Form -->
<form id="globalToolActionForm" method="POST" class="hidden">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
    <input type="hidden" name="id" id="toolActionId">
    <input type="hidden" name="action" id="toolActionType">
</form>

<!-- Modal Container -->
<div id="toolModal"
    class="fixed inset-0 bg-secondary/80 backdrop-blur-md z-[100] hidden items-center justify-center p-6 sm:p-12 transition-all duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-transform duration-300"
        onclick="event.stopPropagation()">
        <div
            class="p-8 border-b border-gray-100 dark:border-gray-700/50 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/50">
            <div>
                <h2 id="modalTitle" class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                    New Tool</h2>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Configure service parameters
                </p>
            </div>
            <button onclick="closeModal()"
                class="w-10 h-10 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            <input type="hidden" name="action" id="formAction" value="create_tool">
            <input type="hidden" name="id" id="toolId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Tool Blueprint
                        Name</label>
                    <input type="text" name="name" id="toolName" required placeholder="e.g. JSON Minifier"
                        class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-3.5 px-5 text-sm font-bold focus:border-primary outline-none transition-all shadow-inner">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Slug
                        Pipeline</label>
                    <input type="text" name="slug" id="toolSlug" required placeholder="json-minifier"
                        class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-3.5 px-5 text-sm font-mono focus:border-primary outline-none transition-all shadow-inner uppercase tracking-wider">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Classification
                    Category</label>
                <select name="category_id" id="toolCategory" required
                    class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-3.5 px-5 text-sm font-bold focus:border-primary outline-none transition-all shadow-inner dark:text-white">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Icon
                    Identification</label>
                <input type="hidden" name="icon" id="toolIcon" value="fa-tools">
                <div
                    class="grid grid-cols-8 gap-2 p-4 bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-[1.5rem] max-h-40 overflow-y-auto custom-scrollbar">
                    <?php
                    $icons = ['fa-code', 'fa-terminal', 'fa-database', 'fa-lock', 'fa-shield-alt', 'fa-qrcode', 'fa-link', 'fa-image', 'fa-text-height', 'fa-calculator', 'fa-magic', 'fa-tools', 'fa-search', 'fa-copy', 'fa-save', 'fa-trash', 'fa-bolt', 'fa-rocket', 'fa-globe', 'fa-server', 'fa-key', 'fa-eye', 'fa-cloud', 'fa-wrench', 'fa-hammer', 'fa-cog', 'fa-microchip', 'fa-brain', 'fa-cogs', 'fa-sliders-h', 'fa-filter', 'fa-download', 'fa-upload', 'fa-sync', 'fa-random', 'fa-robot', 'fa-cube', 'fa-cubes'];
                    foreach ($icons as $icon): ?>
                        <button type="button" onclick="selectIcon('<?php echo $icon; ?>')"
                            class="icon-option w-10 h-10 flex items-center justify-center rounded-xl border-2 border-transparent hover:border-primary hover:bg-primary/5 transition-all"
                            data-icon="<?php echo $icon; ?>">
                            <i class="fas <?php echo $icon; ?> text-base"></i>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="mt-3 flex items-center bg-primary/5 p-3 rounded-2xl border border-primary/10">
                    <span class="text-[10px] font-black text-primary uppercase tracking-widest mr-4">Preview:</span>
                    <i id="selectedIconPreview" class="fas fa-tools text-primary text-xl mr-3"></i>
                    <code id="selectedIconName"
                        class="text-[10px] text-primary font-black uppercase tracking-widest">fa-tools</code>
                </div>
            </div>

            <div
                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" id="toolActive" value="1" checked
                        class="w-6 h-6 rounded-lg border-2 border-gray-300 text-primary focus:ring-primary transition-all">
                    <label for="toolActive"
                        class="text-xs font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest cursor-pointer">Live
                        Deployment Status</label>
                </div>
            </div>

            <div class="flex items-center space-x-4 pt-4">
                <button type="submit"
                    class="flex-1 px-8 py-4 bg-primary text-white rounded-[1.5rem] font-black text-sm hover:scale-[1.02] transition-all shadow-xl shadow-primary/20">
                    <i class="fas fa-cloud-upload-alt mr-3"></i> Commit Configuration
                </button>
                <button type="button" onclick="closeModal()"
                    class="px-8 py-4 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-[1.5rem] font-black text-sm hover:bg-gray-200 transition-all">
                    Abort
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    function toggleAccordion(id) {
        const content = document.getElementById('content-' + id);
        const icon = document.getElementById('icon-' + id);
        const isHidden = content.classList.contains('hidden');

        // Toggle current
        if (isHidden) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180', 'border-primary/50', 'bg-primary/5', 'text-primary');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180', 'border-primary/50', 'bg-primary/5', 'text-primary');
        }
    }

    function selectIcon(iconClass) {
        document.getElementById('toolIcon').value = iconClass;
        document.getElementById('selectedIconPreview').className = 'fas ' + iconClass + ' text-primary text-xl mr-3';
        document.getElementById('selectedIconName').textContent = iconClass;
        document.querySelectorAll('.icon-option').forEach(btn => {
            btn.classList.toggle('border-primary', btn.dataset.icon === iconClass);
            btn.classList.toggle('bg-primary/10', btn.dataset.icon === iconClass);
        });
    }

    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Initialize New Tool';
        document.getElementById('formAction').value = 'create_tool';
        document.getElementById('toolId').value = '';
        document.getElementById('toolName').value = '';
        document.getElementById('toolSlug').value = '';
        document.getElementById('toolActive').checked = true;
        selectIcon('fa-tools');
        const modal = document.getElementById('toolModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => modal.children[0].classList.remove('scale-95'), 10);
    }

    function openEditModal(tool) {
        document.getElementById('modalTitle').textContent = 'Modify Tool Config';
        document.getElementById('formAction').value = 'update_tool';
        document.getElementById('toolId').value = tool.id;
        document.getElementById('toolName').value = tool.name;
        document.getElementById('toolSlug').value = tool.slug;
        document.getElementById('toolCategory').value = tool.category_id;
        document.getElementById('toolActive').checked = tool.is_active == 1;
        selectIcon(tool.icon || 'fa-tools');
        const modal = document.getElementById('toolModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => modal.children[0].classList.remove('scale-95'), 10);
    }

    function closeModal() {
        const modal = document.getElementById('toolModal');
        modal.children[0].classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    function confirmDelete(id, name) {
        showGlobalConfirm({
            title: 'Terminate Tool?',
            message: `Are you sure you want to permanently delete "<span class="font-black text-gray-900 dark:text-white uppercase tracking-tight">${name}</span>"? This will remove the tool from all repositories.`,
            icon: 'fa-radiation',
            color: 'danger',
            confirmText: 'Execute Delete',
            onConfirm: () => {
                document.getElementById('toolActionId').value = id;
                document.getElementById('toolActionType').value = 'delete_tool';
                document.getElementById('globalToolActionForm').submit();
            }
        });
    }

    document.getElementById('toolName').addEventListener('input', function (e) {
        if (document.getElementById('formAction').value === 'create_tool') {
            document.getElementById('toolSlug').value = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        }
    });

    window.onclick = function (event) {
        if (event.target == document.getElementById('toolModal')) closeModal();
    }
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>