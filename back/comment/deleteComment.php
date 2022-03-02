<?php
////////////////////////////////////////////////////////////
//
//  CRUD COMMENT (PDO) - Modifié : 4 Juillet 2021
//
//  Script  : deleteComment.php  -  (ETUD)  BLOGART22
//
////////////////////////////////////////////////////////////

// Del logique du Comment
//
// Mode DEV
require_once ROOT . '/util/utilErrOn.php';

// controle des saisies du formulaire
require_once ROOT . '/util/ctrlSaisies.php';

// Insertion classe Comment
require_once ROOT . '/CLASS_CRUD/comment.class.php';
// Instanciation de la classe Comment
$monCommentaire = NEW COMMENT();
// Instanciation de la classe Comment


// Gestion des erreurs de saisie
$erreur = false;

// Init variables form
include ROOT . '/back/comment/initComment.php';

// Gestion du $_SERVER["REQUEST_METHOD"] => En GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    


    // create / update effective du comment
    
    $monCommentaire->delete($_GET['id1'], $_GET['id2']);
    header("Location: ./comment.php");





}   // Fin if ($_SERVER["REQUEST_METHOD"] === "GET")
?>

