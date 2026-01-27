<?php
// web/public/admin_router.php

// Extract sub-route after 'admin/'
// Route is 'admin' or 'admin/login' or 'admin/dashboard'
$subRoute = str_replace('admin', '', $route);
$subRoute = ltrim($subRoute, '/');

if ($subRoute === '' || $subRoute === '/') {
    header("Location: " . url('admin/dashboard'));
    exit;
}

if ($subRoute === 'login') {
    include __DIR__ . '/../views/admin/login.php';
    exit;
}

if ($subRoute === 'logout') {
    require_once __DIR__ . '/../includes/auth.php';
    logoutAdmin();
    exit;
}

// Protected Routes check
require_once __DIR__ . '/../includes/auth.php';
checkAdmin();

if ($subRoute === 'dashboard') {
    include __DIR__ . '/../views/admin/dashboard.php';
    exit;
}

if ($subRoute === 'profile') {
    include __DIR__ . '/../views/admin/profile.php';
    exit;
}

if ($subRoute === 'password-update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../includes/auth.php';
    // Assume user is admin (admin_user in session)
    $user = $_SESSION['admin_user'] ?? 'admin';

    $currentPass = $_POST['current_password'] ?? '';
    $newPass = $_POST['new_password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';

    // Logic to verify current and update to new
    // We'll put this logic directly here or in a helper, for simplicity let's handle here for now
    // Fetch user hash
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $uData = $stmt->fetch();

    if (!$uData || !password_verify($currentPass, $uData['password_hash'])) {
        $error = "Incorrect current password.";
        include __DIR__ . '/../views/admin/profile.php';
        exit;
    }

    if ($newPass !== $confirmPass) {
        $error = "New passwords do not match.";
        include __DIR__ . '/../views/admin/profile.php';
        exit;
    }

    if (strlen($newPass) < 6) {
        $error = "Password must be at least 6 characters.";
        include __DIR__ . '/../views/admin/profile.php';
        exit;
    }

    // Update
    $newHash = password_hash($newPass, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE username = ?");
    $stmt->execute([$newHash, $user]);

    $success = "Password updated successfully.";
    include __DIR__ . '/../views/admin/profile.php';
    exit;
}

// Fallback
echo "404 Admin Page Not Found";
