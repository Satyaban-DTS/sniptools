<?php
// web/views/admin/profile.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile -
        <?php echo APP_NAME; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen">

    <!-- Top Bar -->
    <header class="bg-gray-800 border-b border-gray-700 h-16 flex items-center justify-between px-8 sticky top-0 z-50">
        <div class="flex items-center space-x-4">
            <a href="<?php echo url('admin/dashboard'); ?>" class="flex items-center space-x-4 group">
                <div
                    class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center group-hover:bg-purple-500 transition-colors">
                    <i class="fas fa-arrow-left text-white"></i>
                </div>
                <span class="font-bold text-lg tracking-tight">Back to Dashboard</span>
            </a>
        </div>
        <div class="flex items-center space-x-6">
            <a href="<?php echo url('admin/logout'); ?>"
                class="text-sm font-bold text-red-400 hover:text-red-300 transition-colors">
                Logout
            </a>
        </div>
    </header>

    <div class="p-8 max-w-2xl mx-auto mt-12">

        <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 shadow-2xl">
            <div class="text-center mb-10">
                <div
                    class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-gray-800 shadow-lg">
                    <i class="fas fa-user-shield text-3xl text-purple-500"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Admin Profile</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your account security</p>
            </div>

            <?php if (isset($error)): ?>
                <div
                    class="bg-red-500/10 border border-red-500/50 text-red-500 px-4 py-3 rounded-xl mb-6 text-sm font-bold text-center">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div
                    class="bg-green-500/10 border border-green-500/50 text-green-500 px-4 py-3 rounded-xl mb-6 text-sm font-bold text-center">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo url('admin/password-update'); ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Current
                        Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-500"><i class="fas fa-lock"></i></span>
                        <input type="password" name="current_password" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 pl-10 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-600"
                            placeholder="Enter current password">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">New
                            Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500"><i class="fas fa-key"></i></span>
                            <input type="password" name="new_password" required minlength="6"
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 pl-10 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-600"
                                placeholder="Min 6 chars">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Confirm
                            New</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500"><i
                                    class="fas fa-check-circle"></i></span>
                            <input type="password" name="confirm_password" required minlength="6"
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 pl-10 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-600"
                                placeholder="Repeat password">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-purple-600/20 mt-4 transform hover:scale-[1.02]">
                    Update Password
                </button>
            </form>
        </div>

    </div>

</body>

</html>