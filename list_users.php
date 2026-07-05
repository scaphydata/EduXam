<?php
require_once __DIR__ . '/php/database.php';
try {
    $stmt = $pdo->query("SELECT * FROM users");
    while ($row = $stmt->fetch()) {
        echo "ID: " . $row['id'] . " | Username: " . $row['username'] . " | Email: " . $row['email'] . " | Role: " . $row['role'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
