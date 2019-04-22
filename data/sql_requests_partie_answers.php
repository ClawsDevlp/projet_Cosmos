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

function getAnswers($current_id) {
	$array = [];
		//REQUETE : Récupère les réponses en fonction de l'id du texte
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT DISTINCT r.contenu_reponse AS answers, r.id_objet_necessaire AS neededObj
		FROM reponses r
		WHERE r.id_texte_declencheur = $current_id
SQL
);

	//Exécute la requête
	$stmt->execute();

	//Rempli le tableau '$array' avec la réponse de la requête
	while (($row = $stmt->fetch()) !== false) {
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

function getTextFromAnswer($current_answer) {
		//REQUETE : Récupère le texte en fonction de la réponse
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT DISTINCT t.contenu_texte AS content
		FROM textes t
		INNER JOIN reponses r ON t.id_texte = r.id_texte_destination
		WHERE  r.contenu_reponse = "$current_answer"
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


function getIdFromAnswer($current_answer) {
		//REQUETE : Récupère l'id de la réponse correspondante
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT r.id_reponse AS id
		FROM reponses r
		WHERE r.contenu_reponse = "$current_answer"
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
		//Assigne l'id de la réponse courante à la variable
		$id_current_answer = (int)$array[0]['id'];

		//Retourne l'id correspondant
		return $id_current_answer;
	}
}

function getIdObjectFromAnswer ($id_answer) {
		//REQUETE : Regarde si la réponse donne un objet
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT o.id_objet AS id
		FROM objets o
		WHERE o.id_reponse = $id_answer
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
		$id_obj = (int)$array[0]['id'];
		return $id_obj;
	}
}


?>