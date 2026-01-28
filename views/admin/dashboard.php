<?php
// web/views/admin/dashboard.php
// Assumes auth check passed

// 1. Fetch Stats
$totalViews = $pdo->query("SELECT COUNT(*) FROM visits")->fetchColumn();
$uniqueVisitors = $pdo->query("SELECT COUNT(DISTINCT ip_hash) FROM visits")->fetchColumn();
// Returning visitors are those whose ip_hash appears more than once in the visits table
$returningVisitors = $pdo->query("SELECT COUNT(*) FROM (SELECT ip_hash FROM visits GROUP BY ip_hash HAVING COUNT(*) > 1) AS t")->fetchColumn();

$toolCount = $pdo->query("SELECT COUNT(*) FROM tools")->fetchColumn();
$activeToolCount = $pdo->query("SELECT COUNT(*) FROM tools WHERE is_active=1")->fetchColumn();
$unreadFeedbackCount = $pdo->query("SELECT COUNT(*) FROM feedback WHERE status = 'new'")->fetchColumn();

// 2. Fetch Tools for Management
$toolsListRaw = $pdo->query("SELECT t.*, c.name as cat_name FROM tools t LEFT JOIN categories c ON t.category_id = c.id ORDER BY t.category_id, t.name")->fetchAll();
$toolsByCategory = [];
foreach ($toolsListRaw as $t) {
    $groupName = $t['cat_name'] ?? 'Uncategorized';
    $toolsByCategory[$groupName][] = $t;
}

// 3. Fetch Settings
$settingsRAW = $pdo->query("SELECT * FROM settings")->fetchAll();
$settings = [];
foreach ($settingsRAW as $s)
    $settings[$s['key']] = $s['value'];

