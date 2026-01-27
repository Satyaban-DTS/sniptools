<?php
// web/views/admin/dashboard.php
// Assumes auth check passed

// 1. Fetch Stats
$visitCount = $pdo->query("SELECT COUNT(*) FROM visits")->fetchColumn();
$toolCount = $pdo->query("SELECT COUNT(*) FROM tools")->fetchColumn();
$activeToolCount = $pdo->query("SELECT COUNT(*) FROM tools WHERE is_active=1")->fetchColumn();

// 2. Fetch Tools for Management
$toolsList = $pdo->query("SELECT * FROM tools ORDER BY category_id, name")->fetchAll();

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
            // Refresh
            header("Location: " . url('admin/dashboard'));
            exit;
        }

        if ($_POST['action'] === 'update_settings') {
            $keys = ['site_name', 'ads_enabled', 'maintenance_mode', 'ad_code_header', 'ad_code_footer', 'ad_code_sidebar', 'ad_code_head'];
            $stmt = $pdo->prepare("REPLACE INTO settings (`key`, value) VALUES (?, ?)");
            foreach ($keys as $k) {
                if (isset($_POST[$k])) {
                    $stmt->execute([$k, $_POST[$k]]);
                }
            }
            // Refresh
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
    <title>Admin Dashboard -
        <?php echo APP_NAME; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen">

    <!-- Top Bar -->
    <header class="bg-gray-800 border-b border-gray-700 h-16 flex items-center justify-between px-8 sticky top-0 z-50">
        <div class="flex items-center space-x-4">
            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-bolt text-white"></i>
            </div>
            <span class="font-bold text-lg tracking-tight">Admin<span class="text-gray-500">Panel</span></span>
        </div>
        <div class="flex items-center space-x-6">
            <a href="<?php echo url(); ?>" target="_blank"
                class="text-sm font-bold text-gray-400 hover:text-white transition-colors">
                View Site <i class="fas fa-external-link-alt ml-1"></i>
            </a>
            <div class="h-6 w-[1px] bg-gray-700"></div>
            <a href="<?php echo url('admin/profile'); ?>"
                class="text-sm font-bold text-gray-400 hover:text-white transition-colors">
                Profile
            </a>
            <div class="h-6 w-[1px] bg-gray-700"></div>
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
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-gray-800 p-6 rounded-2xl border border-gray-700">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Total Visits</h3>
                    <p class="text-3xl font-black text-white">
                        <?php echo number_format($visitCount); ?>
                    </p>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl border border-gray-700">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Active Tools</h3>
                    <p class="text-3xl font-black text-emerald-400">
                        <?php echo $activeToolCount; ?> <span class="text-base text-gray-600">/
                            <?php echo $toolCount; ?>
                        </span>
                    </p>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl border border-gray-700">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Ads Status</h3>
                    <p
                        class="text-3xl font-black <?php echo $settings['ads_enabled'] == '1' ? 'text-green-400' : 'text-red-400'; ?>">
                        <?php echo $settings['ads_enabled'] == '1' ? 'ON' : 'OFF'; ?>
                    </p>
                </div>
            </div>

            <!-- Tool Management -->
            <div class="bg-gray-800 rounded-3xl border border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                    <h2 class="font-bold text-xl">Tool Management</h2>
                    <span class="text-xs bg-gray-700 text-gray-300 px-3 py-1 rounded-full font-bold">
                        <?php echo count($toolsList); ?> Tools
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-900/50 text-gray-400 font-bold uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">Tool Name</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Views</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($toolsList as $tool): ?>
                                <tr class="hover:bg-gray-700/50 transition-colors group">
                                    <td class="px-6 py-4 font-bold text-white flex items-center">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gray-700 flex items-center justify-center mr-3 text-gray-400">
                                            <i class="fas <?php echo $tool['icon']; ?>"></i>
                                        </div>
                                        <?php echo $tool['name']; ?>
                                        <?php if ($tool['is_featured']): ?>
                                            <i class="fas fa-star text-yellow-500 ml-2 text-xs" title="Featured"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 uppercase text-xs font-bold tracking-wider">
                                        <?php echo $tool['category_id']; ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 font-mono">
                                        <?php echo number_format($tool['view_count']); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="action" value="toggle_tool">
                                            <input type="hidden" name="tool_id" value="<?php echo $tool['id']; ?>">
                                            <input type="hidden" name="current_state"
                                                value="<?php echo $tool['is_active']; ?>">
                                            <button type="submit"
                                                class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all <?php echo $tool['is_active'] ? 'bg-green-500/10 text-green-400 hover:bg-green-500 hover:text-white' : 'bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white'; ?>">
                                                <?php echo $tool['is_active'] ? 'Active' : 'Disabled'; ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Col: Settings & Ads -->
        <div class="space-y-8">

            <form method="POST" class="space-y-8">
                <input type="hidden" name="action" value="update_settings">

                <!-- Global Toggle -->
                <div class="bg-gray-800 p-6 rounded-3xl border border-gray-700">
                    <h2 class="font-bold text-xl mb-6">Global Settings</h2>

                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-gray-900 rounded-2xl border border-gray-700">
                            <div>
                                <h4 class="font-bold text-white text-sm">Allow Ads</h4>
                                <p class="text-xs text-gray-500">Toggle all ad units globally.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="ads_enabled" value="0">
                                <input type="checkbox" name="ads_enabled" value="1" class="sr-only peer" <?php echo $settings['ads_enabled'] ? 'checked' : ''; ?>>
                                <div
                                    class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                                </div>
                            </label>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 bg-gray-900 rounded-2xl border border-gray-700">
                            <div>
                                <h4 class="font-bold text-white text-sm">Maintenance Mode</h4>
                                <p class="text-xs text-gray-500">Show "Under Construction" to users.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="maintenance_mode" value="0">
                                <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" <?php echo $settings['maintenance_mode'] ? 'checked' : ''; ?>>
                                <div
                                    class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Ad Codes -->
                <div class="bg-gray-800 p-6 rounded-3xl border border-gray-700">
                    <h2 class="font-bold text-xl mb-6">Ad Assignments</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Head Script (Before &lt;/head&gt;)</label>
                            <textarea name="ad_code_head" rows="3"
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-xs font-mono text-gray-300 focus:border-purple-500 outline-none" placeholder="<script>...</script>"><?php echo htmlspecialchars($settings['ad_code_head'] ?? ''); ?></textarea>
                            <p class="text-[10px] text-gray-500 mt-1">Useful for AdCash, Google AdSense, or Analytics. Outputs before &lt;/head&gt;.</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Header /
                                Top (HTML)</label>
                            <textarea name="ad_code_header" rows="3"
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-xs font-mono text-gray-300 focus:border-purple-500 outline-none"><?php echo htmlspecialchars($settings['ad_code_header'] ?? ''); ?></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Sidebar
                                (HTML)</label>
                            <textarea name="ad_code_sidebar" rows="3"
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-xs font-mono text-gray-300 focus:border-purple-500 outline-none"><?php echo htmlspecialchars($settings['ad_code_sidebar'] ?? ''); ?></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Footer
                                (HTML)</label>
                            <textarea name="ad_code_footer" rows="3"
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-xs font-mono text-gray-300 focus:border-purple-500 outline-none"><?php echo htmlspecialchars($settings['ad_code_footer'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-purple-600/20">
                    Save Changes
                </button>
            </form>

        </div>
    </div>

</body>

</html>