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

function getIdFromText ($current_text) {
	//REQUETE : Récupère l'id du texte courant
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.id_texte AS id
		FROM textes t
		WHERE t.contenu_texte = "$current_text"
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

	//Assigne l'id du texte courant à la variable
	$id_current_text = (int)$array[0]['id'];

	//Retourne l'id correspondant
	return $id_current_text;
}

function getTextFromId($id_text) {
		//REQUETE : Récupère le texte en fonction de l'id
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.contenu_texte AS content
		FROM textes t
		WHERE t.id_texte = $id_text
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

	//Retourne le texte
	return $array[0]['content'];
}

function getTypeText($current_text) {
	//REQUETE : Récupère le type du texte courant
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.id_type AS type
		FROM textes t
		WHERE t.contenu_texte = "$current_text"
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

	//Assigne le type du texte courant à la variable
	$type_current_text = (int)$array[0]['type'];

	return $type_current_text;
}

function getTypeTextFromId($id_text) {
		//REQUETE : Récupère le type du texte en fonction de l'id
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.id_type AS type
		FROM textes t
		WHERE t.id_texte = $id_text
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

	//Assigne le type du texte courant à la variable
	$type_current_text = (int)$array[0]['type'];

	return $type_current_text;
}


function isThereDirectNext($current_id) {
	//REQUETE : Regarde si l'id existe dans la table 'textesuivant'
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT ts.id_texte_origine AS id
		FROM textesuivant ts
		WHERE ts.id_texte_origine = $current_id
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
		return false;
	}
	else {
		return true;
	}
}




function getDirectNextTextFromIdWithoutObject($current_id) {
	//REQUETE : Récupère le texte suivant sans objet
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t2.contenu_texte AS content
		FROM textes t1
		INNER JOIN textesuivant ts ON t1.id_texte = ts.id_texte_origine
		INNER JOIN textes t2 ON ts.id_texte_suivant = t2.id_texte
		WHERE t1.id_texte = $current_id
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

	//Retourne le texte
	return $array[0]['content'];
}

function getDirectNextTextFromIdWithObject($current_id, $inventory_array) {
	$array = [];
	for($i = 0; $i < count($inventory_array); $i++) {
		$object = $inventory_array[$i]['id'];

			//REQUETE : Récupère le texte suivant avec objet
		$stmt = MyPDO::getInstance()->prepare(<<<SQL
			SELECT t2.contenu_texte AS content
			FROM textes t1
			INNER JOIN textesuivant ts ON t1.id_texte = ts.id_texte_origine
			INNER JOIN textes t2 ON ts.id_texte_suivant = t2.id_texte
			WHERE t1.id_texte = $current_id AND ts.id_objet_necessaire = $object
SQL
);

		//Exécute la requête
		$stmt->execute();

		//Rempli le tableau '$array' avec la réponse de la requête
		while (($row = $stmt->fetch()) !== false) {
			array_push($array, $row);
		}
		//FIN REQUETE
	}
	
	//Retourne le texte
	return $array[0]['content'];
}

function doesDirectNextNeedObject($current_id) {
		//REQUETE : Regarde s'il faut un objet pour aller au texte suivant direct
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT ts.id_objet_necessaire AS id
		FROM textesuivant ts 
		WHERE ts.id_texte_origine = $current_id
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

	if($array[0]['id'] == NULL) {
		return 0;
	}
	else {
		return $array;
	}
}

function doesChosenTextNeedObject($current_id) {
		//REQUETE : Regarde s'il faut un objet pour aller au texte choisi
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT DISTINCT r.id_objet_necessaire AS id
		FROM reponses r
		WHERE r.id_texte_declencheur = $current_id
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

	if(sizeof($array) == 1 && $array[0]['id'] == NULL) {
		return 0;
	}
	else {
		return $array;
	}
}

?>