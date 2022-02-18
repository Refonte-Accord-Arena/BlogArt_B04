<?php
// CRUD ARTICLE
// ETUD
require_once __DIR__ . '/../CONNECT/database.php';

class ARTICLE{
	function get_1Article($numArt){
		global $db;
		
		// select
		$query = 'SELECT * FROM ARTICLE WHERE numArt = ?;';
		// prepare
		$result = $db->prepare($query);
		// execute
		$result->execute([$numArt]);
		return($result->fetch());
	}

	function get_1ArticleAnd3FK($numArt){
		global $db;

		// select
		// prepare
		// execute
		return($result->fetch());
	}

	function get_AllArticles(){
		global $db;

		$query = 'SELECT * FROM ARTICLE;';
		// prepare
		$result = $db->query($query);
		// execute
		$allArticles = $result->fetchAll();
		return($allArticles);
	}

	function get_AllArticlesByNumAnglNumThem(){
		global $db;

		// select
		// prepare
		// execute
		return($allArticlesByNumAnglNumThem);
	}

	function get_NbAllArticlesByNumAngl($numAngl){
		global $db;

		// select
        $sql = "SELECT * FROM ARTICLE WHERE numAngl = ?";
        // prepare
        $req = $db->prepare($sql);
        // execute
        $req->execute([$numAngl]);

        $allNbArticlesBynumAngl = $req->rowCount();
		return($allNbArticlesBynumAngl);
	}

	function get_NbAllArticlesByNumThem($numThem){
		global $db;

        // select
        $sql = "SELECT * FROM ARTICLE WHERE numThem = ?";
        // prepare
        $req = $db->prepare($sql);
        // execute
        $req->execute([$numThem]);

        $allNbArticlesBynumThem = $req->rowCount();
 		return($allNbArticlesBynumThem);
	}

	// Barre de recherche CONCAT : mots clés dans ARTICLE & THEMATIQUE
	function get_ArticlesByMotsCles($motcle){
		global $db;

		// Recherche plusieurs mots clés (CONCAT)
		$textQuery = 'SELECT * FROM ARTICLE AR INNER JOIN THEMATIQUE TH ON AR.numThem = TH.numThem WHERE CONCAT(libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, libThem) LIKE "%'.$motcle.'%" ORDER BY numArt DESC';
		$result = $db->query($textQuery);
		$allArticlesByMotsCles = $result->fetchAll();
		return($allArticlesByMotsCles);
	}

	// Barre de recherche JOIN : mots clés par MOTCLE (TJ) dans ARTICLE
	function get_MotsClesByArticles($listMotcles){
		global $db;

		/*
		Requete avec IN :
		SELECT * FROM MOTCLE WHERE libMotCle IN ('Bordeaux', 'bleu');
		*/
		// Recherche mot clé (INNER JOIN) dans tables MOTCLE & (ARTICLE)
		$textQuery = 'SELECT AR.numArt, libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt FROM MOTCLE MC INNER JOIN MOTCLEARTICLE MCA ON MC.numMotCle = MCA.numMotCle INNER JOIN ARTICLE AR ON MCA.numArt = AR.numArt WHERE libMotCle IN (' . $listMotcles . ');';
		$result = $db->prepare($textQuery);
		$result->execute([$listMotcles]);
		$allArticlesByNumAnglNumThem = $result->fetchAll();
		return($allArticlesByNumAnglNumThem);
	}

	// Fonction pour recupérer la prochaine PK de la table ARTICLE
	function getNextNumArt() {
		global $db;

		$requete = "SELECT MAX(numArt) AS numArt FROM ARTICLE;";
		$result = $db->query($requete);

		if ($result) {
			$tuple = $result->fetch();
			$numArt = $tuple["numArt"];
			// No PK suivante ARTICLE
			$numArt++;
		}   // End of if ($result)
		return $numArt;
	} // End of function

	// Fonction pour recupérer la dernière PK de ARTICLE
	// avant insert des n occurr dans TJ MOTCLEARTICLE
	function get_LastNumArt(){
		global $db;

		$requete = "SELECT MAX(numArt) AS numArt FROM ARTICLE;";
		$result = $db->query($requete);

		if ($result) {
			$tuple = $result->fetch();
			$lastNumArt = $tuple["numArt"];

		}   // End of if ($result)
		return $lastNumArt;
	} // End of function

	function create($dtCreArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO ANGLE (dtCreArt, libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numAngl, numThem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
			// prepare
			$request = $db->prepare($query);
			$request->execute([$dtCreArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem]);
			// execute
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert ARTICLE : ' . $e->getMessage());
		}
	}

	function update($numArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem){
		global $db;

		try {
			$db->beginTransaction();

				// update
				$query = 'UPDATE ARTICLE SET libTitrArt = ?, libChapoArt = ?, libAccrochArt = ?, parag1Art = ?, libSsTitr1Art = ?, parag2Art = ?, libSsTitr2Art = ?, parag3Art = ?, libConclArt = ?, urlPhotArt = ?, numAngl = ?, numThem = ? WHERE numArt = ?;';
				// prepare
				$request = $db->prepare($query);
				// execute
				$request->execute([$libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem, $numArt]);
					$db->commit();
					$request->closeCursor();
				}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update ARTICLE : ' . $e->getMessage());
		}
	}

	function delete($numArt){
		global $db;

		try {
			$db->beginTransaction();

				// delete
				$query = 'DELETE FROM ARTICLE WHERE numArt=?'; 
				// prepare
				$request = $db->prepare($query);
				// execute
				$request->execute([$numArt]);
	
				$count = $request->rowCount(); 
				$db->commit();
				$request->closeCursor();
				return($count); 
			}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete ARTICLE : ' . $e->getMessage());
		}
	}
}	// End of class
