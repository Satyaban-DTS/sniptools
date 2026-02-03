<?php
// views/admin/settings.php

// 1. Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_settings') {
        $keys = [
            'site_name',
            'ads_enabled',
            'maintenance_mode',
            'ad_code_header',
            'ad_code_footer',
            'ad_code_sidebar',
            'ad_code_head',
            'cta_badge',
            'cta_title',
            'cta_description',
            'cta_button_text',
            'cta_button_link',
            'cta2_button_text',
            'cta2_button_link',
            'show_recent_tools',
            'ads_header_enabled',
            'ads_sidebar_enabled',
            'ads_footer_enabled'
        ];

        foreach ($keys as $k) {
            $val = $_POST[$k] ?? '0';
            $stmt = $pdo->prepare("INSERT INTO settings (`key`, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)");
            $stmt->execute([$k, $val]);
        }

        set_flash_message("Site settings updated successfully.");
        header("Location: " . url('admin/settings'));
        exit;
    }
}

// 2. Fetch Settings
$pageTitle = 'Site Settings';
$subRoute = 'settings';

$settingsRAW = $pdo->query("SELECT * FROM settings")->fetchAll();
$settings = [];
foreach ($settingsRAW as $s) {
    $settings[$s['key']] = $s['value'];
}

// Fetch Tools and Categories for Link Selection
$tools = $pdo->query("SELECT t.name, t.slug, c.id as cat_id FROM tools t LEFT JOIN categories c ON t.category_id = c.id ORDER BY t.name")->fetchAll();
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

require_once __DIR__ . '/layout_header.php';
?>

