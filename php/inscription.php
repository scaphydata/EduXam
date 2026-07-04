<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/database.php';

start_secure_session();

if (isset($_SESSION['user_id'])) {
    header("Location: informations.php");
    exit;
}

$error = "";
$success = "";
$username = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $csrfToken = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    if (!verify_csrf_token($csrfToken)) {
        $error = "Requête invalide.";
    } elseif (!empty($username) && !empty($password) && !empty($email)) {
        $pdo = getDatabaseConnection();
        
        if ($pdo) {
            // Vérifier si l'utilisateur existe déjà (nom d'utilisateur ou email)
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->fetch()) {
                $error = "Nom d'utilisateur ou email déjà utilisé.";
            } else {
                // Insérer l'utilisateur avec hashage sécurisé
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, 'user')");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                
                if ($stmt->execute()) {
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    $username = "";
                    $email = "";
                    // Régénérer le token après une action réussie
                    regenerate_csrf_token();
                } else {
                    $error = "Une erreur est survenue lors de l'inscription.";
                }
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
        <h3>Inscription</h3>

        <?php if ($error): ?>
            <p class="error-message"><?= h($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success-message"><?= h($success) ?></p>
        <?php endif; ?>

        <form action="inscription.php" method="POST" class="login-form">
            <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?= h($username) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= h($email) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">S'inscrire</button>
            </div>
        </form>

        <div class="form-footer">
            <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../templates/_footer.php'; ?>