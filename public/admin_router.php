<?php
// web/public/admin_router.php

// Extract sub-route after 'admin/'
$subRoute = str_replace('admin', '', $route);
$subRoute = ltrim($subRoute, '/');

// 1. Initial Redirect
if ($subRoute === '' || $subRoute === '/') {
    header("Location: " . url('admin/dashboard'));
    exit;
}

// 2. Public Login Route
if ($subRoute === 'login') {
    include __DIR__ . '/../views/admin/login.php';
    exit;
}

// 3. Security Requirements for all other Admin Routes
require_once __DIR__ . '/../includes/auth.php';
checkAdmin();

// CSRF Protection for all POST requests in admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    // Login page POST is handled inside login.php, but other routes here
    if (!verify_csrf_token($token)) {
        die("CSRF Token Validation Failed. Potential security threat blocked.");
    }
}

// 4. Auth-Protected Routes
if ($subRoute === 'logout') {
    logoutAdmin();
    exit;
}

if ($subRoute === 'feedback') {
    include __DIR__ . '/../views/admin/feedback.php';
    exit;
}

if ($subRoute === 'dashboard') {
    include __DIR__ . '/../views/admin/dashboard.php';
    exit;
}

if ($subRoute === 'profile') {
    include __DIR__ . '/../views/admin/profile.php';
    exit;
}

if ($subRoute === 'activity') {
    include __DIR__ . '/../views/admin/activity_log.php';
    exit;
}

if ($subRoute === 'categories') {
    include __DIR__ . '/../views/admin/categories.php';
    exit;
}

if ($subRoute === 'tools') {
    include __DIR__ . '/../views/admin/tools.php';
    exit;
}

if ($subRoute === 'settings') {
    include __DIR__ . '/../views/admin/settings.php';
    exit;
}

if ($subRoute === 'password-update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_SESSION['admin_user'] ?? 'admin';
    $currentPass = $_POST['current_password'] ?? '';
    $newPass = $_POST['new_password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';

    // Fetch user hash
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $uData = $stmt->fetch();

    if (!$uData || !password_verify($currentPass, $uData['password_hash'])) {
        set_flash_message("Incorrect current password.", "error");
        header("Location: " . url('admin/profile'));
        exit;
    }

    if ($newPass !== $confirmPass) {
        set_flash_message("New passwords do not match.", "error");
        header("Location: " . url('admin/profile'));
        exit;
    }

    if (strlen($newPass) < 6) {
        set_flash_message("Password must be at least 6 characters.", "error");
        header("Location: " . url('admin/profile'));
        exit;
    }

    $newHash = password_hash($newPass, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE username = ?");
    $stmt->execute([$newHash, $user]);

    set_flash_message("Password updated successfully.");
    header("Location: " . url('admin/profile'));
    exit;
}

// Fallback
echo "404 Admin Page Not Found";
