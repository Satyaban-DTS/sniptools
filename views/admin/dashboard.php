<?php
// web/views/admin/dashboard.php

// 1. Handle POST actions first (BEFORE any HTML output)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Dashboard specific POST actions
    }
}

// 2. Fetch Data needed for view
$pageTitle = 'Admin Dashboard';
$subRoute = 'dashboard';

// Fetch Stats
$totalViews = $pdo->query("SELECT COUNT(*) FROM visits")->fetchColumn();
$uniqueVisitors = $pdo->query("SELECT COUNT(DISTINCT ip_hash) FROM visits")->fetchColumn();
$returningVisitors = $pdo->query("SELECT COUNT(*) FROM (SELECT ip_hash FROM visits GROUP BY ip_hash HAVING COUNT(*) > 1) AS t")->fetchColumn();

// Daily Visits for Chart (Last 7 Days)
$dailyVisits = $pdo->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM visits WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY DATE(created_at) ORDER BY date ASC")->fetchAll();
$chartLabels = [];
$chartData = [];
$dateMap = [];
foreach ($dailyVisits as $v)
    $dateMap[$v['date']] = $v['count'];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $chartLabels[] = date('D', strtotime($d));
    $chartData[] = $dateMap[$d] ?? 0;
}

// Top Countries
$topCountries = $pdo->query("SELECT country, COUNT(*) as count FROM activity_log WHERE country != 'Unknown' GROUP BY country ORDER BY count DESC LIMIT 5")->fetchAll();

// Browser Breakdown
$browserStats = $pdo->query("SELECT browser, COUNT(*) as count FROM activity_log GROUP BY browser ORDER BY count DESC LIMIT 4")->fetchAll();

// OS Breakdown
$osStats = $pdo->query("SELECT os, COUNT(*) as count FROM activity_log GROUP BY os ORDER BY count DESC LIMIT 4")->fetchAll();

$toolCount = $pdo->query("SELECT COUNT(*) FROM tools")->fetchColumn();
$activeToolCount = $pdo->query("SELECT COUNT(*) FROM tools WHERE is_active=1")->fetchColumn();
$unreadFeedbackCount = $pdo->query("SELECT COUNT(*) FROM feedback WHERE status = 'new'")->fetchColumn();

// 3. Include Header (Starts Output)
require_once __DIR__ . '/layout_header.php';
?>

