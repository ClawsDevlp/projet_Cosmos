<?php

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Include data
include_once "../data/MyPDO.projet_cosmos.include.php";

//REQUETE : Crée une ligne dans la table 'objetsrecuperes' en fonction de la réponse
function insertObjectInInventory($id_obj, $id_game) {
    $stmt = MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO objetsrecuperes (id_partie, id_objet)
        VALUES (:id_game, :id_obj);
SQL
    );
    $stmt->execute(array(":id_obj" => $id_obj, ":id_game" => $id_game));
}

//REQUETE : Récupère les objets récupérés pendant la partie
function readInventory($id_game) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT objrec.id_objet AS id
		FROM objetsrecuperes objrec
		WHERE objrec.id_partie = :id_game;
SQL
);

	$stmt->execute(array(":id_game" => $id_game));
    $array = array();
	while (($row = $stmt->fetch()) !== false) {
		$array[] = $row;
	}

	if(empty($array)) {
		return 0;
	} else {
		return $array;
	}
}

?>