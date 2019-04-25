<?php

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Include data
include_once "../data/MyPDO.projet_cosmos.include.php";

//REQUETE : Récupère l'id du texte courant
function getIdFromText ($current_text) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.id_texte AS id
		FROM textes t
		WHERE t.contenu_texte = :current_text;
SQL
);
    $stmt->execute(array(":current_text" => $current_text));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	$id_current_text = (int)$array[0]["id"];
	return $id_current_text;
}

//REQUETE : Récupère le texte en fonction de l'id
function getTextFromId($id_text) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.contenu_texte AS content
		FROM textes t
		WHERE t.id_texte = :id_text;
SQL
);
    $stmt->execute(array(":id_text" => $id_text));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	return $array[0]["content"];
}

//REQUETE : Récupère le type du texte courant
function getTypeText($current_text) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.id_type AS type
		FROM textes t
		WHERE t.contenu_texte = :current_text;
SQL
);
    $stmt->execute(array(":current_text" => $current_text));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	$type_current_text = (int)$array[0]["type"];
	return $type_current_text;
}

//REQUETE : Récupère le type du texte en fonction de l'id
function getTypeTextFromId($id_text) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t.id_type AS type
		FROM textes t
		WHERE t.id_texte = :id_text;
SQL
);
    $stmt->execute(array(":id_text" => $id_text));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	$type_current_text = (int)$array[0]["type"];
	return $type_current_text;
}

//REQUETE : Regarde si l'id existe dans la table 'textesuivant'
function isThereDirectNext($current_id) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT ts.id_texte_origine AS id
		FROM textesuivant ts
		WHERE ts.id_texte_origine = $current_id
SQL
    );
	$stmt->execute(array(":current_id" => $current_id));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}
    
	if(empty($array)) {
		return false;
	} else {
		return true;
	}
}

//REQUETE : Récupère le texte suivant sans objet
function getDirectNextTextFromIdWithoutObject($current_id) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT t2.contenu_texte AS content
		FROM textes t1
		INNER JOIN textesuivant ts ON t1.id_texte = ts.id_texte_origine
		INNER JOIN textes t2 ON ts.id_texte_suivant = t2.id_texte
		WHERE t1.id_texte = $current_id
SQL
    );
    $stmt->execute(array(":current_id" => $current_id));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	return $array[0]["content"];
}

//REQUETE : Récupère le texte suivant avec objet
function getDirectNextTextFromIdWithObject($current_id, $inventory_array) {
	$array = [];
	for($i = 0; $i < count($inventory_array); $i++) {
		$object = $inventory_array[$i]["id"];

		$stmt = MyPDO::getInstance()->prepare(<<<SQL
			SELECT t2.contenu_texte AS content
			FROM textes t1
			INNER JOIN textesuivant ts ON t1.id_texte = ts.id_texte_origine
			INNER JOIN textes t2 ON ts.id_texte_suivant = t2.id_texte
			WHERE t1.id_texte = :current_id AND ts.id_objet_necessaire = :object;
SQL
        );

		$stmt->execute(array(":current_id" => $current_id, ":object" => $object));
		while (($row = $stmt->fetch()) !== false) {
			$array[] = $row;
		}
	}

	return $array[0]["content"];
}

//REQUETE : Regarde s'il faut un objet pour aller au texte suivant direct
function doesDirectNextNeedObject($current_id) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT ts.id_objet_necessaire AS id
		FROM textesuivant ts 
		WHERE ts.id_texte_origine = :current_id;
SQL
);
	$stmt->execute(array(":current_id" => $current_id));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	if($array[0]["id"] == NULL) {
		return 0;
	} else {
		return $array;
	}
}

//REQUETE : Regarde s'il faut un objet pour aller au texte choisi
function doesChosenTextNeedObject($current_id) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT DISTINCT r.id_objet_necessaire AS id
		FROM reponses r
		WHERE r.id_texte_declencheur = :current_id;
SQL
);
    $stmt->execute(array(":current_id" => $current_id));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	if(sizeof($array) == 1 && $array[0]["id"] == NULL) {
		return 0;
	} else {
		return $array;
	}
}

?>