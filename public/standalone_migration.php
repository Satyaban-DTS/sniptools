<?php
// public/standalone_migration.php
// STANDALONE MIGRATION SCRIPT - NO DEPENDENCIES
// 1. Upload this file to your 'public_html' folder.
// 2. Upload 'full_backup.sql' to the SAME folder.
// 3. Visit domain.com/standalone_migration.php?key=mysecret

error_reporting(E_ALL);
ini_set('display_errors', 1);

$secretKey = $_GET['key'] ?? '';
if ($secretKey !== 'mysecret') {
    die("Access Denied. Incorrect Key.");
}

echo "<h1>Starting Standalone Migration...</h1>";

// --- CONFIGURATION (Embedding Directly) ---
$dbHost = 'localhost';
$dbName = 'u116926025_sniptools';
$dbUser = 'u116926025_admin';
$dbPass = 'Tu$/XS1w0';

try {
    // Connect
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database Connected Successfully.<br>";

    // Look for backup file in CURRENT directory
    $backupFile = __DIR__ . '/full_backup.sql';

    if (!file_exists($backupFile)) {
        // Fallback: Check parent directory
        $backupFile = __DIR__ . '/../full_backup.sql';
        if (!file_exists($backupFile)) {
            die("❌ Error: 'full_backup.sql' not found in " . __DIR__ . " or parent directory.");
        }
    }
    echo "✅ Backup File Found at: $backupFile<br>";

    // Read and Run
    $sql = file_get_contents($backupFile);
    if (!$sql) {
        die("❌ Error: Backup file is empty or unreadable.");
    }

    // Disable foreign key checks to avoid ordering issues during import
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $pdo->exec($sql);

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "<h2>🎉 Migration Complete!</h2>";
    echo "<p>All tables and data have been imported.</p>";
    echo "<p style='color:red;'><strong>PLEASE DELETE THIS FILE AND full_backup.sql NOW.</strong></p>";

} catch (PDOException $e) {
    die("❌ <strong>Database Error:</strong> " . $e->getMessage());
} catch (Exception $e) {
    die("❌ <strong>Error:</strong> " . $e->getMessage());
}
