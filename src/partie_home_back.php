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


$id_joueur = 1; //A DEFINIR !!!!

//Récupère le contenu du bouton
if(isset($_GET[0]) && !empty($_GET[0])) {
	$button_value = $_GET[0];
}

if($button_value == "Me réveiller") {
	//Récupère les infos de la dernière partie
	$partie_infos = getLastPartie($id_joueur);

	//Si il y a une dernière partie et que le type du texte correspondant n'est pas une fin : on demande si le joueur veut reprendre sa partie
	if(is_array($partie_infos) && isThisEndFromId((int)$partie_infos[0]['id_texte']) != true) {
		$json = array(
				"content" => "Reprendre ?"
			);
	}
	//Sinon on crée une partie et on stocke les infos dans les variables
	else {
		createPartie($id_joueur);
		$partie_infos = getLastPartie($id_joueur);

		$last_id_partie = (int)$partie_infos[0]['id_partie'];
		$last_id_text = (int)$partie_infos[0]['id_texte'];

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
else if ($button_value == "Annuler") {
		//Sinon on crée une partie et on stocke les infos dans les variables
		createPartie($id_joueur);
		$partie_infos = getLastPartie($id_joueur);

		$last_id_partie = (int)$partie_infos[0]['id_partie'];
		$last_id_text = (int)$partie_infos[0]['id_texte'];

		$json = array(
				"content" => "Nouvelle partie !"
			);
}


echo json_encode($json);

exit();
?>