<?php
/*
 *  Start a game : "Me réveiller"
 */

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Check HTTP method
$method = strtolower($_SERVER["REQUEST_METHOD"]);
if($method !== "get") {
    http_response_code(405);
    echo json_encode(array("message" => "This method is not allowed."));
    exit();
}

//Check params
if(!isset($_GET[0]) || empty($_GET[0])){
    http_response_code(422);
    echo json_encode(array("message" => "Incorrect parameters."));
    exit();
}
$button_value = $_GET[0];
$id_player = 1; //A DEFINIR

//Include data
include_once "sql_requests/sql_requests_game.php";
include_once "play_game_divers.php";

if($button_value == "Me réveiller") {
	//Récupère les infos de la dernière partie
	$game_infos = getLastGame($id_player);

	//Si il y a une dernière partie et que le type du texte correspondant n'est pas une fin : on demande si le joueur veut reprendre sa partie
	if(is_array($game_infos) && isThisEndFromId((int)$game_infos[0]["id_texte"]) != true) {
		$json = array(
            "content" => "Reprendre ?"
        );
	}
	//Sinon on crée une partie et on stocke les infos dans les variables
	else {
		createGame($id_player);
		$game_infos = getLastGame($id_player);

		$last_id_game = (int)$game_infos[0]["id_partie"];
		$last_id_text = (int)$game_infos[0]["id_texte"];

		$json = array(
            "content" => "Nouvelle partie !"
        );
	}
}
else if ($button_value == "OK") {
	$json = array(
        "content" => "Continuons !"
    );
}
//Sinon on crée une partie et on stocke les infos dans les variables
else if ($button_value == "Annuler") {
		createGame($id_player);
		$game_infos = getLastGame($id_player);

		$last_id_game = (int)$game_infos[0]["id_partie"];
		$last_id_text = (int)$game_infos[0]["id_texte"];

		$json = array(
            "content" => "Nouvelle partie !"
        );
}

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>