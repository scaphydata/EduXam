<?php
require_once('php/database.php');
require_once('php/functions.php');
start_secure_session();
check_prof_logged_in();

// Get formation ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$formation = null;
if ($id > 0) {
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT * FROM formations WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $formation = $stmt->fetch();
    } catch (PDOException $e) {
        // Handle error
    }
}
require_once('templates/headerprofs.php') ?>

<section>
    <div class="menu3">
        <div>
            <a href="cours.php?id=<?= $id ?>" >Cours</a>
        </div>
        <div>
            <a href="video.php?id=<?= $id ?>" >Video</a>
        </div>
        <div>
            <a href="exercices.php?id=<?= $id ?>" >Exercices</a>
        </div>
    </div>
    <div class="formation1" style="max-width: 80%; margin: 40px auto; padding: 20px; border: 2px solid darkcyan; border-radius: 15px;">

        <?php if ($formation): ?>
            <h3><?= h($formation['name']) ?></h3>

            <img src="<?= h($formation['image']) ?>" alt="<?= h($formation['name']) ?>" style="max-width: 250px; height: auto; margin: 20px auto; display: block;" />
            <p style="text-align: justify; line-height: 1.6; font-size: 1.1em; color: #333;">
                <?= nl2br(h($formation['description'])) ?>
            </p>
            <div class="readmore1" style="margin-top: 30px;">
                <a href="index.php">Retour aux formations</a>
            </div>
        <?php else: ?>
            <h3>Formation non trouvée</h3>
            <p>Désolé, nous n'avons pas pu trouver la formation demandée.</p>
            <div class="readmore1">
                <a href="index.php">Retour à l'accueil</a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php require_once('templates/footerprofs.php') ?>

