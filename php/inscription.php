<?php
session_start();
$base_url = "../";

if (isset($_SESSION['user_id'])) {
    header("Location: informations.php");
    exit;
}

include('database.php');

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            $error = "Les mots de passe ne correspondent pas.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Format d'email invalide.";
        } else {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetchColumn() > 0) {
                $error = "Ce nom d'utilisateur ou cet email est déjà utilisé.";
            } else {
                // Insert new user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
                try {
                    $stmt->execute([$username, $email, $hashed_password, 'user']);
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                } catch (PDOException $e) {
                    $error = "Une erreur est survenue lors de l'inscription.";
                }
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

include('../templates/_header.php');
?>

<section class="inscription-section">
    <div class="form-container">
        <h3>S'inscrire</h3>
        
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <p class="success-message"><?= htmlspecialchars($success) ?></p>
            <div class="form-actions">
                <a href="connexion.php" class="btn-submit" style="display: block; text-align: center; text-decoration: none;">Aller à la page de connexion</a>
            </div>
        <?php else: ?>
            <form action="inscription.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">S'inscrire</button>
                </div>
            </form>
            <div class="form-footer">
                <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.inscription-section {
    padding: 50px 0;
    display: flex;
    justify-content: center;
}

.form-container {
    background: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 450px;
    text-align: left;
}

.form-container h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: #22395c;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

.btn-submit:hover {
    background-color: #4f678d;
}

.error-message {
    color: #d9534f;
    background-color: #f2dede;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    text-align: center;
}

.success-message {
    color: #3c763d;
    background-color: #dff0d8;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    text-align: center;
}

.form-footer {
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
}

.form-footer a {
    color: #22395c;
    text-decoration: none;
    font-weight: bold;
}
</style>

<?php include('../templates/_footer.php'); ?>