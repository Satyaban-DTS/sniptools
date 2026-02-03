<?php
// web/scripts/seed_tools.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/tools.php';
require_once __DIR__ . '/../includes/db.php';

echo "Seeding Tools...\n";

foreach ($tools as $slug => $data) {
    echo "Processing $slug...\n";
    $stmt = $pdo->prepare("SELECT id FROM tools WHERE slug = ?");
    $stmt->execute([$slug]);

    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO tools (slug, name, description, category_id, icon, meta_keywords, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $slug,
            $data['name'],
            $data['desc'],
            $data['category'],
            $data['icon'],
            $data['keywords'] ?? null,  // Insert keywords
            0
        ]);
        echo "Inserted $slug\n";
    } else {
        // Update existing tool to sync changes (icon, desc, keywords, etc.)
        $stmt = $pdo->prepare("UPDATE tools SET name = ?, description = ?, category_id = ?, icon = ?, meta_keywords = ? WHERE slug = ?");
        $stmt->execute([
            $data['name'],
            $data['desc'],
            $data['category'],
            $data['icon'],
            $data['keywords'] ?? null, // Update keywords
            $slug
        ]);
        echo "Updated $slug\n";
    }
}
echo "Done!\n";
