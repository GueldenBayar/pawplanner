<?php
require 'app/core/Database.php';
$db = Database::connect();
echo "Dogs: " . $db->query('SELECT COUNT(*) FROM dogs')->fetchColumn() . "\n";
echo "Users: " . $db->query('SELECT COUNT(*) FROM users')->fetchColumn() . "\n";
