<?php if (empty($feedbacks)): ?>
    <tr>
        <td colspan="4" class="p-20 text-center">
            <div
                class="w-16 h-16 bg-gray-50 dark:bg-gray-900/50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-300">
                <i class="fas fa-inbox text-3xl"></i>
            </div>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No feedback received
                yet</p>
        </td>
    </tr>
<?php endif; ?>

<?php foreach ($feedbacks as $f): ?>
    <tr class="hover:bg-gray-50/30 dark:hover:bg-gray-700/20 transition-colors group">
        <td class="p-8 align-top">
            <div class="flex items-center space-x-4">
                <div
                    class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-black uppercase text-xs">
                    <?php echo substr($f['name'], 0, 1); ?>
                </div>
                <div>
                    <div class="font-black text-gray-900 dark:text-white text-sm">
                        <?php echo htmlspecialchars($f['name']); ?>
                    </div>
                    <div class="text-[10px] text-gray-400 font-bold mt-1">
                        <?php echo htmlspecialchars($f['email']); ?>
                    </div>
                </div>
            </div>
            <!-- Type Badge -->
            <div class="mt-3">
                <?php if (($f['type'] ?? 'feedback') === 'suggestion'): ?>
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[8px] font-black uppercase tracking-widest bg-blue-500/10 text-blue-500 border border-blue-500/20">
                        <i class="fas fa-lightbulb mr-1"></i> Suggestion
                    </span>
                <?php else: ?>
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[8px] font-black uppercase tracking-widest bg-purple-500/10 text-purple-500 border border-purple-500/20">
                        <i class="fas fa-comment shadow-sm mr-1"></i> Feedback
                    </span>
                <?php endif; ?>
            </div>
            <div class="text-[9px] text-gray-400 font-bold mt-4 uppercase tracking-tighter opacity-60">
                <i class="fas fa-clock mr-1"></i>
                <?php echo date('M j, Y • H:i', strtotime($f['created_at'])); ?>
            </div>
        </td>
        <td class="p-8 align-top">
            <div class="bg-gray-50/50 dark:bg-gray-900/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed max-w-xl italic">
                    "
                    <?php echo nl2br(htmlspecialchars($f['message'])); ?>"
                </p>
            </div>
        </td>
        <td class="p-8 align-top">
            <?php if ($f['status'] === 'new'): ?>
                <span
                    class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    Recent
                </span>
            <?php else: ?>
                <span
                    class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500">
                    Processed
                </span>
            <?php endif; ?>
        </td>
        <td class="p-8 align-top text-right">
            <div class="flex flex-col space-y-2 items-end">
                <?php if ($f['status'] === 'new'): ?>
                    <button type="button" onclick="triggerAction('<?php echo $f['id']; ?>', 'read')"
                        class="w-full flex items-center justify-center px-4 py-2 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all mb-2">
                        Archive
                    </button>
                <?php endif; ?>
                <button type="button"
                    onclick="triggerAction('<?php echo $f['id']; ?>', 'delete', 'Secure Purge: Continue?')"
                    class="w-full flex items-center justify-center px-4 py-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Purge
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; ?>