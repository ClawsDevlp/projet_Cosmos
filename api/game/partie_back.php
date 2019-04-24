<?php

/***** EN-TETE *****/

// headers
header("Content-Type: application/json; charset=UTF-8");

// check HTTP method
$method = strtolower($_SERVER['REQUEST_METHOD']);

// include data
include_once "sql_requests/sql_requests_partie.php";
include_once "partie_other_functions.php";

// response status
http_response_code(200);

// check the method
if ($method !== 'get') {
	http_response_code(405);
	exit();
}

/***** CODE *****/

//Récupère le contenu du texte courant
if(isset($_GET[0]) && !empty($_GET[0])) {
	$current_text = $_GET[0];
}

//Récupère l'id du texte courant
$id_current_text = getIdFromText($current_text);

//Récupère le contenu de la réponse
if(isset($_GET[1]) && !empty($_GET[1])) {
	$current_answer = $_GET[1];
}

//Récupère l'id de la partie
if(isset($_GET[2]) && !empty($_GET[2])) {
	$id_partie = $_GET[2];
}

//Récupère l'id du joueur
if(isset($_GET[3]) && !empty($_GET[3])) {
	$id_joueur = $_GET[3];
}

$answer1 = "";
$answer2 = "";
$answer3 = "";



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
			$current_inventory = readInventory($id_partie);
			$new_text = getDirectNextTextFromIdWithObject($id_current_text, $current_inventory);
		}

	//Récupère l'id du texte suivant
	$id_new_text = getIdFromText($new_text);

	//Récupère le type du nouveau texte
	$type_new_text = getTypeText($new_text);

	//Regarde comment sera le prochain texte
	checkFutureAnswers($id_partie, $id_new_text, $answer1, $answer2, $answer3);
}
//Il faut faire un choix pour aller au texte suivant
else { 

	//Regarde si la réponse donne un objet. Si oui, cela crée une nouvelle ligne dans la table 'objetsrecuperes'
		$id_answer = (int) getIdFromAnswer($current_answer);
		$id_object = (int) getIdObjectFromAnswer($id_answer); //Retourne 0 si il n'y a pas d'objet
		if($id_object != 0) {
			insertObjectIntoTheInventory($id_object, $id_partie);
		}

	//Récupère le prochain texte en fonction de la réponse
	$new_text = getTextFromAnswer($current_answer);
	
	//Récupère l'id du texte suivant
	$id_new_text = getIdFromText($new_text);

	//Récupère le type du nouveau texte
	$type_new_text = getTypeText($new_text);

	//Regarde comment sera le prochain texte
	checkFutureAnswers($id_partie, $id_new_text, $answer1, $answer2, $answer3);
}

//Met à jour l'avancement de la partie
updatePartie($id_partie, $id_joueur, $id_new_text);


$json = array(
		"id_joueur" => $id_joueur,
		"id_partie" => $id_partie,
		"text" => $new_text,
		"id" => $id_new_text,
		"typeText" => $type_new_text,
		"answer1" => $answer1,
		"answer2" => $answer2,
		"answer3" => $answer3
		);


echo json_encode($json);

exit();
?>