<?php
/**
 * Fonctions utilitaires pour le projet Eduxam
 */

/**
 * Démarre la session de manière sécurisée si elle n'est pas déjà démarrée.
 */
function start_secure_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'httponly' => true,
            'secure' => !empty($_SERVER['HTTPS']),
            'samesite' => 'Lax'
        ]);
        session_start();
    }
}

/**
 * Génère un token CSRF s'il n'existe pas déjà.
 */
function get_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie si le token CSRF fourni est valide.
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Régénère le token CSRF (utile après une action sensible).
 */
function regenerate_csrf_token() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Protège une page : redirige vers la connexion si l'utilisateur n'est pas connecté.
 */
function check_logged_in() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: connexion.php");
        exit;
    }
}

/**
 * Protège une page professeur : redirige vers la connexion prof si non autorisé.
 */
function check_prof_logged_in() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'prof') {
        // Obtenir le chemin relatif vers la racine
        $redirect_path = "php/connexionprofs.php";
        if (file_exists("php/connexionprofs.php")) {
            header("Location: " . $redirect_path);
        } else {
            header("Location: connexionprofs.php");
        }
        exit;
    }
}

/**
 * Protège une page parents : redirige vers la connexion parents si non autorisé.
 */
function check_parents_logged_in() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'parents') {
        // Obtenir le chemin relatif vers la racine
        $redirect_path = "php/connexionparents.php";
        if (file_exists("php/connexionparents.php")) {
            header("Location: " . $redirect_path);
        } else {
            header("Location: connexionparents.php");
        }
        exit;
    }
}

/**
 * Échappe les données pour l'affichage HTML.
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Retourne le nombre d'étudiants inscrits (utilisateurs de la table 'users').
 */
function get_student_count() {
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}
