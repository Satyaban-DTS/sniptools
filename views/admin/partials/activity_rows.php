<?php if (empty($logs)): ?>
    <tr>
        <td colspan="5" class="p-20 text-center">
            <i class="fas fa-search-minus text-4xl text-gray-100 mb-4 block"></i>
            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">No matching records
                found</span>
        </td>
    </tr>
<?php endif; ?>

<?php foreach ($logs as $log): ?>
    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/10 transition-colors group">
        <td class="p-4">
            <div class="text-xs font-black text-gray-900 dark:text-white mb-1">
                <?php echo date('M j, Y', strtotime($log['created_at'])); ?>
            </div>
            <div class="text-[10px] text-gray-400 font-bold">
                <?php echo date('H:i:s', strtotime($log['created_at'])); ?>
            </div>
        </td>
        <td class="p-4">
            <div class="text-[10px] text-primary font-black font-mono mb-1">
                <?php echo $log['ip_address']; ?>
            </div>
            <div class="text-[9px] text-gray-400 font-medium break-all opacity-40 uppercase">SID:
                <?php echo $log['session_id']; ?>
            </div>
        </td>
        <td class="p-4">
            <div class="text-xs font-bold text-gray-700 dark:text-gray-300">
                <?php echo $log['country']; ?>
            </div>
            <div class="text-[10px] text-gray-400 font-medium">
                <?php echo $log['city']; ?>
            </div>
        </td>
        <td class="p-4">
            <div class="flex flex-col gap-1.5">
                <div class="flex items-center space-x-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">
                        <?php echo $log['os']; ?>
                    </span>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest">
                        <?php echo $log['browser']; ?>
                    </span>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                    <span class="text-[9px] font-black text-purple-500 uppercase tracking-widest">
                        <?php echo $log['device']; ?>
                    </span>
                </div>
            </div>
        </td>
        <td class="p-4">
            <div class="max-w-[400px]">
                <div class="text-xs font-bold text-primary break-all mb-2 leading-relaxed">
                    <?php echo $log['page_url']; ?>
                </div>
                <div
                    class="text-[9px] text-gray-400 font-mono break-all opacity-40 leading-relaxed group-hover:opacity-80 transition-opacity">
                    <?php echo $log['user_agent']; ?>
                </div>
            </div>
        </td>
    </tr>
<?php endforeach; ?>