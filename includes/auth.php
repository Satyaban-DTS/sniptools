<?php
// web/includes/auth.php
if (session_status() === PHP_SESSION_NONE) {
    // Session Hardening
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);

    // Improved SSL detection for proxies
    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $isSecure = true;
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        $isSecure = true;

    if ($isSecure) {
        ini_set('session.cookie_secure', 1);
    }
    session_start();
}
require_once __DIR__ . '/db.php';

function checkAdmin()
{
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: " . url('admin/login'));
        exit;
    }
}

function generate_csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token)
{
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

/**
 * Handle Login Rate Limiting
 */
function checkLoginRateLimit($ip)
{
    global $pdo;
    $maxAttempts = 5;
    $lockoutTime = 900; // 15 minutes

    $stmt = $pdo->prepare("SELECT * FROM login_attempts WHERE ip_address = ?");
    $stmt->execute([$ip]);
    $data = $stmt->fetch();

    if ($data) {
        $lastAttempt = strtotime($data['last_attempt']);
        if ($data['attempts'] >= $maxAttempts && (time() - $lastAttempt) < $lockoutTime) {
            return false; // Locked out
        }
        // If expired, reset can happen during successful login or failed login update
        if ((time() - $lastAttempt) >= $lockoutTime) {
            $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = 0 WHERE ip_address = ?");
            $stmt->execute([$ip]);
        }
    }
    return true;
}

function recordLoginAttempt($ip, $success)
{
    global $pdo;
    if ($success) {
        $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
        $stmt->execute([$ip]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO login_attempts (ip_address, attempts) VALUES (?, 1) ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = CURRENT_TIMESTAMP");
        $stmt->execute([$ip]);

        // Artificial delay for failed attempts (Slow down brute force)
        usleep(rand(500000, 1500000));
    }
}

function loginAdmin($username, $password)
{
    global $pdo;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

    if (!checkLoginRateLimit($ip)) {
        return ['success' => false, 'error' => 'Too many failed attempts. Please try again in 15 minutes.'];
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Regenerate Session ID for security
        session_regenerate_id(true);

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $user['username'];

        recordLoginAttempt($ip, true);
        return ['success' => true];
    }

    recordLoginAttempt($ip, false);
    return ['success' => false, 'error' => 'Invalid credentials'];
}

function logoutAdmin()
{
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header("Location: " . url('admin/login'));
    exit;
}
