<?php
// views/admin/activity_log.php
$pageTitle = "Activity Audit Trail";
$subRoute = 'activity';
// Parameters for Search, Sort, Pagination
$limit = 10;
$page = isset($_GET['p']) ? (int) $_GET['p'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['s']) ? trim($_GET['s']) : '';
$dateFrom = isset($_GET['date_from']) ? trim($_GET['date_from']) : '';
$dateTo = isset($_GET['date_to']) ? trim($_GET['date_to']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'ASC' : 'DESC';

// Allowed sort columns
$allowedSort = ['created_at', 'ip_address', 'country', 'os', 'browser'];
if (!in_array($sort, $allowedSort))
    $sort = 'created_at';

// Build Query
$where = "";
$params = [];
$conditions = [];

if ($search) {
    $conditions[] = "(ip_address LIKE ? OR country LIKE ? OR city LIKE ? OR page_url LIKE ? OR session_id LIKE ?)";
    $params = array_merge($params, array_fill(0, 5, "%$search%"));
}

if ($dateFrom) {
    $conditions[] = "DATE(created_at) >= ?";
    $params[] = $dateFrom;
}

if ($dateTo) {
    $conditions[] = "DATE(created_at) <= ?";
    $params[] = $dateTo;
}

if (!empty($conditions)) {
    $where = " WHERE " . implode(" AND ", $conditions);
}

// Fetch Logs with dynamic filtering
$totalQuery = "SELECT COUNT(*) FROM activity_log" . $where;
$stmtTotal = $pdo->prepare($totalQuery);
$stmtTotal->execute($params);
$totalLogs = $stmtTotal->fetchColumn();

$query = "SELECT * FROM activity_log" . $where . " ORDER BY $sort $order LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($query);
$stmt->execute(array_merge($params, [$limit, $offset]));
$logs = $stmt->fetchAll();

// Analytics Data for Charts
$osData = $pdo->query("SELECT os, COUNT(*) as count FROM activity_log GROUP BY os ORDER BY count DESC")->fetchAll();
$browserData = $pdo->query("SELECT browser, COUNT(*) as count FROM activity_log GROUP BY browser ORDER BY count DESC")->fetchAll();
$deviceData = $pdo->query("SELECT device, COUNT(*) as count FROM activity_log GROUP BY device")->fetchAll();
$countryData = $pdo->query("SELECT country, COUNT(*) as count FROM activity_log GROUP BY country ORDER BY count DESC LIMIT 5")->fetchAll();

// AJAX Search Handler
if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    ob_start();
    include __DIR__ . '/partials/activity_rows.php';
    $html = ob_get_clean();

    ob_start();
    include __DIR__ . '/partials/activity_pagination.php';
    $pagination = ob_get_clean();

    header('Content-Type: application/json');
    echo json_encode([
        'html' => $html,
        'pagination' => $pagination,
        'count' => count($logs),
        'total' => number_format($totalLogs)
    ]);
    exit;
}

require_once __DIR__ . '/layout_header.php';

// Helper for Sort Links
function sortLink($col, $currentSort, $currentOrder, $search, $dateFrom = '', $dateTo = '')
{
    $newOrder = ($currentSort === $col && $currentOrder === 'DESC') ? 'asc' : 'desc';
    $url = "?sort=$col&order=$newOrder";
    if ($search)
        $url .= "&s=" . urlencode($search);
    if ($dateFrom)
        $url .= "&date_from=" . urlencode($dateFrom);
    if ($dateTo)
        $url .= "&date_to=" . urlencode($dateTo);
    return $url;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Make date input calendar icon white in dark mode */
    .dark input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
    }
</style>

