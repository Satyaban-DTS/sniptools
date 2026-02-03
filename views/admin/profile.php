<?php
// web/views/admin/profile.php
$pageTitle = 'Admin Profile';
$subRoute = 'profile'; // Active state helper
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-2xl mx-auto py-10">
    <div
        class="bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 p-10 shadow-2xl relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl"></div>

        <div class="text-center mb-12">
            <div
                class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-primary/20 shadow-xl shadow-primary/10">
                <i class="fas fa-user-shield text-4xl text-primary"></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Admin <span
                    class="text-primary italic">Profile</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 opacity-60">Security Management
            </p>
        </div>

        <?php if (isset($error)): ?>
            <div
                class="bg-red-500/10 border border-red-500/20 text-red-500 px-6 py-4 rounded-2xl mb-8 text-xs font-bold text-center flex items-center justify-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div
                class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 px-6 py-4 rounded-2xl mb-8 text-xs font-bold text-center flex items-center justify-center">
                <i class="fas fa-check-circle mr-2"></i>
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo url('admin/password-update'); ?>" method="POST" class="space-y-8">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Current
                    Password Verification</label>
                <div class="relative group">
                    <span
                        class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"><i
                            class="fas fa-lock"></i></span>
                    <input type="password" name="current_password" required
                        class="w-full bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 pl-14 py-4 text-sm font-bold text-gray-900 dark:text-white transition-all outline-none"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">New
                        Access Key</label>
                    <div class="relative group">
                        <span
                            class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"><i
                                class="fas fa-key"></i></span>
                        <input type="password" name="new_password" required minlength="6"
                            class="w-full bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 pl-14 py-4 text-sm font-bold text-gray-900 dark:text-white transition-all outline-none"
                            placeholder="Min 6 chars">
                    </div>
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Confirm
                        New Key</label>
                    <div class="relative group">
                        <span
                            class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"><i
                                class="fas fa-check-double"></i></span>
                        <input type="password" name="confirm_password" required minlength="6"
                            class="w-full bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 pl-14 py-4 text-sm font-bold text-gray-900 dark:text-white transition-all outline-none"
                            placeholder="Repeat Key">
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-primary to-accent hover:scale-[1.02] active:scale-95 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-primary/20 uppercase tracking-widest text-xs">
                    Update Security Credentials
                </button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/layout_footer.php';
?>