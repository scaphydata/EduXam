<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . '/../php/_debug.php');
?>
<!DOCTYPE html>
<html lang="fr">


<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width initial-scale=1.0">

    <!-- NORMALIZE -->
    <link rel="stylesheet" type="text/css" href="<?= $base_url ?? '' ?>styles/libs/normalize/7.0.0/normalize.css" />
    <!-- FAVICON -->
    <link rel="shortcut icon" href="<?= $base_url ?? '' ?>images/eduxamMignature.png" >
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="<?= $base_url ?? '' ?>styles/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- GOOGLE FONT -->
    <!-- CSS CUSTOM -->
    <link rel="stylesheet" type="text/css" href="<?= $base_url ?? '' ?>styles/_debug.css" />
    <link rel="stylesheet" type="text/css" href="<?= $base_url ?? '' ?>styles/style.css?v=<?= date("YmdHis") ?>" />
    <!-- JQUERY -->
    <script src="<?= $base_url ?? '' ?>javascript/libs/jquery-3.2.1.min.js"></script>
    <!-- MODERNIZR -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <!-- PLUGINS JS -->

    <title>EduXam</title>

</head>


<body>


<!-- BODY:HEADER -->
<header>
    <div class="entete">
        <div id="menu3" class="boutonlogin">
            <ul id="menu" >
                <li class="#"><a href="<?= $base_url ?? '' ?>eleve.php">Enfant</a></li>
            </ul>
        </div>
        <div id="menu3" class="boutonlogin">
            <ul id="menu" >
                <li class="#"><a href="<?= $base_url ?? '' ?>php/messagesdesprofs.php">Messages</a></li>
            </ul>
        </div>
        <div id="menu2" class="boutonlogin">
            <ul id="menu" >
                <li class="#"><a href="<?= $base_url ?? '' ?>php/inscription.php">S'inscrire</a></li>
            </ul>
        </div>

        <div id="menu1" class="boutonlogin">
            <ul id="menu">
                <li>
                    <a href="#" class="titremenu"><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Connexion' ?></a>
                    <div>
                        <ul>
                            <?php if (isset($_SESSION['username'])): ?>
                                <li class="#"><a href="<?= $base_url ?? '' ?>php/informations.php">Informations</a></li>
                                <li class="#"><a href="<?= $base_url ?? '' ?>php/logout.php">Se déconnecter</a></li>
                            <?php else: ?>
                                <li class="#"><a href="<?= $base_url ?? '' ?>php/connexionparents.php">Se connecter</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <img src="<?= $base_url ?? '' ?>images/eduxamLogo.png" />
        <h1>EduXam</h1>
        <div class="clearfloat "></div>

        <div class="soustitre">
            <h2>lorem ipsum dolore sit amet lorem ipsum dolore sit amet</h2>
        </div>
    </div>
    <nav>
        <div class="menu2">
            <ul id="menu">
                <li>
                    <a href="#" class="titremenu"> scaphydata</a>
                    <div>
                        <ul>
                            <li class="#"><a href="https://www.scaphydata.com">scaphydata</a></li>
                            <li class="#"><a href="https://www.scaphydata.com">scaphydata</a></li>
                            <li class="#"><a href="https://www.scaphydata.com">scaphydata</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="titremenu">Rent or buy</a>
                    <div>
                        <ul>
                            <li><a href="https://scaphydata.com/ecommerce3D/">Rent or buy</a></li>
                            <li><a href="https://scaphydata.com/ecommerce3D/">Rent or buy</a></li>
                            <li><a href="https://scaphydata.com/ecommerce3D/">Rent or buy</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="titremenu">scaphydata3D</a>
                    <div>
                        <ul>
                            <li><a href="https://scaphydata.com/scaphydata3D/">scaphydata3D</a></li>
                            <li><a href="https://scaphydata.com/scaphydata3D/">scaphydata3D</a></li>
                            <li><a href="https://scaphydata.com/scaphydata3D/">scaphydata3D</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="titremenu">Odysseum</a>
                    <div>
                        <ul>
                            <li><a href="https://scaphydata.com/Odysseum/">Odysseum</a></li>
                            <li><a href="https://scaphydata.com/Odysseum/">Odysseum</a></li>
                            <li><a href="https://scaphydata.com/Odysseum/">Odysseum</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clearfloat"></div>
    </nav>
    <div class="soustitrededie">
        <h2>Les parents</h2>
    </div>
</header>



<!-- BODY:MAIN -->
<main>


