<?php if ($totalLogs > $limit): ?>
    <div
        class="p-8 bg-gray-50/50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
            Page
            <?php echo $page; ?> of
            <?php echo ceil($totalLogs / $limit); ?>
        </div>
        <div class="flex items-center space-x-2">
            <?php
            $range = 2;
            $totalPages = ceil($totalLogs / $limit);

            $start = max(1, $page - $range);
            $end = min($totalPages, $page + $range);

            if ($page > 1): ?>
                <a href="javascript:void(0)" onclick="changePage(<?php echo $page - 1; ?>)"
                    class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold bg-white dark:bg-gray-800 text-gray-400 border border-gray-100 dark:border-gray-700 hover:text-primary transition-all">
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="javascript:void(0)" onclick="changePage(<?php echo $i; ?>)"
                    class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold <?php echo $page == $i ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-110' : 'bg-white dark:bg-gray-800 text-gray-400 border border-gray-100 dark:border-gray-700 hover:text-primary'; ?> transition-all">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="javascript:void(0)" onclick="changePage(<?php echo $page + 1; ?>)"
                    class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold bg-white dark:bg-gray-800 text-gray-400 border border-gray-100 dark:border-gray-700 hover:text-primary transition-all">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>