<div class="space-y-8 pb-20">
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Site <span
                    class="text-primary italic">Settings</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 opacity-60">Global configuration &
                injection</p>
        </div>
    </header>

    <?php if ($msg = get_flash_message()): ?>
        <div
            class="bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-500 rounded-2xl p-4 flex items-center space-x-3">
            <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
            <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">
                <?php echo $msg; ?>
            </span>
        </div>
    <?php endif; ?>

    <form method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        <input type="hidden" name="action" value="update_settings">

        <!-- Column 1: Site Controls & CTA -->
        <div class="space-y-8">
            <!-- Site Controls -->
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl">
                <h2 class="font-black text-lg mb-8 flex items-center uppercase tracking-tight">
                    <i class="fas fa-sliders-h mr-3 text-primary"></i>
                    Site Controls
                </h2>

                <div class="space-y-6">
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Site
                            Name</label>
                        <input type="text" name="site_name"
                            value="<?php echo htmlspecialchars($settings['site_name'] ?? 'SnipTools'); ?>"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 dark:text-white outline-none transition-all">
                    </div>

                    <div
                        class="flex items-center justify-between p-5 bg-gray-50/50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-700/50 hover:border-primary/30 transition-colors">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm">Monetization</h4>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest font-black mt-1">Global Ad Load
                                Control</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="ads_enabled" value="0">
                            <input type="checkbox" name="ads_enabled" value="1" class="sr-only peer" <?php echo ($settings['ads_enabled'] ?? '0') == '1' ? 'checked' : ''; ?>>
                            <div
                                class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>

                    <div
                        class="flex items-center justify-between p-5 bg-gray-50/50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-700/50 hover:border-red-500/30 transition-colors">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm">Maintenance Mode</h4>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest font-black mt-1">Instant Site
                                Lockdown</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="maintenance_mode" value="0">
                            <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" <?php echo ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : ''; ?>>
                            <div
                                class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600">
                            </div>
                        </label>
                    </div>

                    <div
                        class="flex items-center justify-between p-5 bg-gray-50/50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-700/50 hover:border-blue-500/30 transition-colors">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm">Recent Tools</h4>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest font-black mt-1">Sidebar Tool
                                History</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="show_recent_tools" value="0">
                            <input type="checkbox" name="show_recent_tools" value="1" class="sr-only peer" <?php echo ($settings['show_recent_tools'] ?? '1') == '1' ? 'checked' : ''; ?>>
                            <div
                                class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Call to Action (CTA) Section -->
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl">
                <h2 class="font-black text-lg mb-8 flex items-center uppercase tracking-tight">
                    <i class="fas fa-bullhorn mr-3 text-accent"></i>
                    Call to Action (CTA)
                </h2>
                <div class="space-y-6">
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Badge
                            Text</label>
                        <input type="text" name="cta_badge"
                            value="<?php echo htmlspecialchars($settings['cta_badge'] ?? ''); ?>"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 dark:text-white outline-none transition-all"
                            placeholder="e.g. PHASE 2: LIVE TOOLS">
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">CTA
                            Title (HTML Supported)</label>
                        <textarea name="cta_title" rows="3"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 dark:text-white outline-none transition-all"
                            placeholder="e.g. Built for speed. <br> Designed for <span>Security.</span>"><?php echo htmlspecialchars($settings['cta_title'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">CTA
                            Description</label>
                        <textarea name="cta_description" rows="2"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 dark:text-white outline-none transition-all"
                            placeholder="Briefly describe why users should act..."><?php echo htmlspecialchars($settings['cta_description'] ?? ''); ?></textarea>
                    </div>

                    <!-- Button 1 Configuration -->
                    <div
                        class="p-6 bg-gray-50/50 dark:bg-gray-900/30 rounded-3xl border border-gray-100 dark:border-gray-700/50">
                        <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-4">Primary Button
                        </p>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label
                                    class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Button
                                    Text</label>
                                <input type="text" name="cta_button_text"
                                    value="<?php echo htmlspecialchars($settings['cta_button_text'] ?? ''); ?>"
                                    class="w-full bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs font-bold focus:border-primary outline-none transition-all dark:text-white"
                                    placeholder="e.g. Get Started">
                            </div>
                            <div>
                                <label
                                    class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Select
                                    Destination</label>
                                <select name="cta_button_link"
                                    class="w-full bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs font-bold focus:border-primary outline-none transition-all dark:text-white">
                                    <option value="/">Home Page</option>
                                    <option value="/tools" <?php echo ($settings['cta_button_link'] ?? '') === '/tools' ? 'selected' : ''; ?>>All Tools</option>
                                    <optgroup label="Tools">
                                        <?php foreach ($tools as $t): ?>
                                            <?php $link = "/tools/{$t['cat_id']}/{$t['slug']}"; ?>
                                            <option value="<?php echo $link; ?>" <?php echo ($settings['cta_button_link'] ?? '') === $link ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($t['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <optgroup label="Categories">
                                        <?php foreach ($categories as $c): ?>
                                            <?php $link = "/tools/{$c['id']}"; ?>
                                            <option value="<?php echo $link; ?>" <?php echo ($settings['cta_button_link'] ?? '') === $link ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($c['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Button 2 Configuration -->
                    <div
                        class="p-6 bg-gray-50/50 dark:bg-gray-900/30 rounded-3xl border border-gray-100 dark:border-gray-700/50">
                        <p class="text-[10px] font-black text-accent uppercase tracking-widest mb-4">Secondary Button
                        </p>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label
                                    class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Button
                                    Text</label>
                                <input type="text" name="cta2_button_text"
                                    value="<?php echo htmlspecialchars($settings['cta2_button_text'] ?? ''); ?>"
                                    class="w-full bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs font-bold focus:border-primary outline-none transition-all dark:text-white"
                                    placeholder="e.g. Try Features">
                            </div>
                            <div>
                                <label
                                    class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Select
                                    Destination</label>
                                <select name="cta2_button_link"
                                    class="w-full bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs font-bold focus:border-primary outline-none transition-all dark:text-white">
                                    <option value="/">Home Page</option>
                                    <option value="/tools" <?php echo ($settings['cta2_button_link'] ?? '') === '/tools' ? 'selected' : ''; ?>>All Tools</option>
                                    <optgroup label="Tools">
                                        <?php foreach ($tools as $t): ?>
                                            <?php $link = "/tools/{$t['cat_id']}/{$t['slug']}"; ?>
                                            <option value="<?php echo $link; ?>" <?php echo ($settings['cta2_button_link'] ?? '') === $link ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($t['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <optgroup label="Categories">
                                        <?php foreach ($categories as $c): ?>
                                            <?php $link = "/tools/{$c['id']}"; ?>
                                            <option value="<?php echo $link; ?>" <?php echo ($settings['cta2_button_link'] ?? '') === $link ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($c['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 2: Code Injection -->
        <div class="space-y-8">
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl">
                <h2 class="font-black text-lg mb-8 flex items-center uppercase tracking-tight">
                    <i class="fas fa-terminal mr-3 text-blue-500"></i>
                    Code Injection
                </h2>
                <div class="space-y-6">
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Header
                            Section (Inside &lt;head&gt;)</label>
                        <textarea name="ad_code_head" rows="6"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-xs font-mono text-gray-500 dark:text-gray-400 outline-none transition-all"
                            placeholder="<!-- AdSense script, meta tags, etc -->"><?php echo htmlspecialchars($settings['ad_code_head'] ?? ''); ?></textarea>
                    </div>

                    <div class="h-[1px] bg-gray-100 dark:bg-gray-700/50"></div>

                    <div>
                        <div class="flex items-center justify-between mb-3 ml-1">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Top
                                Banner (After Head)</label>
                            <label class="relative inline-flex items-center cursor-pointer scale-75">
                                <input type="hidden" name="ads_header_enabled" value="0">
                                <input type="checkbox" name="ads_header_enabled" value="1" class="sr-only peer" <?php echo ($settings['ads_header_enabled'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <div
                                    class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500">
                                </div>
                            </label>
                        </div>
                        <textarea name="ad_code_header" rows="3"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-xs font-mono text-gray-500 dark:text-gray-400 outline-none transition-all"><?php echo htmlspecialchars($settings['ad_code_header'] ?? ''); ?></textarea>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3 ml-1">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Sidebar
                                Slot</label>
                            <label class="relative inline-flex items-center cursor-pointer scale-75">
                                <input type="hidden" name="ads_sidebar_enabled" value="0">
                                <input type="checkbox" name="ads_sidebar_enabled" value="1" class="sr-only peer" <?php echo ($settings['ads_sidebar_enabled'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <div
                                    class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                                </div>
                            </label>
                        </div>
                        <textarea name="ad_code_sidebar" rows="3"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-xs font-mono text-gray-500 dark:text-gray-400 outline-none transition-all"><?php echo htmlspecialchars($settings['ad_code_sidebar'] ?? ''); ?></textarea>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3 ml-1">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Footer
                                Banner</label>
                            <label class="relative inline-flex items-center cursor-pointer scale-75">
                                <input type="hidden" name="ads_footer_enabled" value="0">
                                <input type="checkbox" name="ads_footer_enabled" value="1" class="sr-only peer" <?php echo ($settings['ads_footer_enabled'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <div
                                    class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </label>
                        </div>
                        <textarea name="ad_code_footer" rows="3"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-5 py-4 text-xs font-mono text-gray-500 dark:text-gray-400 outline-none transition-all"><?php echo htmlspecialchars($settings['ad_code_footer'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-primary to-accent hover:scale-[1.02] active:scale-95 text-white font-black py-6 rounded-[2rem] transition-all shadow-xl shadow-primary/20 uppercase tracking-[0.2em] text-xs">
                Apply Global Settings
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>