<?php
// web/includes/db.php

try {
    if (defined('DB_DRIVER') && DB_DRIVER === 'mysql') {
        // Connect to MySQL
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
    } else {
        // Default to SQLite
        $dbPath = __DIR__ . '/../database.sqlite';
        $pdo = new PDO("sqlite:" . $dbPath);
    }

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Disable emulation of prepared statements for MySQL (security)
    if (defined('DB_DRIVER') && DB_DRIVER === 'mysql') {
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

} catch (PDOException $e) {
    // In production, log this instead of showing
    die("Database Connection Error: " . $e->getMessage());
}
