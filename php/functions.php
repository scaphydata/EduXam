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
 * Échappe les données pour l'affichage HTML.
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
