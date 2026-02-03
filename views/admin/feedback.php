<?php
// views/admin/feedback.php

// 1. Handle POST actions first (BEFORE any HTML output)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Note: Global CSRF check is handled in admin_router.php
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if ($_POST['action'] === 'read') {
            $pdo->prepare("UPDATE feedback SET status = 'read' WHERE id = ?")->execute([$id]);
            set_flash_message("Signal archived successfully.");
        }
        if ($_POST['action'] === 'delete') {
            $pdo->prepare("DELETE FROM feedback WHERE id = ?")->execute([$id]);
            set_flash_message("Signal purged from repository.", "info");
        }
    }

    // Bulk Actions
    if ($_POST['action'] === 'purge_processed') {
        $stmt = $pdo->prepare("DELETE FROM feedback WHERE status = 'read'");
        $stmt->execute();
        $count = $stmt->rowCount();
        set_flash_message("$count processed signals have been purged.", "info");
    }

    // Redirect to self to prevent resubmission
    header("Location: " . url('admin/feedback'));
    exit;
}

// 2. Fetch Data needed for view
$pageTitle = "Feedback Management";
$subRoute = 'feedback';

$search = isset($_GET['s']) ? trim($_GET['s']) : '';
$where = $search ? " WHERE (name LIKE ? OR email LIKE ? OR message LIKE ?)" : "";
$params = $search ? ["%$search%", "%$search%", "%$search%"] : [];

$feedbacks = $pdo->prepare("SELECT * FROM feedback $where ORDER BY created_at DESC");
$feedbacks->execute($params);
$feedbacks = $feedbacks->fetchAll();

// AJAX Search Handler
if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    ob_start();
    include __DIR__ . '/partials/feedback_rows.php';
    $html = ob_get_clean();
    header('Content-Type: application/json');
    echo json_encode(['html' => $html, 'count' => count($feedbacks)]);
    exit;
}

// 3. Include Header (Starts Output)
require_once __DIR__ . '/layout_header.php';
?>

<div class="space-y-8">
    <?php if ($msg = get_flash_message()): ?>
        <div
            class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 px-6 py-4 rounded-2xl flex items-center space-x-3 animate-fade-in">
            <i
                class="fas <?php echo ($msg['type'] ?? 'success') === 'error' ? 'fa-exclamation-circle text-red-500' : 'fa-check-circle'; ?>"></i>
            <span
                class="text-sm font-bold uppercase tracking-tight"><?php echo is_array($msg) ? $msg['message'] : $msg; ?></span>
        </div>
    <?php endif; ?>

    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">User <span
                    class="text-primary italic">Feedback</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 opacity-60">Manage community
                submissions</p>
        </div>
        <div class="flex flex-col md:flex-row items-center gap-3">
            <!-- Search -->
            <form id="feedbackSearchForm" method="GET" class="relative">
                <input type="text" id="feedbackSearchInput" name="s" value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Search feedback..."
                    class="w-full md:w-64 bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-2 px-10 text-sm font-bold focus:border-primary outline-none transition-all shadow-sm dark:text-white">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </form>

            <div
                class="bg-white dark:bg-gray-800 px-6 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center space-x-4">
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Matches</span>
                    <span id="feedbackCount"
                        class="text-xl font-black text-primary"><?php echo count($feedbacks); ?></span>
                </div>
            </div>

            <!-- Bulk Purge -->
            <button type="button"
                onclick="triggerBulkAction('purge_processed', 'Are you sure you want to purge all processed signals?')"
                class="h-full px-6 py-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all border border-red-500/20 shadow-sm flex items-center">
                <i class="fas fa-trash-alt mr-2"></i> Purge All Processed
            </button>
        </div>
    </header>

    <div
        class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="p-8 text-[10px] font-black text-gray-400 uppercase tracking-widest">Submitter</th>
                        <th class="p-8 text-[10px] font-black text-gray-400 uppercase tracking-widest">Message Content
                        </th>
                        <th class="p-8 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="p-8 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="feedbackTableBody" class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    <?php include __DIR__ . '/partials/feedback_rows.php'; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Global Action Form -->
<form id="globalActionForm" method="POST" class="hidden">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
    <input type="hidden" name="id" id="actionId">
    <input type="hidden" name="action" id="actionType">
</form>

<script>
    function triggerAction(id, action, confirmMsg = null) {
        if (confirmMsg) {
            showGlobalConfirm({
                title: 'Terminate Signal?',
                message: `Are you sure you want to permanently delete this user submission? This action belongs to the <span class="text-red-500 font-bold">Purge Protocol</span> and cannot be undone.`,
                icon: 'fa-trash-alt',
                color: 'danger',
                confirmText: 'Execute Purge',
                onConfirm: () => {
                    document.getElementById('actionId').value = id;
                    document.getElementById('actionType').value = action;
                    document.getElementById('globalActionForm').submit();
                }
            });
        } else {
            // No confirmation needed (e.g. archiving)
            document.getElementById('actionId').value = id;
            document.getElementById('actionType').value = action;
            document.getElementById('globalActionForm').submit();
        }
    }

    function triggerBulkAction(action, confirmMsg = null) {
        showGlobalConfirm({
            title: 'Purge Processed?',
            message: `Are you sure you want to wipe all <span class="text-emerald-500 font-bold">Processed Signals</span>? this will clean up the repository hierarchy.`,
            icon: 'fa-broom',
            color: 'danger',
            confirmText: 'Purge All',
            onConfirm: () => {
                document.getElementById('actionId').value = '';
                document.getElementById('actionType').value = action;
                document.getElementById('globalActionForm').submit();
            }
        });
    }
</script>

<script>
    // AJAX Search Implementation
    const feedbackSearchForm = document.getElementById('feedbackSearchForm');
    const feedbackSearchInput = document.getElementById('feedbackSearchInput');
    const feedbackTableBody = document.getElementById('feedbackTableBody');
    const feedbackCount = document.getElementById('feedbackCount');

    let debounceTimer;

    const performSearch = () => {
        const formData = new FormData(feedbackSearchForm);
        const params = new URLSearchParams(formData);
        params.append('ajax', '1');

        // Update URL without reloading
        const newUrl = `${window.location.pathname}?${params.toString()}`.replace('&ajax=1', '');
        window.history.pushState({}, '', newUrl);

        fetch(`?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                if (feedbackTableBody) feedbackTableBody.innerHTML = data.html;
                if (feedbackCount) feedbackCount.textContent = data.count;
            })
            .catch(error => console.error('Error:', error));
    };

    if (feedbackSearchInput) {
        feedbackSearchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(performSearch, 300);
        });
    }

    if (feedbackSearchForm) {
        feedbackSearchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            performSearch();
        });
    }
</script>

<?php
require_once __DIR__ . '/layout_footer.php';
?>