// 4. Handle POST actions (Toggle Tool, Update Settings)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determine action
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'toggle_tool') {
            $tid = $_POST['tool_id'];
            $newState = $_POST['current_state'] == 1 ? 0 : 1;
            $stmt = $pdo->prepare("UPDATE tools SET is_active = ? WHERE id = ?");
            $stmt->execute([$newState, $tid]);
            set_flash_message("Tool visibility updated successfully.");
            header("Location: " . url('admin/dashboard'));
            exit;
        }

        if ($_POST['action'] === 'update_settings') {
            $keys = ['site_name', 'ads_enabled', 'maintenance_mode', 'ad_code_header', 'ad_code_footer', 'ad_code_sidebar', 'ad_code_head'];
            foreach ($keys as $k) {
                $val = $_POST[$k] ?? '0';
                $stmt = $pdo->prepare("INSERT INTO settings (`key`, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)");
                $stmt->execute([$k, $val]);
            }
            set_flash_message("Global settings applied successfully.");
            header("Location: " . url('admin/dashboard'));
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo APP_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include_once __DIR__ . '/../../includes/toast_provider.php'; ?>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#c026d3',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#0f111a] text-gray-100 min-h-screen font-sans">

    <!-- Top Bar -->
    <header
        class="bg-gray-800/50 backdrop-blur-md border-b border-gray-700 h-16 flex items-center justify-between px-8 sticky top-0 z-50">
        <div class="flex items-center space-x-4">
            <a href="<?php echo url('admin'); ?>" class="flex items-center space-x-3 group">
                <div
                    class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-105 transition-transform">
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
                class="relative text-sm font-bold text-gray-400 hover:text-white transition-colors flex items-center">
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

    <div class="p-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Col: Stats & Tools -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-gray-800 p-6 rounded-3xl border border-gray-700 shadow-xl overflow-hidden relative group">
                    <div
                        class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity text-5xl">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Visit Analytics</h3>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-3xl font-black text-white"><?php echo number_format($totalViews); ?></p>
                        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Total Hits</span>
                    </div>
                    <div class="mt-4 flex items-center space-x-4 text-xs">
                        <div class="flex flex-col">
                            <span
                                class="text-emerald-400 font-black"><?php echo number_format($uniqueVisitors); ?></span>
                            <span class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Unique</span>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-primary font-black"><?php echo number_format($returningVisitors); ?></span>
                            <span
                                class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Returning</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gray-800 p-6 rounded-3xl border border-gray-700 shadow-xl overflow-hidden relative group">
                    <div
                        class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity text-5xl">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Inventory</h3>
                    <p class="text-3xl font-black text-emerald-400">
                        <?php echo $activeToolCount; ?> <span class="text-base text-gray-600">/
                            <?php echo $toolCount; ?></span>
                    </p>
                    <div class="mt-4 text-[10px] text-gray-500 font-bold uppercase tracking-wider">
                        <?php echo round(($activeToolCount / max($toolCount, 1)) * 100); ?>% Active and Online
                    </div>
                </div>

                <div
                    class="bg-gray-800 p-6 rounded-3xl border border-gray-700 shadow-xl overflow-hidden relative group">
                    <div
                        class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity text-5xl">
                        <i class="fas fa-ad"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Monetization</h3>
                    <p
                        class="text-3xl font-black <?php echo ($settings['ads_enabled'] ?? '0') == '1' ? 'text-blue-400' : 'text-gray-600'; ?>">
                        <?php echo ($settings['ads_enabled'] ?? '0') == '1' ? 'ACTIVE' : 'PAUSED'; ?>
                    </p>
                    <div class="mt-4 flex items-center space-x-1">
                        <span
                            class="w-1.5 h-1.5 rounded-full <?php echo ($settings['ads_enabled'] ?? '0') == '1' ? 'bg-blue-400 animate-pulse' : 'bg-gray-600'; ?>"></span>
                        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Ad Network
                            Connected</span>
                    </div>
                </div>
            </div>

            <!-- Tool Management (Category Wise) -->
            <div class="bg-gray-800 rounded-3xl border border-gray-700 shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-700 bg-gray-800/50">
                    <h2 class="font-bold text-xl">Tool Management</h2>
                    <p class="text-xs text-gray-500 mt-1">Configure visibility and monitor performance across all
                        categories.</p>
                </div>

                <div class="overflow-x-auto">
                    <?php
                    ksort($toolsByCategory);
                    foreach ($toolsByCategory as $catName => $tools):
                        ?>
                        <div class="bg-gray-900/40 px-6 py-3 border-y border-gray-700 flex items-center justify-between">
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500"><?php echo $catName; ?></span>
                            <span class="text-[10px] font-bold text-gray-600 italic"><?php echo count($tools); ?> Items in
                                Category</span>
                        </div>
                        <table class="w-full text-left text-sm">
                            <tbody class="divide-y divide-gray-700">
                                <?php foreach ($tools as $tool): ?>
                                    <tr class="hover:bg-gray-700/50 transition-colors group">
                                        <td class="px-6 py-4 font-bold text-white flex items-center max-w-sm">
                                            <div
                                                class="w-9 h-9 rounded-xl bg-gray-700/50 flex items-center justify-center mr-4 text-gray-400 group-hover:bg-primary group-hover:text-white transition-all shadow-md group-hover:shadow-primary/20">
                                                <i class="fas <?php echo $tool['icon']; ?>"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center">
                                                    <span class="truncate"><?php echo $tool['name']; ?></span>
                                                    <?php if ($tool['is_featured']): ?>
                                                        <i class="fas fa-star text-yellow-500 ml-2 text-[10px]"
                                                            title="Featured Tool"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-[10px] text-gray-500 font-normal line-clamp-1 mt-0.5">
                                                    <?php echo $tool['slug']; ?>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-400 font-mono text-xs flex items-center">
                                                <i class="fas fa-eye mr-2 text-[10px] opacity-40"></i>
                                                <?php echo number_format($tool['view_count']); ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" class="inline">
                                                <input type="hidden" name="action" value="toggle_tool">
                                                <input type="hidden" name="tool_id" value="<?php echo $tool['id']; ?>">
                                                <input type="hidden" name="current_state"
                                                    value="<?php echo $tool['is_active']; ?>">
                                                <button type="submit"
                                                    class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all <?php echo $tool['is_active'] ? 'bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500 hover:text-white shadow-lg shadow-emerald-500/10' : 'bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white shadow-lg shadow-red-500/10'; ?>">
                                                    <?php echo $tool['is_active'] ? 'Public' : 'Hidden'; ?>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- Right Col: Config -->
        <div class="space-y-8">
            <form method="POST" class="space-y-8">
                <input type="hidden" name="action" value="update_settings">

                <!-- Global Logic -->
                <div class="bg-gray-800 p-8 rounded-[2rem] border border-gray-700 shadow-2xl">
                    <h2 class="font-bold text-xl mb-6 flex items-center">
                        <i class="fas fa-cog mr-3 text-primary"></i>
                        Site Config
                    </h2>

                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl border border-gray-700 hover:border-primary/30 transition-colors">
                            <div>
                                <h4 class="font-bold text-white text-sm">Monetization</h4>
                                <p class="text-[10px] text-gray-500 uppercase tracking-wider font-bold mt-0.5">Toggle
                                    Global Ad Load</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="ads_enabled" value="0">
                                <input type="checkbox" name="ads_enabled" value="1" class="sr-only peer" <?php echo ($settings['ads_enabled'] ?? '0') == '1' ? 'checked' : ''; ?>>
                                <div
                                    class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </label>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl border border-gray-700 hover:border-red-500/30 transition-colors">
                            <div>
                                <h4 class="font-bold text-white text-sm">Maintenance</h4>
                                <p class="text-[10px] text-gray-500 uppercase tracking-wider font-bold mt-0.5">Frontend
                                    Lockdown</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="maintenance_mode" value="0">
                                <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" <?php echo ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : ''; ?>>
                                <div
                                    class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Injection Points -->
                <div class="bg-gray-800 p-8 rounded-[2rem] border border-gray-700 shadow-2xl">
                    <h2 class="font-bold text-xl mb-6 flex items-center">
                        <i class="fas fa-terminal mr-3 text-blue-500"></i>
                        Code Injection
                    </h2>
                    <div class="space-y-6">
                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3">Header
                                Stack (Head)</label>
                            <textarea name="ad_code_head" rows="4"
                                class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-4 py-4 text-xs font-mono text-gray-400 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="&lt;script&gt;...&lt;/script&gt;"><?php echo htmlspecialchars($settings['ad_code_head'] ?? ''); ?></textarea>
                            <p class="text-[10px] text-gray-500 mt-2 font-bold uppercase tracking-tighter italic">
                                Executed before &lt;/head&gt;</p>
                        </div>

                        <div class="h-[1px] bg-gray-700"></div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3">Top
                                Banner Placement</label>
                            <textarea name="ad_code_header" rows="3"
                                class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-4 py-4 text-xs font-mono text-gray-400 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"><?php echo htmlspecialchars($settings['ad_code_header'] ?? ''); ?></textarea>
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3">Sidebar
                                Sticky Placement</label>
                            <textarea name="ad_code_sidebar" rows="3"
                                class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-4 py-4 text-xs font-mono text-gray-400 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"><?php echo htmlspecialchars($settings['ad_code_sidebar'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-primary to-blue-600 hover:from-primary/80 hover:to-blue-500 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-primary/20 uppercase tracking-widest text-xs">
                    Commit Site Changes
                </button>
            </form>

        </div>
    </div>

</body>

</html>