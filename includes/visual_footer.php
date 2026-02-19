<?php
// includes/visual_footer.php
?>
<footer
    class="mt-auto border-t border-gray-100 dark:border-white/[0.03] py-6 bg-white/50 dark:bg-gray-800/30 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">

        <!-- Left: Brand & Copy -->
        <div class="flex items-center space-x-4">
            <span
                class="text-sm font-black tracking-tighter text-secondary dark:text-white opacity-80"><?php echo APP_NAME; ?></span>
            <span class="hidden md:inline text-[10px] font-bold text-gray-400 opacity-50">&copy;
                <?php echo date('Y'); ?> &nbsp;All rights reserved.</span>
        </div>

        <!-- Center: Links -->
        <div class="flex items-center space-x-6">
            <a href="<?php echo url('contact'); ?>"
                class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-primary transition-colors">Contact</a>
            <a href="<?php echo url('privacy'); ?>"
                class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-primary transition-colors">Privacy</a>
            <a href="<?php echo url('terms'); ?>"
                class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-primary transition-colors">Terms</a>
            <a href="<?php echo url('support'); ?>"
                class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-primary transition-colors">Support</a>
        </div>

        <!-- Right: Credits -->
        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest text-gray-400 opacity-75">
            <span>Made with ❤️ By</span>
            <a href="https://dastechsolution.in" target="_blank" class="ml-1.5 hover:text-primary transition-colors">Das
                Tech Solution</a>
        </div>
    </div>
</footer>
<?php include_once __DIR__ . '/feedback-widget.php'; ?>