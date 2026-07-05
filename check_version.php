<?php
require_once __DIR__ . '/php/database.php';
echo $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
?>
