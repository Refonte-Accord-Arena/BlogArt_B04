<?php
require_once __DIR__ . '/../../../CONNECT/config.php';
?>
<link href="style.css" rel="stylesheet">

<footer>
    <div class="connect_admin">
        <a href="<?=ROOTFRONT?>/connexionAdmin.php">Connexion Administrateur</a>
        <span>@ 2022 Nebulab. All rights reserved</span>
    </div> 

    <div class="revenir_haut">
        <a href="#top">
            <img src="<?=ROOTFRONT?>/front/assets/flecheHautFooter.svg" alt="flèche haut">
            <!-- <img src="../front/assets/flecheHautFooter.svg" alt="flèche haut"> -->

            Revenir en haut
        </a>
    </div>

    <div class="liens">
        <a href="../front/mentionlegal.php">Mentions légales</a>
        <a href="../front/CGU.php">CGU</a>
        <a href="../front/home.php">Accueil</a>
    </div>

</footer>