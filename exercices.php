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
    require_once('templates/_headereleve.php');
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
            <a href="video.php?id=<?= $id ?>" >Video</a>
        </div>
        <div>
            <a href="exercices.php?id=<?= $id ?>" style="background-color: darkcyan; color: white;">Exercices</a>
        </div>
    </div>
    <div class="formation1" style="max-width: 80%; margin: 40px auto; padding: 20px; border: 2px solid darkcyan; border-radius: 15px;">

        <?php if ($formation): ?>
            <h3>Exercices : <?= h($formation['name']) ?></h3>
            <img src="<?= h($formation['image']) ?>" alt="<?= h($formation['name']) ?>" style="max-width: 250px; height: auto; margin: 20px auto; display: block;" />


            <div style="margin: 30px 0; text-align: left; line-height: 1.6;">
                <p>Pratiquez vos connaissances sur <?= h($formation['name']) ?>.</p>
                <ul style="margin-top: 20px;">
                    <li>QCM de validation des acquis (Prochainement)</li>
                    <li>Exercices pratiques guidés (Prochainement)</li>
                    <li>Projet final de formation (Prochainement)</li>
                </ul>
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
