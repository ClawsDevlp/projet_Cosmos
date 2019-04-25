<?php
/*
 *  Play a game
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
if((!isset($_GET["text"]) || empty($_GET["text"])) && (!isset($_GET["choice_player"]) || empty($_GET["choice_player"])) && (!isset($_GET["id_game"]) || empty($_GET["id_game"])) &&(!isset($_GET["id_player"]) || empty($_GET["id_player"]))){
    http_response_code(422);
    echo json_encode(array("message" => "Missing parameters."));
    exit();
}

$current_text = $_GET["text"];
$id_current_text = getIdFromText($current_text);
$choice_player = $_GET["choice_player"];
$id_game = $_GET["id_game"];
$id_player = $_GET["id_player"];

$choice1 = "";
$choice2 = "";
$choice3 = "";

//Regarde si le texte courant a un texte suivant direct (sans choix)
if(isThereDirectNext($id_current_text) == true) {

	//Regarde si un objet est nécessaire pour aller au texte suivant
    $needed_object = doesDirectNextNeedObject($id_current_text);
    
    //Si ce n'est pas le cas :
    if(is_int($needed_object) && $needed_object == 0) {
        //Récupère le texte suivant en fonction de l'id actuel
        $new_text = getDirectNextTextFromIdWithoutObject($id_current_text);
    }
    //S'il faut un objet :
    else if (is_array($needed_object)) {
        $current_inventory = readInventory($id_game);
        $new_text = getDirectNextTextFromIdWithObject($id_current_text, $current_inventory);
    }

	//Récupère l'id du texte suivant
	$id_new_text = getIdFromText($new_text);
	//Récupère le type du nouveau texte
	$type_new_text = getTypeText($new_text);
	//Regarde comment sera le prochain texte
	checkFutureChoices($id_game, $id_new_text, $choice1, $choice2, $choice3);
}
//Il faut faire un choix pour aller au texte suivant
else { 

	//Regarde si la réponse donne un objet. Si oui, cela crée une nouvelle ligne dans la table 'objetsrecuperes'
    $id_choice = (int)getIdFromChoice($choice_player);
    $id_object = (int)getIdObjectFromChoice($id_choice); //Retourne 0 si il n'y a pas d'objet
    if($id_object != 0) {
        insertObjectInInventory($id_object, $id_game);
    }

	//Récupère le prochain texte en fonction de la réponse
	$new_text = getTextFromChoice($choice_player);
	//Récupère l'id du texte suivant
	$id_new_text = getIdFromText($new_text);
	//Récupère le type du nouveau texte
	$type_new_text = getTypeText($new_text);
	//Regarde comment sera le prochain texte
	checkFutureChoices($id_game, $id_new_text, $choice1, $choice2, $choice3);
    
}

//Met à jour l'avancement de la partie
updateGame($id_game, $id_player, $id_new_text);

$json = array(
		"id_player" => $id_player,
		"id_game" => $id_game,
		"text" => $new_text,
		"id" => $id_new_text,
		"typeText" => $type_new_text,
		"choice1" => $choice1,
		"choice2" => $choice2,
		"choice3" => $choice3
		);

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>