<div class="space-y-8 pb-20">
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Audit <span
                    class="text-primary italic">Analytics</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 opacity-60">Visualizing real-time
                traffic dimensions</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 px-6 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center space-x-4">
            <div class="flex flex-col text-right">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Database Pool</span>
                <span class="text-xl font-black text-primary"><?php echo number_format($totalLogs); ?> <span
                        class="text-[10px] text-gray-400 font-normal">events</span></span>
            </div>
        </div>
    </header>

    <!-- Analytics Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-xl flex flex-col">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">OS Split</h3>
            <div class="relative h-48 w-full">
                <canvas id="osChart"></canvas>
            </div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-xl flex flex-col">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Browser Split</h3>
            <div class="relative h-48 w-full">
                <canvas id="browserChart"></canvas>
            </div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-xl flex flex-col">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Device Types</h3>
            <div class="relative h-48 w-full">
                <canvas id="deviceChart"></canvas>
            </div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-xl flex flex-col">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Top Regions</h3>
            <div class="relative h-48 w-full">
                <canvas id="countryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Controls Row: Search & Date Filter -->
    <div
        class="bg-white/50 dark:bg-gray-800/50 p-4 rounded-3xl border border-gray-100 dark:border-gray-700 backdrop-blur-sm">
        <form id="activitySearchForm" method="GET" class="flex flex-col lg:flex-row items-center gap-3">
            <!-- Search Bar -->
            <div class="relative w-full lg:flex-1">
                <input type="text" id="activitySearchInput" name="s" value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Search IP, Country, URL or Session..."
                    class="w-full bg-white dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-2.5 px-10 text-sm font-bold focus:border-primary outline-none transition-all shadow-inner">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="hidden" name="p" id="pageInput" value="<?php echo $page; ?>">
                <input type="hidden" name="sort" value="<?php echo $sort; ?>">
                <input type="hidden" name="order" value="<?php echo $order; ?>">
            </div>

            <!-- Date From -->
            <input type="date" id="dateFrom" name="date_from" value="<?php echo htmlspecialchars($dateFrom); ?>"
                class="date-input bg-white dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-2.5 px-3 text-xs font-bold focus:border-primary outline-none transition-all shadow-inner dark:text-white w-full lg:w-auto">

            <span class="text-gray-400 font-bold text-sm hidden lg:inline">to</span>

            <!-- Date To -->
            <input type="date" id="dateTo" name="date_to" value="<?php echo htmlspecialchars($dateTo); ?>"
                class="date-input bg-white dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-2.5 px-3 text-xs font-bold focus:border-primary outline-none transition-all shadow-inner dark:text-white w-full lg:w-auto">

            <!-- Filter Button -->
            <button type="submit"
                class="w-full lg:w-auto px-5 py-2.5 bg-primary text-white rounded-2xl font-bold text-sm hover:scale-105 transition-transform shadow-lg shadow-primary/20 whitespace-nowrap">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>

            <!-- Clear Filters -->
            <?php if ($search || $dateFrom || $dateTo): ?>
                <a href="?sort=<?php echo $sort; ?>&order=<?php echo $order; ?>"
                    class="w-full lg:w-auto px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-2xl font-bold text-sm hover:scale-105 transition-transform text-center whitespace-nowrap">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </form>

        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-3 text-center">
            Showing <span id="activityCount"><?php echo count($logs); ?></span> of <span
                id="totalActivityCount"><?php echo number_format($totalLogs); ?></span> matches
        </div>
    </div>

    <!-- Table Container -->
    <div
        class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="p-4">
                            <a href="<?php echo sortLink('created_at', $sort, $order, $search, $dateFrom, $dateTo); ?>"
                                class="flex items-center space-x-2 group">
                                <span
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Timestamp</span>
                                <i
                                    class="fas fa-sort text-[8px] opacity-20 group-hover:opacity-100 transition-opacity <?php echo $sort === 'created_at' ? 'text-primary opacity-100' : ''; ?>"></i>
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="<?php echo sortLink('ip_address', $sort, $order, $search, $dateFrom, $dateTo); ?>"
                                class="flex items-center space-x-2 group">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Client
                                    Identity</span>
                                <i
                                    class="fas fa-sort text-[8px] opacity-20 group-hover:opacity-100 transition-opacity <?php echo $sort === 'ip_address' ? 'text-primary opacity-100' : ''; ?>"></i>
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="<?php echo sortLink('country', $sort, $order, $search, $dateFrom, $dateTo); ?>"
                                class="flex items-center space-x-2 group">
                                <span
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Demographics</span>
                                <i
                                    class="fas fa-sort text-[8px] opacity-20 group-hover:opacity-100 transition-opacity <?php echo $sort === 'country' ? 'text-primary opacity-100' : ''; ?>"></i>
                            </a>
                        </th>
                        <th class="p-4">
                            <span
                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Environment</span>
                        </th>
                        <th class="p-4">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Page &
                                Headers</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="activityTableBody" class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    <?php include __DIR__ . '/partials/activity_rows.php'; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="activityPagination">
            <?php include __DIR__ . '/partials/activity_pagination.php'; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = document.documentElement.classList.contains('dark');
        const labelColor = isDark ? '#9ca3af' : '#6b7280';
        const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: labelColor, font: { weight: 'bold', size: 9 } }
                },
                y: {
                    grid: { color: gridColor },
                    ticks: { color: labelColor, font: { weight: 'bold', size: 9 } }
                }
            }
        };

        // OS Chart
        new Chart(document.getElementById('osChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($osData, 'os')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($osData, 'count')); ?>,
                    backgroundColor: '#10b981',
                    borderRadius: 6
                }]
            },
            options: commonOptions
        });

        // Browser Chart
        new Chart(document.getElementById('browserChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($browserData, 'browser')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($browserData, 'count')); ?>,
                    backgroundColor: '#3b82f6',
                    borderRadius: 6
                }]
            },
            options: commonOptions
        });

        // Device Chart
        new Chart(document.getElementById('deviceChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($deviceData, 'device')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($deviceData, 'count')); ?>,
                    backgroundColor: ['#6366f1', '#a855f7', '#ec4899', '#f59e0b'],
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: labelColor, font: { weight: 'bold', size: 9 }, usePointStyle: true, boxWidth: 6 }
                    }
                }
            }
        });

        // Country Chart
        new Chart(document.getElementById('countryChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($countryData, 'country')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($countryData, 'count')); ?>,
                    backgroundColor: '#f43f5e',
                    borderRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                indexAxis: 'y'
            }
        });
    });

    // AJAX Search Implementation
    const activitySearchForm = document.getElementById('activitySearchForm');
    const activitySearchInput = document.getElementById('activitySearchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const activityTableBody = document.getElementById('activityTableBody');
    const activityPagination = document.getElementById('activityPagination');
    const activityCount = document.getElementById('activityCount');
    const totalActivityCount = document.getElementById('totalActivityCount');
    const pageInput = document.getElementById('pageInput');

    let debounceTimer;

    const performSearch = (page = 1) => {
        if (pageInput) pageInput.value = page;
        const formData = new FormData(activitySearchForm);
        const params = new URLSearchParams(formData);
        params.append('ajax', '1');

        // Update URL without reloading
        const newUrl = `${window.location.pathname}?${params.toString()}`.replace('&ajax=1', '');
        window.history.pushState({}, '', newUrl);

        fetch(`?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                if (activityTableBody) activityTableBody.innerHTML = data.html;
                if (activityPagination) activityPagination.innerHTML = data.pagination;
                if (activityCount) activityCount.textContent = data.count;
                if (totalActivityCount) totalActivityCount.textContent = data.total;
            })
            .catch(error => console.error('Error:', error));
    };

    window.changePage = (page) => {
        performSearch(page);
    };

    if (activitySearchInput) {
        activitySearchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => performSearch(1), 300);
        });
    }

    if (dateFrom) dateFrom.addEventListener('change', () => performSearch(1));
    if (dateTo) dateTo.addEventListener('change', () => performSearch(1));

    if (activitySearchForm) {
        activitySearchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            performSearch(1);
        });
    }
</script>

<?php
require_once __DIR__ . '/layout_footer.php';
?>