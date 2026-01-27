<?php
require_once __DIR__ . '/../../includes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (loginAdmin($username, $password)) {
        header("Location: " . url('admin/dashboard'));
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login -
        <?php echo APP_NAME; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-900 text-white flex items-center justify-center h-screen">

    <div class="w-full max-w-md p-8 bg-gray-800 rounded-3xl shadow-2xl border border-gray-700">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-white mb-2">Admin Panel</h1>
            <p class="text-gray-400 text-sm">Sign in to manage SnipTools</p>
        </div>

        <?php if ($error): ?>
            <div
                class="bg-red-500/10 border border-red-500/50 text-red-500 p-4 rounded-xl mb-6 text-sm font-bold text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Username</label>
                    <input type="text" name="username"
                        class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition-all">
                </div>
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-purple-600/20 mt-4">
                    Login
                </button>
            </div>
        </form>

        <div class="text-center mt-8">
            <a href="<?php echo url(); ?>" class="text-gray-500 hover:text-white text-sm transition-colors">← Back to
                Site</a>
        </div>
    </div>

</body>

</html>