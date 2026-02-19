<?php
// admin_reset.php
// UPLOAD THIS TO YOUR public/ DIRECTORY, RUN IT ONCE, THEN DELETE IT IMMEDIATELY.

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';

$newPass = 'admin123'; // The password you want to set
$hash = password_hash($newPass, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE username = 'admin'");
    $stmt->execute([$hash]);

    if ($stmt->rowCount() > 0) {
        echo "Success: Password has been reset to 'admin123'.<br>";
        echo "<b>IMPORTANT: DELETE THIS FILE FROM YOUR SERVER NOW.</b>";
    } else {
        echo "No changes made. Either your username isn't 'admin' or something else went wrong.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
