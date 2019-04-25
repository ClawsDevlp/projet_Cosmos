<?php
/*
 *  Play a game - beginning
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

//Include data
include_once "sql_requests/sql_requests_game.php";
include_once "play_game_divers.php";

//Check params
$id_player = 1; //A DEFINIR
$game_infos = getLastGame($id_player);

//Si il y a une dernière partie et que le type du texte correspondant n'est pas une fin, on stocke les infos dans les variables
if(is_array($game_infos) && isThisEndFromId((int)$game_infos[0]["id_texte"]) != true) {
		$id_game = (int)$game_infos[0]["id_partie"];
		$id_first_text = (int)$game_infos[0]["id_texte"];
}

$first_text = (string)getTextFromId($id_first_text);
$type_first_text = (int)getTypeTextFromId($id_first_text);

$first_choice1 = "";
$first_choice2 = "";
$first_choice3 = "";

checkCurrentChoices($id_game, $id_first_text, $first_choice1, $first_choice2, $first_choice3);

$json = array(
		"id_player" => $id_player,
		"id_game" => $id_game,
		"text" => $first_text,
		"id" => $id_first_text,
		"typeText" => $type_first_text,
		"choice1" => $first_choice1,
		"choice2" => $first_choice2,
		"choice3" => $first_choice3
		);

//Response
http_response_code(200);
echo json_encode($json);

exit();
?>