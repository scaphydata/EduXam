<?php
require_once __DIR__ . '/php/database.php';
try {
    $stmt = $pdo->query("DESCRIBE users");
    while ($row = $stmt->fetch()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
