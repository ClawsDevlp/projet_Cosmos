<?php
/*
 *  SQL requests for a game 
 */

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Include data
include_once "../data/MyPDO.projet_cosmos.include.php";
include_once "sql_requests_game_choices.php";
include_once "sql_requests_game_inventory.php";
include_once "sql_requests_game_texts.php";

//Resume a game for a player
function getLastGame($id_player) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		SELECT id_partie, id_texte
		FROM partie
		WHERE id_joueur = :id_player
		ORDER BY date_texte DESC
		LIMIT 1
SQL
);
	$stmt->execute(array(":id_player" => $id_player));
    $games = array();
	while (($row = $stmt->fetch()) !== false) {
		$games[] = $row;
	}
    
	if(empty($games)) {
		return 0;
	} else {
		return $games;
	}
}

//Create a new game for a player
function createGame($id_player) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		INSERT INTO partie (id_texte, id_joueur)
		VALUES (1, :id_player)
SQL
);
    $stmt->execute(array(":id_player" => $id_player));
}

//Update the game for a player
function updateGame($id_game, $id_player, $id_text) {
	$stmt = MyPDO::getInstance()->prepare(<<<SQL
		UPDATE partie
		SET id_texte = :id_text, date_texte = CURRENT_TIMESTAMP
		WHERE id_partie = :id_game AND id_joueur = :id_player
SQL
);
	$stmt->execute(array(":id_text" => $id_text, ":id_game" => $id_game, ":id_player" => $id_player));
}

?>