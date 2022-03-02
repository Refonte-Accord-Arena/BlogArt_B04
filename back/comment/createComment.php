<?php
////////////////////////////////////////////////////////////
//
//  CRUD COMMENT (PDO) - Modifié : 4 Juillet 2021
//
//  Script  : createComment.php  -  (ETUD)  BLOGART22
//
////////////////////////////////////////////////////////////

// EDI WYSIWYG : ckeditor4
//
// Mode DEV
require_once ROOT . '/util/utilErrOn.php';

// controle des saisies du formulaire
require_once ROOT . '/util/ctrlSaisies.php';

// Insertion classe Comment
require_once ROOT . '/CLASS_CRUD/comment.class.php';

// Instanciation de la classe Article
$monCommentaire = new COMMENT();
// Instanciation de la classe Comment
require_once ROOT . '/CLASS_CRUD/article.class.php';

// Instanciation de la classe Article
$monArticle = new ARTICLE();

require_once ROOT . '/CLASS_CRUD/membre.class.php';
$monMembre = new MEMBRE();


// Gestion des erreurs de saisie
$erreur = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    
    // controle des saisies du formulaire
    if(isset($_POST['Submit'])){
        $Submit = $_POST['Submit'];
    } else {
        $Submit = "";
    }

    if ((isset($_POST["Submit"])) AND ($Submit === "Initialiser")) {
    
            header("Location: ./comment.php");
    }   // End of if ((isset($_POST["submit"])) ...
        
    if (((isset($_POST['Membre'])) AND (!empty($_POST['Membre'])) AND (isset($_POST['Article'])) AND (!empty($_POST['Article']))AND (isset($_POST['libCom'])) AND (!empty($_POST['libCom']))
        AND (!empty($_POST['Submit'])) AND ($Submit === "Valider"))) {
            // Saisies valides
            $erreur = false;
           
            $numMemb = ctrlSaisies(($_POST['Membre']));
            $numArt = ctrlSaisies(($_POST['Article']));
            $numSeqCom = intval($monCommentaire->getNextNumCom($numArt));
            $libCom = ctrlSaisies(($_POST['libCom']));
            // $dtCreCom = ctrlSaisies(($_POST['dtCreCom']));


            $monCommentaire-> create($numSeqCom, $numArt, $libCom, $numMemb);
    
            header("Location: ./comment.php");
        }   // Fin if ((isset($_POST['libStat']))
        else {
            // Saisies invalides
            $erreur = true;
            $errSaisies =  "Erreur, la saisie est obligatoire !";
        }   // End of else erreur saisies


    // insertion classe comment


}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include ROOT . '/back/comment/initComment.php';
// Var init


?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
    <title>Admin - CRUD Commentaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />

  <!-- Style du formulaire et des boutons -->
    <link href="../css/style.css" rel="stylesheet" type="text/css" />

</head>
<body>
    <h1>BLOGART22 Admin - CRUD Commentaire</h1>
    <h2>Ajout d'un commentaire</h2>

    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" accept-charset="UTF-8">

      <fieldset>
        <legend class="legend1">Commentez un commentaire...</legend>

        <input type="hidden" id="id" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>" />

<!-- --------------------------------------------------------------- -->
    <!-- FK : Membre, Article -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Listbox Membre -->
        <br>
        <div class="control-group">
            <div class="controls">
            <label class="control-label" for="LibTypAngl">
                <b>Quel membre :&nbsp;&nbsp;&nbsp;</b>
            </label>
            
            <select name="Membre" id="Membre"  class="form-control form-control-create">
                <option value="-1">- - - Choisissez un membre - - -</option>
                <?php
                $allMembres = $monMembre->get_AllMembres();
                
                if($allMembres){
                for ($i=0; $i < count($allMembres); $i++){
                    $value = $allMembres[$i]['numMemb'];
                ?>
                
                <option value="<?php echo($value); ?>"> <?= $value ." - " . $allMembres[$i]['pseudoMemb']; ?> </option>
                
                <?php
                    } // End of foreach
                }   // if ($result)
                ?>
            </select>
            <!-- Listbox membre => 2ème temps -->

            </div>
        </div>
    <!-- FIN Listbox Membre -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Listbox Article -->
        <br>
        <div class="control-group">
            <div class="controls">
            <label class="control-label" for="LibTypThem">
                <b>Quel article :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            </label>
            

            <!-- Listbox Article => 2ème temps -->
            <select name="Article" id="Article"  class="form-control form-control-create">
                <option value="-1">- - - Choisissez un article - - -</option>
                <?php
                $allArticles = $monArticle->get_AllArticles();
                
                if($allArticles){
                for ($i=0; $i < count($allArticles); $i++){
                    $value = $allArticles[$i]['numArt'];
                ?>
                
                <option value="<?php echo($value); ?>"> <?= $value ." - " . $allArticles[$i]['libTitrArt']; ?> </option>
                
                <?php
                    } // End of foreach
                }   // if ($result)
                ?>
            </select>

            </div>
        </div>
    <!-- FIN Listbox Article -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Fin FK : Membre, Article -->
<!-- --------------------------------------------------------------- -->
    <!-- textarea comment -->
        <br>
        <div class="control-group">
            <label class="control-label" for="libCom"><b>Ajoutez votre Commentaire :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <div class="controls">
              <textarea name="libCom" id="editor1" tabindex="30" style="height:400px; width:700px; padding:2px; border:solid 1px black; color:steelblue; border-radius:5px;" rows="20" cols="100" title="Texte à mettre en forme" value="<? if(isset($_GET['libCom'])) echo $_POST['libCom']; ?>"></textarea>
            </div>
        </div>
        <br>
    <!-- End textarea comment -->
<!-- --------------------------------------------------------------- -->
       <small class="error">Votre post est soumis à validation avant son affichage sur le blog (moins d'une semaine)...</small><br><br>

        <div class="control-group">
            <div class="error">
<?php
            if ($erreur) {
                echo ($errSaisies);
            } else {
                $errSaisies = "";
                echo ($errSaisies);
            }
?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Initialiser" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;" name="Submit" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Valider" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;" name="Submit" />
                <br>
            </div>
        </div>
      </fieldset>
    </form>
<?php
require_once ROOT . '/back/comment/footerComment.php';

require_once ROOT . '/back/comment/footer.php';
?>
</body>
</html>
