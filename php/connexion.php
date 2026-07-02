<?php
session_start();
$base_url = "../";

if (isset($_SESSION['user_id'])) {
    header("Location: informations.php");
    exit;
}

include('database.php');

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: informations.php");
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

include('../templates/_header.php');
?>

<section class="connexion-section">
    <div class="form-container">
        <h3>Connexion</h3>
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="connexion.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
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

<style>
.connexion-section {
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
    max-width: 400px;
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
