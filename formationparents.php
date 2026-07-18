<?php
require_once('php/database.php');
require_once('php/functions.php');
start_secure_session();
check_parents_logged_in();

// Get formation ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$formation = null;
$formations = [];

try {
    $pdo = getDatabaseConnection();
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM formations WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $formation = $stmt->fetch();
    } else {
        $stmt = $pdo->query("SELECT * FROM formations");
        $formations = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    // Handle error
}
require_once('templates/headerparents.php') ?>

<section>
    <?php if ($id > 0): ?>
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
        <div class="formation1" >

            <?php if ($formation): ?>
                <h3><?= h($formation['name']) ?></h3>

                <img src="<?= h($formation['image']) ?>" alt="<?= h($formation['name']) ?>" >
                <?= nl2br(h($formation['description'])) ?>
                </p>
                <div class="readmore1" >
                    <a href="profs.php">Retour aux formations</a>
                </div>
            <?php else: ?>
                <h3>Formation non trouvée</h3>
                <p>Désolé, nous n'avons pas pu trouver la formation demandée.</p>
                <div class="readmore1">
                    <a href="profs.php">Retour à l'accueil</a>
                </div>
            <?php endif; ?>

        </div>
    <?php else: ?>
        <div class="formations-list">
            <h2 >Liste des formations</h2>
            <?php for ($i = 0; $i < count($formations); $i += 2): ?>
                <div class="duoformation">
                    <?php if (isset($formations[$i])): ?>
                        <div class="formation1">
                            <h3><?= h($formations[$i]['name']) ?></h3>
                            <img src="<?= h($formations[$i]['image']) ?>" alt="<?= h($formations[$i]['name']) ?>" />
                            <p><?= h(mb_strimwidth($formations[$i]['description'], 0, 250, "...")) ?></p>
                            <div class="readmore1">
                                <a href="Formation.php?id=<?= $formations[$i]['id'] ?>">Consulter</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($formations[$i + 1])): ?>
                        <div class="formation2">
                            <h3><?= h($formations[$i + 1]['name']) ?></h3>
                            <img src="<?= h($formations[$i + 1]['image']) ?>" alt="<?= h($formations[$i + 1]['name']) ?>" />
                            <p><?= h(mb_strimwidth($formations[$i + 1]['description'], 0, 250, "...")) ?></p>
                            <div class="readmore2">
                                <a href="Formation.php?id=<?= $formations[$i + 1]['id'] ?>">Consulter</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once('templates/_footer.php') ?>

