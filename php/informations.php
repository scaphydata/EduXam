<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/database.php';

start_secure_session();
check_logged_in();

$base_url = "../";
require_once __DIR__ . '/../templates/_header.php';

// Simuler des informations provenant de la base de données
$informations = [
    ['title' => 'Résultats de l\'examen Mathématiques', 'date' => '2026-06-15', 'status' => 'Publié'],
    ['title' => 'Nouveau support de cours : Histoire de l\'Art', 'date' => '2026-06-20', 'status' => 'Disponible'],
    ['title' => 'Planning des examens de rattrapage', 'date' => '2026-07-10', 'status' => 'À venir'],
];
?>

<section class="info-section">
    <div class="container">
        <h3>Informations complémentaires pour <?= h($_SESSION['username']) ?></h3>
        <p>Bienvenue dans votre espace privilégié. Voici les dernières informations de la base de données :</p>
        
        <table class="info-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($informations as $info): ?>
                    <tr>
                        <td><?= h($info['title']) ?></td>
                        <td><?= h($info['date']) ?></td>
                        <td><span class="status-tag"><?= h($info['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="actions">
            <a href="../index.php" class="btn-back">Retour à l'accueil</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../templates/_footer.php'; ?>