<div class="space-y-8">
    <!-- Header -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Dashboard <span
                    class="text-primary italic">Intelligence</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 opacity-60">Real-time performance
                metrics</p>
        </div>
        <div class="flex items-center space-x-3">
            <div
                class="px-4 py-2 bg-emerald-500/10 text-emerald-500 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-500/20">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block mr-2 animate-pulse"></span> SYSTEM
                LIVE
            </div>
        </div>
    </header>

    <!-- Top Row: Quick Metrics (Luxury Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 animate-slide-up">
        <!-- Audience Pulse -->
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-xl relative overflow-hidden group hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all">
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 shadow-sm border border-emerald-500/10">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] opacity-60">Audience
                        </h3>
                        <p class="text-2xl font-black text-gray-900 dark:text-white">
                            <?php echo number_format($uniqueVisitors); ?>
                        </p>
                    </div>
                </div>
                <span
                    class="text-[9px] font-black text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg uppercase tracking-widest">+12%</span>
            </div>
        </div>

        <!-- Deployment Metrics -->
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-xl relative overflow-hidden group hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute -right-6 -top-6 w-24 h-24 bg-primary/10 rounded-full blur-2xl group-hover:bg-primary/20 transition-all">
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-sm border border-primary/10">
                        <i class="fas fa-rocket text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] opacity-60">Inventory
                        </h3>
                        <p class="text-2xl font-black text-primary"><?php echo $activeToolCount; ?></p>
                    </div>
                </div>
                <span
                    class="text-[9px] font-black text-primary bg-primary/10 px-2 py-1 rounded-lg uppercase tracking-widest">Active</span>
            </div>
        </div>

        <!-- Feedback Signal -->
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-xl relative overflow-hidden group hover:shadow-2xl transition-all duration-500">
            <div
                class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all">
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 shadow-sm border border-blue-500/10">
                        <i class="fas fa-satellite-dish text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] opacity-60">Signals
                        </h3>
                        <p class="text-2xl font-black text-blue-500"><?php echo $unreadFeedbackCount; ?></p>
                    </div>
                </div>
                <?php if ($unreadFeedbackCount > 0): ?>
                    <span class="flex h-3 w-3 relative">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Main Analytics & Tools -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Analytics Block (Balanced Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-slide-up" style="animation-delay: 0.1s;">
                <!-- Traffic Chart (Spans 2 columns if needed, but let's keep it 1:1 for balance) -->
                <div
                    class="md:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl flex flex-col h-[400px]">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Traffic Flow</h3>
                            <p class="text-sm font-black text-gray-900 dark:text-white mt-1 uppercase">7-Day Trend
                                Analysis</p>
                        </div>
                        <div class="p-3 bg-primary/10 rounded-2xl text-primary">
                            <i class="fas fa-chart-area text-lg"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-h-0">
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>

                <!-- Global Reach (Ultra Premium) -->
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl overflow-hidden relative group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
                    <div class="relative flex items-center justify-between mb-10">
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Audience</h3>
                            <p
                                class="text-[10px] font-black text-emerald-500 uppercase mt-2 border-l-2 border-emerald-500 pl-3">
                                Geographic Pulse</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-[1.25rem] bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                            <i class="fas fa-globe-americas text-xl"></i>
                        </div>
                    </div>
                    <div class="relative space-y-6">
                        <?php
                        $maxHits = !empty($topCountries) ? max(array_column($topCountries, 'count')) : 1;
                        foreach (array_slice($topCountries, 0, 4) as $c):
                            $percent = ($c['count'] / $maxHits) * 100;
                            ?>
                            <div class="group/item">
                                <div class="flex items-center justify-between mb-2 px-1">
                                    <span
                                        class="text-[11px] font-black text-gray-800 dark:text-white uppercase tracking-tight"><?php echo $c['country']; ?></span>
                                    <span
                                        class="text-[10px] font-black text-gray-400"><?php echo number_format($c['count']); ?>
                                        Hits</span>
                                </div>
                                <div
                                    class="h-1.5 w-full bg-gray-100 dark:bg-gray-900/50 rounded-full overflow-hidden p-[1px]">
                                    <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full transition-all duration-1000"
                                        style="width: <?php echo $percent; ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Environment Breakdown -->
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl"></div>
                    <div class="relative flex items-center justify-between mb-10">
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Environment</h3>
                            <p
                                class="text-[10px] font-black text-blue-500 uppercase mt-2 border-l-2 border-blue-500 pl-3">
                                Client Runtime</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-[1.25rem] bg-blue-500/10 flex items-center justify-center text-blue-500">
                            <i class="fas fa-terminal text-xl"></i>
                        </div>
                    </div>
                    <div class="relative grid grid-cols-2 gap-4">
                        <?php foreach (array_slice($browserStats, 0, 4) as $b):
                            $bName = strtolower($b['browser']);
                            $icon = (strpos($bName, 'chrome') !== false) ? 'fa-chrome' : ((strpos($bName, 'firefox') !== false) ? 'fa-firefox' : 'fa-globe');
                            ?>
                            <div
                                class="bg-gray-50/50 dark:bg-gray-900/40 p-4 rounded-3xl border border-gray-100 dark:border-white/5 transition-all">
                                <i class="fab <?php echo $icon; ?> text-blue-500/50 text-xl mb-2 block"></i>
                                <span
                                    class="text-sm font-black text-gray-900 dark:text-white block"><?php echo $b['count']; ?></span>
                                <span
                                    class="text-[8px] font-black text-gray-400 uppercase tracking-widest truncate block"><?php echo $b['browser']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>


            <!-- Recent Signals (New Widget for balance) -->
            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl overflow-hidden animate-slide-up"
                style="animation-delay: 0.3s;">
                <div
                    class="p-8 border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
                    <div>
                        <h2 class="font-black text-lg uppercase tracking-tight">Recent Signals</h2>
                        <p class="text-xs text-gray-400 font-medium mt-1">Latest incoming feedback from users.</p>
                    </div>
                    <a href="<?php echo url('admin/feedback'); ?>"
                        class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">View
                        All</a>
                </div>
                <div class="p-4">
                    <?php
                    $recentFeedback = $pdo->query("SELECT * FROM feedback ORDER BY created_at DESC LIMIT 3")->fetchAll();
                    if (empty($recentFeedback)): ?>
                        <div class="p-10 text-center text-gray-400 font-bold uppercase tracking-widest text-[10px]">No
                            signals recorded</div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($recentFeedback as $f): ?>
                                <div
                                    class="p-5 bg-gray-50/50 dark:bg-gray-700/30 rounded-3xl border border-gray-100 dark:border-white/5 flex items-start space-x-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 shrink-0">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <span
                                                class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight"><?php echo htmlspecialchars($f['name']); ?></span>
                                            <span
                                                class="text-[9px] font-black text-gray-400"><?php echo date('M d, H:i', strtotime($f['created_at'])); ?></span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-1 italic">
                                            "<?php echo htmlspecialchars($f['message']); ?>"</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar (Sticky Controls & Pulse) -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Sidebar Section -->
            <div class="space-y-8">
                <!-- System Pulse (Refined Alignment) -->
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-2xl">
                    <h2 class="font-black text-xs mb-8 flex items-center uppercase tracking-[0.3em] text-gray-400">
                        <i class="fas fa-heartbeat mr-3 text-red-500"></i>
                        System Pulse
                    </h2>
                    <div class="space-y-6">
                        <div
                            class="p-5 bg-gray-50/50 dark:bg-gray-900/40 rounded-3xl border border-gray-100 dark:border-white/5">
                            <div class="flex items-center justify-between mb-3 px-1">
                                <span
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Database</span>
                                <span
                                    class="text-[9px] font-black text-emerald-500 uppercase bg-emerald-500/10 px-2 py-0.5 rounded-md">Stable</span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 w-[95%] shadow-[0_0_10px_rgba(16,185,129,0.3)]"></div>
                            </div>
                        </div>
                        <div
                            class="p-5 bg-gray-50/50 dark:bg-gray-900/40 rounded-3xl border border-gray-100 dark:border-white/5">
                            <div class="flex items-center justify-between mb-3 px-1">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Cache
                                    Utility</span>
                                <span
                                    class="text-[9px] font-black text-blue-500 uppercase bg-blue-500/10 px-2 py-0.5 rounded-md">Optimal</span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 w-[88%] shadow-[0_0_10px_rgba(59,130,246,0.3)]"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feedback Summary (Luxury Glow) -->
                <a href="<?php echo url('admin/feedback'); ?>"
                    class="relative block p-8 rounded-[2.5rem] overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-primary group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all">
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-10">
                            <div
                                class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white backdrop-blur-md">
                                <i class="fas fa-comments text-xl"></i>
                            </div>
                            <span
                                class="px-3 py-1 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-widest text-white"><?php echo $unreadFeedbackCount; ?>
                                New</span>
                        </div>
                        <h3 class="font-black text-lg uppercase tracking-tight text-white">Community</h3>
                        <p class="text-xs text-white/70 mt-2 font-medium">Respond to submissions and improve your tools.
                        </p>
                    </div>

                    <div
                        class="absolute bottom-6 right-8 text-white/20 text-4xl group-hover:translate-x-2 transition-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chartLabels); ?>,
                datasets: [{
                    label: 'Hits',
                    data: <?php echo json_encode($chartData); ?>,
                    borderColor: '#c026d3',
                    backgroundColor: 'rgba(192, 38, 211, 0.1)',
                    borderWidth: 4,
                    pointBackgroundColor: '#c026d3',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e152e',
                        titleFont: { size: 10, weight: 'bold' },
                        bodyFont: { size: 12, weight: '900' },
                        padding: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(156, 163, 175, 0.05)' },
                        ticks: { color: '#9ca3af', font: { size: 10, weight: 'bold' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af', font: { size: 10, weight: 'bold' } }
                    }
                }
            }
        });


    </script>

    <?php
    require_once __DIR__ . '/layout_footer.php';
    ?>