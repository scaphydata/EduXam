<?php
// Simple database connection using PDO and SQLite for demonstration
// In a real scenario, this would connect to MySQL/MariaDB

$db_file = __DIR__ . '/../eduxam.db';

try {
    $pdo = new PDO("sqlite:$db_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Create users table if it doesn't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT,
        email TEXT,
        role TEXT
    )");

    // Add a default user if none exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO users (username, password, email, role) VALUES ('admin', '$password', 'admin@eduxam.com', 'admin')");
    }

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
