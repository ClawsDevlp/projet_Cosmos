<?php
/*
 *  SQL requests for game choices
 */

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Include data
include_once "../data/MyPDO.projet_cosmos.include.php";
include_once "sql_requests_game_choices.php";
include_once "sql_requests_game_inventory.php";
include_once "sql_requests_game_texts.php";

//REQUETE : Récupère les réponses en fonction de l'id du texte
function getChoices($current_id) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT DISTINCT contenu_reponse AS answers, id_objet_necessaire AS neededObj
		FROM reponses
		WHERE id_texte_declencheur = :current_id;
SQL
);
    $stmt->execute(array(":current_id" => $current_id));
    $choices = array();
	while (($row = $stmt->fetch()) !== false) {
		$choices[] = $row;
	}
    
	if(empty($choices)) {
		exit();
	} else {
		return $choices;
	}
}

//REQUETE : Récupère le texte en fonction de la réponse
function getTextFromChoice($current_choice) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT DISTINCT t.contenu_texte AS content
		FROM textes t
		INNER JOIN reponses r ON t.id_texte = r.id_texte_destination
		WHERE r.contenu_reponse = :current_choice;
SQL
);
	$stmt->execute(array(":current_choice" => $current_choice));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	return $array[0]["content"];
}

//REQUETE : Récupère l'id de la réponse correspondante
function getIdFromChoice($current_choice) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT r.id_reponse AS id
		FROM reponses r
		WHERE r.contenu_reponse = :current_choice;
SQL
);
    $stmt->execute(array(":current_choice" => $current_choice));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	if(empty($array)) {
		exit();
	} else {
		//Assigne l'id de la réponse courante à la variable
		$id_current_choice = (int)$array[0]["id"];
		return $id_current_choice;
	}
}

//REQUETE : Regarde si la réponse donne un objet
function getIdObjectFromChoice($id_choice) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT o.id_objet AS id
		FROM objets o
		WHERE o.id_reponse = :id_choice;
SQL
);
	$stmt->execute(array(":id_choice" => $id_choice));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	if(empty($array)) {
		return 0;
	} else {
		$id_obj = (int)$array[0]["id"];
		return $id_obj;
	}
}

?>