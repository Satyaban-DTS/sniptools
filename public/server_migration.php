<?php
// public/server_migration.php
// Quick Migration Script to set up DB on Hostinger
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';

$secretKey = $_GET['key'] ?? '';
// Simple security check (change 'mysecret' to something random)
if ($secretKey !== 'mysecret') {
    die("Access Denied.");
}

echo "<h1>Starting Migration...</h1>";

try {
    // 1. Read the Backup File
    $backupFile = __DIR__ . '/../full_backup.sql';
    if (!file_exists($backupFile)) {
        die("Backup file not found!");
    }

    $sql = file_get_contents($backupFile);

    // 2. Execute SQL
    // Split by semicolons to execute statement mainly, but be careful with data containing semicolons.
    // PDO can usually handle multiple statements if configured, or we assume the backup is well-formed.
    // php_backup.php generates distinct lines.

    $pdo->exec($sql);

    echo "<h2>Migration Complete!</h2>";
    echo "<p>Database tables and data have been successfully imported.</p>";
    echo "<p><strong>IMPORTANT: Delete this file and full_backup.sql from the server immediately!</strong></p>";

} catch (PDOException $e) {
    die("Migration Error: " . $e->getMessage());
}
