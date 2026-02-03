<?php
require_once __DIR__ . '/../../includes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = loginAdmin($username, $password);
    if ($result['success']) {
        header("Location: " . url('admin/dashboard'));
        exit;
    } else {
        $error = $result['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secured Admin Access - <?php echo APP_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#c026d3',
                        secondary: '#1e152e',
                        accent: '#ec4899',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-[#f8f9fc] dark:bg-[#0f111a] flex items-center justify-center min-h-screen p-6 relative overflow-hidden transition-colors">

    <!-- Background Decor -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div
            class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] animate-pulse">
        </div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-accent/5 rounded-full blur-[100px] animate-pulse"
            style="animation-delay: 2s"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo Area -->
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-2xl shadow-2xl shadow-primary/20 mb-4 group hover:scale-110 transition-transform">
                <i class="fas fa-shield-alt text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-black tracking-tighter text-secondary dark:text-white uppercase">Admin<span
                    class="text-primary italic">Portal</span></h1>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-2 opacity-60">High Security
                Environment</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800/50 backdrop-blur-xl rounded-[2.5rem] p-10 shadow-2xl border border-gray-100 dark:border-white/[0.05] relative overflow-hidden">
            <!-- Glass Accent -->
            <div
                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary/30 to-transparent">
            </div>

            <?php if ($error): ?>
                <div
                    class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl mb-8 text-xs font-bold text-center flex items-center justify-center animate-shake">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label
                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Identity</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-5 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                            <i class="fas fa-user-circle text-lg"></i>
                        </div>
                        <input type="text" name="username" placeholder="Username" required
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl pl-14 pr-6 py-4 text-sm font-bold text-gray-900 dark:text-white transition-all outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Access
                        Key</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-5 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                            <i class="fas fa-key text-lg"></i>
                        </div>
                        <input type="password" name="password" placeholder="••••••••" required
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl pl-14 pr-6 py-4 text-sm font-bold text-gray-900 dark:text-white transition-all outline-none">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-5 bg-gradient-to-r from-primary to-accent hover:scale-[1.02] active:scale-95 text-white font-black text-xs uppercase tracking-widest rounded-2xl transition-all shadow-xl shadow-primary/20">
                        Authorize Access
                    </button>
                    <p
                        class="text-center text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-6 flex items-center justify-center opacity-40">
                        <i class="fas fa-lock mr-2"></i>
                        End-to-End Secure Session
                    </p>
                </div>
            </form>
        </div>

        <div class="text-center mt-10">
            <a href="<?php echo url(); ?>"
                class="text-xs font-black text-gray-400 hover:text-primary uppercase tracking-widest flex items-center justify-center transition-all">
                <i class="fas fa-arrow-left mr-2"></i>
                Return to Public Site
            </a>
        </div>
    </div>

    <style>
        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }

        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }
    </style>
</body>

</html>