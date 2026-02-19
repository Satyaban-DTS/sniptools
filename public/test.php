<?php
echo "<h1>PHP is working!</h1>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Server Protocol: " . ($_SERVER['SERVER_PROTOCOL'] ?? 'Unknown') . "</p>";
phpinfo();
