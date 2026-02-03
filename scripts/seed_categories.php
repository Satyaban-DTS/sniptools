<?php
// seed_categories.php - Create default categories if none exist
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db.php';

// Check if categories exist
$count = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

if ($count > 0) {
    echo "Categories already exist ($count found). Skipping seed.\n";
    exit(0);
}

// Default categories to seed
$defaultCategories = [
    ['name' => 'Text Tools', 'sort_order' => 1],
    ['name' => 'Developer Tools', 'sort_order' => 2],
    ['name' => 'Image Tools', 'sort_order' => 3],
    ['name' => 'Converters', 'sort_order' => 4],
    ['name' => 'Generators', 'sort_order' => 5],
    ['name' => 'Utilities', 'sort_order' => 6],
];

$stmt = $pdo->prepare("INSERT INTO categories (name, sort_order) VALUES (?, ?)");

foreach ($defaultCategories as $cat) {
    $stmt->execute([$cat['name'], $cat['sort_order']]);
    echo "✓ Created category: {$cat['name']}\n";
}

echo "\n✅ Successfully seeded " . count($defaultCategories) . " categories!\n";
