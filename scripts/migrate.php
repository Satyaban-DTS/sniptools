<?php
// web/scripts/migrate.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config/tools.php'; // Load existing tools data

echo "Starting Database Migration for MySQL...\n";

try {
    // 1. Create Tables (MySQL Syntax)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id VARCHAR(50) PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            icon VARCHAR(50),
            sort_order INT DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS tools (
            id INT AUTO_INCREMENT PRIMARY KEY,
            slug VARCHAR(255) UNIQUE NOT NULL,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            category_id VARCHAR(50),
            icon VARCHAR(50),
            meta_keywords TEXT,
            view_count INT DEFAULT 0,
            is_active TINYINT DEFAULT 1,
            is_featured TINYINT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS settings (
            `key` VARCHAR(100) PRIMARY KEY,
            value TEXT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS visits (
            id INT AUTO_INCREMENT PRIMARY KEY,
            page VARCHAR(255),
            ip_hash VARCHAR(64),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            role VARCHAR(20) DEFAULT 'admin'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS feedback (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            message TEXT NOT NULL,
            type VARCHAR(20) DEFAULT 'feedback',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            status VARCHAR(20) DEFAULT 'new'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    echo "Tables created successfully.\n";

    // 2. Seed Categories
    $categoriesList = [
        'text' => 'Text Tools',
        'developer' => 'Developer Tools',
        'image' => 'Image Tools',
        'converters' => 'Converters',
        'tailwind' => 'Tailwind Tools'
    ];

    $stmtCat = $pdo->prepare("INSERT IGNORE INTO categories (id, name, sort_order) VALUES (?, ?, ?)");
    $i = 0;
    foreach ($categoriesList as $id => $name) {
        $stmtCat->execute([$id, $name, ++$i]);
    }
    echo "Categories seeded.\n";

    // 3. Seed Tools (Using configurations from config/tools.php)
    $stmtTool = $pdo->prepare("INSERT INTO tools (slug, name, description, category_id, icon, meta_keywords, is_active) 
                               VALUES (?, ?, ?, ?, ?, ?, ?) 
                               ON DUPLICATE KEY UPDATE 
                               name = VALUES(name), 
                               description = VALUES(description), 
                               category_id = VALUES(category_id), 
                               icon = VALUES(icon),
                               meta_keywords = VALUES(meta_keywords)");
    foreach ($tools as $slug => $data) {
        $stmtTool->execute([
            $slug,
            $data['name'],
            $data['desc'],
            $data['category'] ?? 'uncategorized',
            $data['icon'],
            $data['keywords'] ?? null,
            1 // is_active
        ]);
    }
    echo "Tools synced/seeded from config.\n";

    // 4. Default Settings
    $stmtSet = $pdo->prepare("INSERT IGNORE INTO settings (`key`, value) VALUES (?, ?)");
    $defaults = [
        'site_name' => 'SnipTools',
        'maintenance_mode' => '0',
        'ads_enabled' => '1',
        'ad_code_header' => '',
        'ad_code_footer' => '',
        'ad_code_sidebar' => ''
    ];
    foreach ($defaults as $k => $v) {
        $stmtSet->execute([$k, $v]);
    }
    echo "Default settings synced.\n";

    // 5. Admin User (admin / admin123)
    $pass = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->prepare("INSERT IGNORE INTO users (username, password_hash) VALUES (?, ?)")
        ->execute(['admin', $pass]);
    echo "Admin user ready (admin / admin123).\n";

} catch (Exception $e) {
    die("Migration Failed: " . $e->getMessage() . "\n");
}

echo "Migration Complete! System is now optimized for MySQL.\n";
