<?php

/***** EN-TETE *****/

// headers
header("Content-Type: application/json; charset=UTF-8");

// check HTTP method
$method = strtolower($_SERVER['REQUEST_METHOD']);

// include data
include_once "../data/sql_requests_partie.php";
include_once "partie_other_functions.php";

// response status
http_response_code(200);

// check the method
if ($method !== 'get') {
	http_response_code(405);
	exit();
}

/***** CODE *****/

$id_joueur = 1; //A DEFINIR !!!!!

//Récupère les infos de la dernière partie
$partie_infos = getLastPartie($id_joueur);

//Si il y a une dernière partie et que le type du texte correspondant n'est pas une fin, on stocke les infos dans les variables
if(is_array($partie_infos) && isThisEndFromId((int)$partie_infos[0]['id_texte']) != true) {
		$id_partie = (int)$partie_infos[0]['id_partie'];
		$id_first_text = (int)$partie_infos[0]['id_texte'];
}

$first_text = (string)getTextFromId($id_first_text);
$type_first_text = (int)getTypeTextFromId($id_first_text);

$first_answer1 = "";
$first_answer2 = "";
$first_answer3 = "";

checkCurrentAnswers($id_partie, $id_first_text, $first_answer1, $first_answer2, $first_answer3);


$json = array(
		"id_joueur" => $id_joueur,
		"id_partie" => $id_partie,
		"text" => $first_text,
		"id" => $id_first_text,
		"typeText" => $type_first_text,
		"answer1" => $first_answer1,
		"answer2" => $first_answer2,
		"answer3" => $first_answer3
		);


echo json_encode($json);

exit();
?>