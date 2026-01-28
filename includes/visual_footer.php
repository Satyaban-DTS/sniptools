<?php
// includes/visual_footer.php
?>
<footer class="mt-auto py-4 border-t border-gray-100 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-medium text-gray-400">
            <div class="flex items-center space-x-2">
                <span>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>.</span>
                <span class="bg-gray-50 dark:bg-gray-800 px-1.5 py-0.5 rounded text-[10px]">v1.2.0</span>
            </div>

            <div class="flex items-center space-x-6">
                <a href="<?php echo url('about'); ?>" class="hover:text-primary transition-colors">About</a>
                <a href="<?php echo url('privacy'); ?>" class="hover:text-primary transition-colors">Privacy</a>
                <a href="<?php echo url('terms'); ?>" class="hover:text-primary transition-colors">Terms</a>
            </div>

            <div class="flex items-center">
                Made with <i class="fas fa-heart text-red-500 mx-1 animate-pulse"></i> for Developers by &nbsp;<a href="https://dastechsolution.in">Das Tech Solution</a>
            </div>
        </div>
    </div>
</footer>
<?php include_once __DIR__ . '/feedback-widget.php'; ?>