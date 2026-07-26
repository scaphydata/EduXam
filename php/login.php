<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/database.php';

start_secure_session();

if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['role'])) {
        switch ($_SESSION['role']) {
            case 'prof':
                header("Location: ../profs.php");
                break;
            case 'parents':
                header("Location: ../parents.php");
                break;
            case 'eleve':
                header("Location: ../eleve.php");
                break;
            default:
                header("Location: informations.php");
        }
    } else {
        header("Location: ../eleve.php");
    }
    exit;
}

$error = "";
$username = "";
$role = "eleve";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : 'eleve';
    $csrfToken = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    if (!verify_csrf_token($csrfToken)) {
        $error = "Requête invalide.";
    } elseif (!empty($username) && !empty($password)) {
        $pdo = getDatabaseConnection();

        if ($pdo) {
            $table = "users";
            $redirect = "../eleve.php";
            $session_role = "eleve";

            if ($role === 'prof') {
                $table = "profs";
                $redirect = "../profs.php";
                $session_role = "prof";
            } elseif ($role === 'parents') {
                $table = "parents";
                $redirect = "../parents.php";
                $session_role = "parents";
            }

            $stmt = $pdo->prepare("SELECT id, username, password FROM $table WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $session_role;

                // Régénérer le token après connexion réussie
                regenerate_csrf_token();

                header("Location: $redirect");
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

        <form action="login.php" method="POST" class="login-form">
            <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">

            <div class="form-group">
                <label for="role">Vous êtes :</label>
                <select id="role" name="role" required>
                    <option value="eleve" <?= $role === 'eleve' ? 'selected' : '' ?>>Élève</option>
                    <option value="prof" <?= $role === 'prof' ? 'selected' : '' ?>>Professeur</option>
                    <option value="parents" <?= $role === 'parents' ? 'selected' : '' ?>>Parent</option>
                </select>
            </div>

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
            <p>Pas encore de compte ? 
                <a href="inscription.php">Élève</a> | 
                <a href="inscriptionprofs.php">Prof</a> | 
                <a href="inscriptionparents.php">Parent</a>
            </p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../templates/_footer.php'; ?>
