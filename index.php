<?php
require_once('php/database.php');
require_once('php/functions.php');
$pdo=getDatabaseConnection();
$stmt = $pdo->query("SELECT * FROM formations");
$formations = $stmt->fetchAll();

include('templates/_header.php');
?>

<?php for ($i = 0; $i < count($formations); $i += 2): ?>
    <section>
        <div class="duoformation">
            <?php if (isset($formations[$i])): ?>
                <div class="formation1">
                    <h3><?= h($formations[$i]['name']) ?></h3>
                    <a href="Formation.php?id=<?= $formations[$i]['id'] ?>"><img src="<?= h($formations[$i]['image']) ?>" alt="<?= h($formations[$i]['name']) ?>" /></a>
                    <p><?= h(mb_strimwidth($formations[$i]['description'], 0, 250, "...")) ?></p>
                    <div class="readmore1">
                        <a href="Formation.php?id=<?= $formations[$i]['id'] ?>">En savoir +</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($formations[$i + 1])): ?>
                <div class="formation2">
                    <h3><?= h($formations[$i + 1]['name']) ?></h3>
                    <a href="Formation.php?id=<?= $formations[$i + 1]['id'] ?>"><img src="<?= h($formations[$i + 1]['image']) ?>" alt="<?= h($formations[$i + 1]['name']) ?>" /></a>
                    <p><?= h(mb_strimwidth($formations[$i + 1]['description'], 0, 250, "...")) ?></p>
                    <div class="readmore2">
                        <a href="Formation.php?id=<?= $formations[$i + 1]['id'] ?>">En savoir +</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endfor; ?>

<section>
    <div class="formationplus">
        <a href="#">Plus de formations :)</a>
    </div>
</section>

<?php include('templates/_footer.php'); ?>
