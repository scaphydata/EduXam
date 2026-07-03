<?php
// Database configuration
// Change these settings to match your MySQL/MariaDB environment
define('DB_HOST', 'localhost');
define('DB_NAME', 'eduxam');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Returns a PDO connection to the MySQL database.
 * It also handles the creation of the database and the users table if they don't exist.
 */
function getDatabaseConnection() {
    try {
        // Initial connection to MySQL without selecting a database
        $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Create database if it doesn't exist
        $dbname = DB_NAME;
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$dbname` ");

        // Create users table if it doesn't exist
        // Note: Using VARCHAR for strings to ensure compatibility with MySQL indexes
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(191) UNIQUE,
            password VARCHAR(255),
            email VARCHAR(255),
            role VARCHAR(50)
        )");

        // Add a default user if none exists
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        if ($stmt->fetchColumn() == 0) {
            $password = password_hash('admin123', PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)")
                ->execute(['admin', $password, 'admin@eduxam.com', 'admin']);
        }

        return $pdo;

    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
}

// Global $pdo for backward compatibility
$pdo = getDatabaseConnection();
?>
