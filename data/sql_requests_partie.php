<?php

/***** EN-TETE *****/

// headers
header("Content-Type: application/json; charset=UTF-8");

// check HTTP method
$method = strtolower($_SERVER['REQUEST_METHOD']);

// include data
include_once "MyPDO.projetphp.include.php";
include_once "sql_requests_partie_texts.php";
include_once "sql_requests_partie_answers.php";
include_once "sql_requests_partie_inventory.php";


// response status
http_response_code(200);


/***** CODE *****/


function getLastPartie($id_joueur) {
		//REQUETE : Récupère l'id_partie et l'id_texte de la dernière partie du joueur
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT p.id_partie AS id_partie, p.id_texte AS id_texte
		FROM partie p
		WHERE p.id_joueur = $id_joueur
		ORDER BY p.date_texte DESC
		LIMIT 1
SQL
);

	//Exécute la requête
	$stmt->execute();

	//Rempli le tableau '$array' avec la réponse de la requête
	while (($row = $stmt->fetch()) !== false) {
		$array = [];
		array_push($array, $row);
	}
	//FIN REQUETE

	if(empty($array)) {
		exit();
	}
	else {
		return $array;
	}
}


function createPartie($id_joueur) {
		//REQUETE : Crée une nouvelle partie
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		INSERT INTO partie (id_texte, id_joueur)
		VALUES (1,$id_joueur)
SQL
);

	//Exécute la requête
	$stmt->execute();

	//FIN REQUETE
}

function updatePartie($id_partie, $id_joueur, $id_texte) {
			//REQUETE : Met à jour la partie
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		UPDATE partie
		SET id_texte = $id_texte, date_texte = CURRENT_TIMESTAMP
		WHERE id_partie = $id_partie AND id_joueur = $id_joueur
SQL
);

	//Exécute la requête
	$stmt->execute();

	//FIN REQUETE
}

?>