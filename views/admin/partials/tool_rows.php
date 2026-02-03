<?php if (empty($tools)): ?>
    <tr>
        <td colspan="5" class="p-20 text-center">
            <i class="fas fa-search-minus text-4xl text-gray-100 mb-4 block"></i>
            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">No tools
                found</span>
        </td>
    </tr>
<?php endif; ?>

<?php foreach ($tools as $tool): ?>
    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/10 transition-colors">
        <td class="p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                    <i class="fas <?php echo htmlspecialchars($tool['icon'] ?? 'fa-tools'); ?> text-primary text-lg"></i>
                </div>
                <div class="text-sm font-black text-gray-900 dark:text-white">
                    <?php echo htmlspecialchars($tool['name']); ?>
                </div>
            </div>
        </td>
        <td class="p-4">
            <code class="text-xs font-mono text-primary bg-primary/10 px-2 py-1 rounded">
                                                                    <?php echo htmlspecialchars($tool['slug']); ?>
                                                                </code>
        </td>
        <td class="p-4">
            <span class="text-xs font-bold text-gray-600 dark:text-gray-400">
                <?php echo htmlspecialchars($tool['category_name'] ?? 'Uncategorized'); ?>
            </span>
        </td>
        <td class="p-4">
            <form method="POST" class="inline">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="action" value="toggle_tool">
                <input type="hidden" name="id" value="<?php echo $tool['id']; ?>">
                <input type="hidden" name="current_state" value="<?php echo $tool['is_active']; ?>">
                <button type="submit"
                    class="px-3 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all hover:scale-105 <?php echo $tool['is_active'] ? 'bg-emerald-100 dark:bg-emerald-900/20 text-emerald-600' : 'bg-gray-100 dark:bg-gray-700 text-gray-500'; ?>">
                    <?php echo $tool['is_active'] ? 'Active' : 'Inactive'; ?>
                </button>
            </form>
        </td>
        <td class="p-4">
            <div class="flex items-center space-x-2">
                <button onclick='openEditModal(<?php echo json_encode($tool); ?>)'
                    class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-500 hover:scale-110 transition-transform">
                    <i class="fas fa-edit text-xs"></i>
                </button>
                <button
                    onclick="confirmDelete(<?php echo $tool['id']; ?>, '<?php echo htmlspecialchars($tool['name']); ?>')"
                    class="w-8 h-8 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-500 hover:scale-110 transition-transform">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; ?>