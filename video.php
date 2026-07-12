<?php
require_once('php/database.php');
require_once('php/functions.php');
start_secure_session();

// Check if it's a prof or a regular student
$is_prof = isset($_SESSION['role']) && $_SESSION['role'] === 'prof';
if ($is_prof) {
    check_prof_logged_in();
    require_once('templates/headerprofs.php');
} else {
    check_logged_in();
    require_once('templates/_header.php');
}

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
?>
<section>
    <div class="menu3">
        <div>
            <a href="cours.php?id=<?= $id ?>" >Cours</a>
        </div>
        <div>
            <a href="video.php?id=<?= $id ?>" style="background-color: darkcyan; color: white;">Video</a>
        </div>
        <div>
            <a href="exercices.php?id=<?= $id ?>" >Exercices</a>
        </div>
    </div>
    <div class="formation1" style="max-width: 80%; margin: 40px auto; padding: 20px; border: 2px solid darkcyan; border-radius: 15px;">

        <?php if ($formation): ?>
            <h3>Vidéo : <?= h($formation['name']) ?></h3>
            
            <div style="margin: 30px 0; text-align: center;">
                <video controls width="700" style="max-width: 100%; border-radius: 10px; border: 6px solid #ccc;">
                    <source src="<?= h($formation['video']) ?>" type="video/mp4" />
                    Votre navigateur ne supporte pas la lecture de vidéos HTML5. 
                    Voici un lien pour <a href="<?= h($formation['video']) ?>">télécharger la vidéo</a>.
                </video>
            </div>

            <div class="readmore1" style="margin-top: 30px;">
                <a href="<?= $is_prof ? 'profs.php?id=' . $id : 'Formation.php?id=' . $id ?>">Retour à la formation</a>
            </div>
        <?php else: ?>
            <h3>Formation non trouvée</h3>
            <p>Désolé, nous n'avons pas pu trouver la formation demandée.</p>
            <div class="readmore1">
                <a href="<?= $is_prof ? 'profs.php' : 'index.php' ?>">Retour à l'accueil</a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
include('templates/_footer.php');
?>
