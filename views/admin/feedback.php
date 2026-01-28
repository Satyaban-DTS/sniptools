<?php
// views/admin/feedback.php
$pageTitle = "Feedback Management";
require_once __DIR__ . '/../../includes/auth.php';
checkAdmin();

// Handle Mark as Read / Delete
if (isset($_POST['action']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($_POST['action'] === 'read') {
        $pdo->prepare("UPDATE feedback SET status = 'read' WHERE id = ?")->execute([$id]);
        set_flash_message("Feedback marked as read.");
    }
    if ($_POST['action'] === 'delete') {
        $pdo->prepare("DELETE FROM feedback WHERE id = ?")->execute([$id]);
        set_flash_message("Feedback deleted successfully.", "info");
    }
    // Redirect to self to prevent resubmission
    header("Location: " . url('admin/feedback'));
    exit;
}

$feedbacks = $pdo->query("SELECT * FROM feedback ORDER BY created_at DESC")->fetchAll();
$unreadFeedbackCount = $pdo->query("SELECT COUNT(*) FROM feedback WHERE status = 'new'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - SnipTools Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include_once __DIR__ . '/../../includes/toast_provider.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen">
    <!-- Top Bar -->
    <header class="bg-gray-800 border-b border-gray-700 h-16 flex items-center justify-between px-8 sticky top-0 z-50">
        <div class="flex items-center space-x-4">
            <a href="<?php echo url('admin'); ?>" class="flex items-center space-x-3 group">
                <div
                    class="w-9 h-9 bg-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-600/20 group-hover:scale-105 transition-transform">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                <span class="font-bold text-lg tracking-tight">Admin<span class="text-gray-500">Panel</span></span>
            </a>
        </div>
        <div class="flex items-center space-x-6">
            <a href="<?php echo url(); ?>" target="_blank"
                class="text-sm font-bold text-gray-400 hover:text-white transition-colors">
                View Site <i class="fas fa-external-link-alt ml-1"></i>
            </a>
            <div class="h-6 w-[1px] bg-gray-700 mx-2"></div>
            <a href="<?php echo url('admin/feedback'); ?>"
                class="relative text-sm font-bold text-white transition-colors flex items-center">
                Feedback
                <?php if (($unreadFeedbackCount ?? 0) > 0): ?>
                    <span
                        class="ml-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] text-white animate-pulse">
                        <?php echo $unreadFeedbackCount; ?>
                    </span>
                <?php endif; ?>
            </a>
            <div class="h-6 w-[1px] bg-gray-700 mx-2"></div>
            <a href="<?php echo url('admin/profile'); ?>"
                class="text-sm font-bold text-gray-400 hover:text-white transition-colors">
                Profile
            </a>
            <div class="h-6 w-[1px] bg-gray-700 mx-2"></div>
            <a href="<?php echo url('admin/logout'); ?>"
                class="text-sm font-bold text-red-400 hover:text-red-300 transition-colors">
                Logout
            </a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-8">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">User Feedback</h1>
                <p class="text-sm text-gray-400 mt-1">Manage feedback submissions from the widget.</p>
            </div>
        </header>

        <div class="bg-gray-800 rounded-2xl shadow-sm border border-gray-700 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 border-b border-gray-700">
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-wider">User</th>
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Message</th>
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php if (empty($feedbacks)): ?>
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500 italic">No feedback received yet.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($feedbacks as $f): ?>
                        <tr class="hover:bg-gray-700/50 transition-colors group">
                            <td class="p-6">
                                <div class="font-bold text-white">
                                    <?php echo htmlspecialchars($f['name']); ?>
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    <?php echo htmlspecialchars($f['email']); ?>
                                </div>
                                <div class="text-[10px] text-gray-500 mt-1">
                                    <?php echo date('M j, Y H:i', strtotime($f['created_at'])); ?>
                                </div>
                            </td>
                            <td class="p-6">
                                <p class="text-sm text-gray-300 leading-relaxed max-w-xl">
                                    <?php echo nl2br(htmlspecialchars($f['message'])); ?>
                                </p>
                            </td>
                            <td class="p-6">
                                <?php if ($f['status'] === 'new'): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">New</span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 text-gray-300">Read</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-6 text-right">
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                                    <?php if ($f['status'] === 'new'): ?>
                                        <button type="submit" name="action" value="read"
                                            class="text-blue-400 hover:text-blue-300 font-bold text-xs uppercase tracking-wider mr-4">Mark
                                            Read</button>
                                    <?php endif; ?>
                                    <button type="submit" name="action" value="delete"
                                        class="text-red-400 hover:text-red-300 font-bold text-xs uppercase tracking-wider"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </main>
    </div>
</body>

</html>