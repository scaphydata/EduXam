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
            email VARCHAR(255)
        )");
        // Create profs table if it doesn't exist
        $pdo->exec("CREATE TABLE IF NOT EXISTS profs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(191) UNIQUE,
            password VARCHAR(255),
            email VARCHAR(255)
        )");

        // Create formations table if it doesn't exist
        $pdo->exec("CREATE TABLE IF NOT EXISTS formations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            image VARCHAR(255) DEFAULT 'images/eduxamLogo.png'
        )");

        // Add a default user if none exists
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        if ($stmt->fetchColumn() == 0) {
            $password = password_hash('admin123', PASSWORD_DEFAULT);
            $admin_user = 'admin';
            $admin_email = 'admin@eduxam.com';
            $admin_role = 'admin';
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)");
            $stmt->bindParam(':username', $admin_user, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $admin_email, PDO::PARAM_STR);
            $stmt->bindParam(':role', $admin_role, PDO::PARAM_STR);
            $stmt->execute();
        }

        // Add sample formations if none exist
        $stmt = $pdo->query("SELECT COUNT(*) FROM formations");
        if ($stmt->fetchColumn() == 0) {
            $samples = [
                ['Formation 1', 'Description complète de la Formation 1. C\'est une formation dynamique !', 'images/eduxamLogo.png'],
                ['Formation 2', 'Description complète de la Formation 2. Apprenez tout sur ce sujet.', 'images/eduxamLogo.png'],
                ['Formation 3', 'Description complète de la Formation 3. Devenez un expert.', 'images/eduxamLogo.png'],
                ['Formation 4', 'Description complète de la Formation 4. Un contenu riche et varié.', 'images/eduxamLogo.png'],
                ['Formation 5', 'Description complète de la Formation 5. Pratique et théorie.', 'images/eduxamLogo.png'],
                ['Formation 6', 'Description complète de la Formation 6. La dernière de notre liste.', 'images/eduxamLogo.png'],
            ];
            
            $stmt = $pdo->prepare("INSERT INTO formations (name, description, image) VALUES (:name, :description, :image)");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            
            foreach ($samples as $sample) {
                $name = $sample[0];
                $description = $sample[1];
                $image = $sample[2];
                $stmt->execute();
            }
        }

        return $pdo;

    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
}

// Global $pdo for backward compatibility
$pdo = getDatabaseConnection();
?>
