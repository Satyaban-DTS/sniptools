<?php
// scripts/sync_tools.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config/tools.php';

echo "Syncing Tools from config/tools.php to MySQL database...\n";

try {
    // Ensure table exists (MySQL syntax)
    $pdo->exec("CREATE TABLE IF NOT EXISTS tools (
        id INT AUTO_INCREMENT PRIMARY KEY,
        slug VARCHAR(255) UNIQUE NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        category_id VARCHAR(50),
        icon VARCHAR(50),
        view_count INT DEFAULT 0,
        is_active TINYINT DEFAULT 1,
        is_featured TINYINT DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $stmt = $pdo->prepare("INSERT INTO tools (slug, name, description, category_id, icon) 
                           VALUES (:slug, :name, :desc, :cat, :icon) 
                           ON DUPLICATE KEY UPDATE 
                           name = VALUES(name), 
                           description = VALUES(description), 
                           category_id = VALUES(category_id), 
                           icon = VALUES(icon)");

    foreach ($tools as $slug => $data) {
        $stmt->execute([
            ':slug' => $slug,
            ':name' => $data['name'],
            ':desc' => $data['desc'],
            ':cat' => $data['category'] ?? 'uncategorized',
            ':icon' => $data['icon']
        ]);
        echo "Synced: $slug\n";
    }

    echo "\nSync Complete!\n";
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}
