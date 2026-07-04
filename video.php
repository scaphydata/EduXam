<?php
require_once('php/database.php');
require_once('php/functions.php');

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

include('templates/_header.php');
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
                <div style="width: 100%; max-width: 600px; height: 338px; background-color: #eee; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc;">
                    <p style="color: #666;">Lecteur vidéo à venir pour <?= h($formation['name']) ?></p>
                </div>
                <p style="margin-top: 20px; line-height: 1.6;">Regardez les tutoriels vidéo de cette formation.</p>
            </div>

            <div class="readmore1" style="margin-top: 30px;">
                <a href="Formation.php?id=<?= $id ?>">Retour à la formation</a>
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

<?php
include('templates/_footer.php');
?>
