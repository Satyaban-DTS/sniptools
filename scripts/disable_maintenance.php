<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db.php';
$pdo->exec("UPDATE settings SET value = '0' WHERE `key` = 'maintenance_mode'");
echo "Maintenance mode disabled.\n";
