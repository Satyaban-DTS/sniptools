<?php
// views/admin/categories.php
$pageTitle = "Category Management";
$subRoute = 'categories';

// 1. Handle POST actions first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create_category') {
            $name = trim($_POST['name']);
            $sortOrder = (int) $_POST['sort_order'];
            $icon = trim($_POST['icon'] ?? 'fa-folder');

            // Generate a slug-like ID from the name
            $id = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
            $id = trim($id, '-');

            $stmt = $pdo->prepare("INSERT INTO categories (id, name, sort_order, icon) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id, $name, $sortOrder, $icon]);
            set_flash_message("Category created successfully.");
            header("Location: " . url('admin/categories'));
            exit;
        }

        if ($_POST['action'] === 'update_category') {
            $id = trim($_POST['id']);
            $name = trim($_POST['name']);
            $sortOrder = (int) $_POST['sort_order'];
            $icon = trim($_POST['icon'] ?? 'fa-folder');

            $stmt = $pdo->prepare("UPDATE categories SET name = ?, sort_order = ?, icon = ? WHERE id = ?");
            $stmt->execute([$name, $sortOrder, $icon, $id]);
            set_flash_message("Category updated successfully.");
            header("Location: " . url('admin/categories'));
            exit;
        }

        if ($_POST['action'] === 'delete_category') {
            $id = trim($_POST['id']);

            // Check if category has tools
            $toolCount = $pdo->prepare("SELECT COUNT(*) FROM tools WHERE category_id = ?");
            $toolCount->execute([$id]);
            $count = $toolCount->fetchColumn();

            if ($count > 0) {
                set_flash_message("Cannot delete category with existing tools.", "error");
            } else {
                $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                $stmt->execute([$id]);
                set_flash_message("Category terminated.");
            }
            header("Location: " . url('admin/categories'));
            exit;
        }
    }
}

