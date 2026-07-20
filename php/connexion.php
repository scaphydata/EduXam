<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/database.php';

start_secure_session();

if (isset($_SESSION['user_id'])) {
    header("Location: informations.php");
    exit;
}

$error = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $csrfToken = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    if (!verify_csrf_token($csrfToken)) {
        $error = "Requête invalide.";
    } elseif (!empty($username) && !empty($password)) {
        $pdo = getDatabaseConnection();

        if ($pdo) {
            $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Régénérer le token après connexion réussie
                regenerate_csrf_token();

                header("Location: ../eleve.php");
                exit;
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $error = "Erreur de connexion à la base de données.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

$csrf_token = get_csrf_token();
$base_url = "../";

require_once __DIR__ . '/../templates/_header.php';
?>

<section class="connexion-section">
    <div class="form-container">
        <h3>Connexion</h3>

        <?php if ($error): ?>
            <p class="error-message"><?= h($error) ?></p>
        <?php endif; ?>

        <form action="connexion.php" method="POST" class="login-form">
            <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?= h($username) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Se connecter</button>
            </div>
        </form>

        <div class="form-footer">
            <p>Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../templates/_footer.php'; ?>