<?php
// web/scripts/migrate.php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config/tools.php'; // Load existing tools data

echo "Starting Database Migration...\n";

try {
    // 1. Create Tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id TEXT PRIMARY KEY,
            name TEXT NOT NULL,
            icon TEXT,
            sort_order INTEGER DEFAULT 0
        );

        CREATE TABLE IF NOT EXISTS tools (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            slug TEXT UNIQUE NOT NULL,
            name TEXT NOT NULL,
            description TEXT,
            category_id TEXT,
            icon TEXT,
            view_count INTEGER DEFAULT 0,
            is_active INTEGER DEFAULT 1,
            is_featured INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id)
        );

        CREATE TABLE IF NOT EXISTS settings (
            key TEXT PRIMARY KEY,
            value TEXT
        );

        CREATE TABLE IF NOT EXISTS visits (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            page TEXT,
            ip_hash TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            role TEXT DEFAULT 'admin'
        );
    ");
    echo "Tables created successfully.\n";

    // 2. Seed Categories
    // Explicitly defining categories here to avoid include dependency issues
    $categories = [
        'text' => 'Text Tools',
        'developer' => 'Developer Tools',
        'image' => 'Image Tools',
        'converters' => 'Converters',
        'tailwind' => 'Tailwind Tools'
    ];

    if (!empty($categories)) {
        $stmt = $pdo->prepare("INSERT OR IGNORE INTO categories (id, name, sort_order) VALUES (?, ?, ?)");
        $i = 0;
        foreach ($categories as $id => $name) {
            $stmt->execute([$id, $name, ++$i]);
        }
        echo "Categories seeded.\n";
    }

    // 3. Seed Tools
    if (!empty($tools)) {
        $stmt = $pdo->prepare("INSERT OR IGNORE INTO tools (slug, name, description, category_id, icon, is_featured, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($tools as $slug => $data) {
            $isActive = 1;
            // Map existing 'category' key to 'category_id'
            $catId = $data['category'] ?? 'uncategorized';
            $isFeatured = 1; // Default all to featured for now or logic based on index

            $stmt->execute([
                $slug,
                $data['name'],
                $data['desc'],
                $catId,
                $data['icon'],
                $isFeatured,
                $isActive
            ]);
        }
        echo "Tools seeded.\n";
    }

    // 4. Seed Settings
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO settings (key, value) VALUES (?, ?)");
    $defaults = [
        'site_name' => 'SnipTools',
        'maintenance_mode' => '0',
        'ads_enabled' => '1',
        'ad_code_header' => '',
        'ad_code_footer' => '',
        'ad_code_sidebar' => ''
    ];
    foreach ($defaults as $k => $v) {
        $stmt->execute([$k, $v]);
    }
    echo "Settings seeded.\n";

    // 5. Create Admin User
    // Default: admin / admin123
    $pass = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->prepare("INSERT OR IGNORE INTO users (username, password_hash) VALUES (?, ?)")
        ->execute(['admin', $pass]);
    echo "Admin user created (admin / admin123).\n";

} catch (Exception $e) {
    die("Migration Failed: " . $e->getMessage() . "\n");
}

echo "Migration Complete! Database ready at web/database.sqlite\n";
