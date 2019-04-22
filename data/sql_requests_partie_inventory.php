<?php

/***** EN-TETE *****/

// headers
header("Content-Type: application/json; charset=UTF-8");

// check HTTP method
$method = strtolower($_SERVER['REQUEST_METHOD']);

// include data
include_once "MyPDO.projetphp.include.php";


// response status
http_response_code(200);


/***** CODE *****/

function insertObjectIntoTheInventory($id_obj, $id_partie) {
		//REQUETE : Crée une ligne dans la table 'objetsrecuperes' en fonction de la réponse
		$stmt = MyPDO::getInstance()->prepare(<<<SQL
			INSERT INTO objetsrecuperes (id_partie, id_objet)
			VALUES ($id_partie, $id_obj)
SQL
);
		//Exécute la requête
		$stmt->execute();
		//FIN REQUETE
}


function readInventory($id_partie) {
		//REQUETE : Récupère les objets récupérés pendant la partie
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT objrec.id_objet AS id
		FROM objetsrecuperes objrec
		WHERE objrec.id_partie = $id_partie
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
		return 0;
	}
	else {
		return $array;
	}
}


?>