<?php
// diag.php
// UPLOAD TO public/ AND RUN. DELETE IMMEDIATELY.

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';

echo "<h2>SnipTools Diagnostic</h2>";

try {
    // 1. Check Users
    $users = $pdo->query("SELECT id, username, LENGTH(password_hash) as hash_len FROM users")->fetchAll();
    echo "<h3>Users found: " . count($users) . "</h3>";
    foreach ($users as $u) {
        echo "ID: {$u['id']} | Username: [{$u['username']}] | Hash Length: {$u['hash_len']}<br>";
    }

    // 2. Check Rate Limits
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $stmt = $pdo->prepare("SELECT * FROM login_attempts WHERE ip_address = ?");
    $stmt->execute([$ip]);
    $limit = $stmt->fetch();

    echo "<h3>Your Status ($ip):</h3>";
    if ($limit) {
        echo "Attempts: {$limit['attempts']}<br>";
        echo "Last Attempt: {$limit['last_attempt']}<br>";
        $lockoutTime = 900;
        $lastAttempt = strtotime($limit['last_attempt']);
        if ($limit['attempts'] >= 5 && (time() - $lastAttempt) < $lockoutTime) {
            echo "<b style='color:red'>LOCKED OUT!</b> Please wait 15 minutes or run a reset script to clear this.<br>";
        } else {
            echo "<b style='color:green'>Not Locked Out.</b>";
        }
    } else {
        echo "No rate limit record found for your IP.";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
