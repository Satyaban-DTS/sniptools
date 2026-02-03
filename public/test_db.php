<?php
// public/test_db.php
// Simplest possible DB connection test
// Upload to public_html/sniptools/test_db.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

$dbHost = 'localhost';
$dbName = 'u116926025_sniptools';
$dbUser = 'u116926025_admin';
$dbPass = 'Tu$/XS1w0';

try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2 style='color:green'>✅ Connection Successful!</h2>";
    echo "<p>Connected to database: <strong>$dbName</strong></p>";
} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ Connection Failed</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<h3>Troubleshooting:</h3>";
    echo "<ul>";
    echo "<li>Check if Database Name ($dbName) is correct.</li>";
    echo "<li>Check if Username ($dbUser) is correct.</li>";
    echo "<li>Check if Password is correct.</li>";
    echo "<li>Ensure the user is assigned to the database in Hostinger control panel.</li>";
    echo "</ul>";
}