// 2. Fetch Data
$categories = $pdo->query("
    SELECT c.*, COUNT(t.id) as tool_count 
    FROM categories c 
    LEFT JOIN tools t ON c.id = t.category_id 
    GROUP BY c.id 
    ORDER BY c.sort_order, c.name
")->fetchAll();

require_once __DIR__ . '/layout_header.php';
?>

<div class="space-y-10 pb-20 animate-fade-in">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Taxonomy <span
                    class="text-primary italic">Control</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 opacity-60">Manage tool
                classifications and architectural hierarchy</p>
        </div>
        <button onclick="openCreateModal()"
            class="px-8 py-3.5 bg-primary text-white rounded-2xl font-black text-sm hover:scale-105 transition-all shadow-xl shadow-primary/25 flex items-center">
            <i class="fas fa-plus-circle mr-3"></i> Create Category
        </button>
    </header>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Total Nodes
                    </h4>
                    <p class="text-xl font-black text-gray-900 dark:text-white mt-1"><?php echo count($categories); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Populated
                    </h4>
                    <p class="text-xl font-black text-gray-900 dark:text-white mt-1">
                        <?php echo count(array_filter($categories, fn($c) => $c['tool_count'] > 0)); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div
        class="bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl overflow-hidden">
        <div
            class="p-8 border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-folder-tree text-primary text-xl"></i>
                <h2 class="font-black text-lg uppercase tracking-tight">Active Classifications</h2>
            </div>
            <div class="px-4 py-2 bg-gray-100 dark:bg-gray-900 rounded-xl">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Sort Order Hierarchy</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 dark:bg-gray-900/30">
                    <tr>
                        <th class="px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Metadata
                        </th>
                        <th
                            class="px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                            Depth (Tools)</th>
                        <th
                            class="px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                            Priority</th>
                        <th
                            class="px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                            Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <i class="fas fa-ghost text-4xl text-gray-100 dark:text-gray-700 mb-4 block"></i>
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No Classifications
                                    Found</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-all group/row">
                                <td class="px-10 py-5">
                                    <div class="flex items-center">
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mr-5 text-gray-400 group-hover/row:bg-primary group-hover/row:text-white transition-all shadow-lg">
                                            <i
                                                class="fas <?php echo htmlspecialchars($cat['icon'] ?? 'fa-folder'); ?> text-lg"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight"><?php echo htmlspecialchars($cat['name']); ?></span>
                                            <p class="text-[10px] text-gray-400 font-mono mt-1 opacity-60">ID:
                                                <?php echo htmlspecialchars($cat['id']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-5 text-center">
                                    <div
                                        class="inline-flex items-center px-4 py-1.5 rounded-xl bg-primary/5 text-primary border border-primary/10">
                                        <span
                                            class="text-[11px] font-black uppercase tracking-widest"><?php echo $cat['tool_count']; ?>
                                            Units</span>
                                    </div>
                                </td>
                                <td class="px-10 py-5 text-center">
                                    <span
                                        class="text-xs font-black text-gray-500 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg">#<?php echo $cat['sort_order']; ?></span>
                                </td>
                                <td class="px-10 py-5 text-right">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button onclick='openEditModal(<?php echo json_encode($cat); ?>)'
                                            class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700/50 text-gray-400 hover:bg-primary hover:text-white hover:scale-110 transition-all shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button
                                            onclick="confirmDelete('<?php echo $cat['id']; ?>', '<?php echo htmlspecialchars($cat['name']); ?>', <?php echo $cat['tool_count']; ?>)"
                                            class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700/50 text-gray-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div id="categoryModal"
    class="fixed inset-0 bg-secondary/80 backdrop-blur-md z-[100] hidden items-center justify-center p-6 transition-all duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300"
        onclick="event.stopPropagation()">
        <div
            class="p-8 border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-900/50 flex items-center justify-between">
            <div>
                <h2 id="modalTitle" class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                    New Node</h2>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Classification Parameters</p>
            </div>
            <button onclick="closeModal()"
                class="w-10 h-10 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            <input type="hidden" name="action" id="formAction" value="create_category">
            <input type="hidden" name="id" id="categoryId">

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Classification
                    Title</label>
                <input type="text" name="name" id="categoryName" required placeholder="e.g. Developer Tools"
                    class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-3.5 px-5 text-sm font-bold focus:border-primary outline-none transition-all shadow-inner">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Sequence
                        Priority</label>
                    <input type="number" name="sort_order" id="categorySortOrder" required value="0"
                        class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-3.5 px-5 text-sm font-bold focus:border-primary outline-none transition-all shadow-inner">
                </div>
                <!-- Icon Selection Placeholder (could expand similar to tools) -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Visual
                        Marker</label>
                    <input type="text" name="icon" id="categoryIcon" value="fa-folder"
                        class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-3.5 px-5 text-sm font-mono focus:border-primary outline-none transition-all shadow-inner">
                </div>
            </div>

            <div class="flex items-center space-x-4 pt-4">
                <button type="submit"
                    class="flex-1 px-8 py-4 bg-primary text-white rounded-[1.5rem] font-black text-sm hover:scale-[1.02] transition-all shadow-xl shadow-primary/20">
                    <i class="fas fa-save mr-3"></i> Commit Node
                </button>
                <button type="button" onclick="closeModal()"
                    class="px-8 py-4 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-[1.5rem] font-black text-sm hover:bg-gray-200 transition-all">
                    Abort
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Global Action Form for Category Deletion -->
<form id="globalCatActionForm" method="POST" style="display: none;">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
    <input type="hidden" name="action" value="delete_category">
    <input type="hidden" name="id" id="catActionId">
</form>

<script>
    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Initialize New Node';
        document.getElementById('formAction').value = 'create_category';
        document.getElementById('categoryId').value = '';
        document.getElementById('categoryName').value = '';
        document.getElementById('categorySortOrder').value = '0';
        document.getElementById('categoryIcon').value = 'fa-folder';
        const modal = document.getElementById('categoryModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => modal.children[0].classList.remove('scale-95'), 10);
    }

    function openEditModal(cat) {
        document.getElementById('modalTitle').textContent = 'Modify Node Config';
        document.getElementById('formAction').value = 'update_category';
        document.getElementById('categoryId').value = cat.id;
        document.getElementById('categoryName').value = cat.name;
        document.getElementById('categorySortOrder').value = cat.sort_order;
        document.getElementById('categoryIcon').value = cat.icon || 'fa-folder';
        const modal = document.getElementById('categoryModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => modal.children[0].classList.remove('scale-95'), 10);
    }

    function closeModal() {
        const modal = document.getElementById('categoryModal');
        modal.children[0].classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    function confirmDelete(id, name, count) {
        if (count > 0) {
            showGlobalConfirm({
                title: 'Security Fault',
                message: `Cannot terminate "<span class="text-red-500 font-bold">${name}</span>". Node contains ${count} active tool dependencies. Reassign or delete tools first.`,
                icon: 'fa-shield-alt',
                color: 'secondary',
                confirmText: 'Acknowledge',
                onConfirm: () => { } // Just closes
            });
        } else {
            showGlobalConfirm({
                title: 'Terminate Node?',
                message: `Are you sure you want to permanently delete "<span class="font-black text-gray-900 dark:text-white uppercase tracking-tight">${name}</span>"?`,
                icon: 'fa-folder-minus',
                color: 'danger',
                confirmText: 'Execute Purge',
                onConfirm: () => {
                    document.getElementById('catActionId').value = id;
                    document.getElementById('globalCatActionForm').submit();
                }
            });
        }
    }

    window.onclick = function (event) {
        if (event.target == document.getElementById('categoryModal')) closeModal();
    }
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>