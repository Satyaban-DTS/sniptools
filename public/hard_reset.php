<?php
// hard_reset.php
// UPLOAD TO public/ AND RUN. DELETE IMMEDIATELY.

require_once __DIR__ . '/../includes/auth.php';

echo "<h2>SnipTools Hard Security Reset</h2>";

try {
    // 1. Clear Rate limits for ALL IPs (Nuclear option)
    $pdo->exec("DELETE FROM login_attempts");
    echo "Done: All login lockouts cleared.<br>";

    // 2. Clear sessions (We clear our current session to start fresh)
    $_SESSION = [];
    session_destroy();
    echo "Done: Your local session cleared.<br>";

    // 3. Set standard user
    $user = 'admin';
    $pass = 'admin123';
    $hash = password_hash($pass, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("UPDATE users SET username = ?, password_hash = ? WHERE id = (SELECT id FROM (SELECT MIN(id) as id FROM users) as x)");
    $stmt->execute([$user, $hash]);

    if ($stmt->rowCount() > 0) {
        echo "Done: Primary admin user set to <b>$user</b> / <b>$pass</b>.<br>";
    } else {
        // Fallback: Just insert if empty
        $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        if ($count == 0) {
            $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)")->execute([$user, $hash]);
            echo "Done: New admin user created.<br>";
        } else {
            echo "Note: No changes to user table. User 'admin' might already have this password.<br>";
        }
    }

    echo "<h3>IMPORTANT: DELETE THIS FILE NOW.</h3>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
