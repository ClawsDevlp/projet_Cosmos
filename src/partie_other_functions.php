<?php

/***** EN-TETE *****/

// headers
header("Content-Type: application/json; charset=UTF-8");

// check HTTP method
$method = strtolower($_SERVER['REQUEST_METHOD']);

// include data
include_once "../data/MyPDO.projetphp.include.php";

// response status
http_response_code(200);


/***** CODE *****/


function checkFutureAnswers ($id_partie, $id_new_text, &$answer1, &$answer2, &$answer3) {
	//Regarde si le nouveau texte aura un suivant direct (sans choix)
	if(isThereDirectNext($id_new_text) == true) {
		$answer1 = "Suivant";
		$answer2 = "";
		$answer3 = "";
	}
	//Regarde si le texte suivant est une fin
	else if(isThisEndFromId($id_new_text) == true) {
		$answer1 = "Retour au menu !";
		$answer2 = "";
		$answer3 = "";
	}
	else {
		$answers_array = [];
		$answers_array = getAnswers($id_new_text);
		$current_inventory = readInventory($id_partie);

		//Regarde si il y a une première réponse possible
			if(isset($answers_array[0]['answers']) && !empty($answers_array[0]['answers'])) {
				//Regarde si la réponse a besoin d'un objet pour être affichée. Si oui :
				if($answers_array[0]['neededObj'] != NULL) {
					$needed_obj = $answers_array[0]['neededObj'];
					$bool = false;

					//On regarde si l'inventaire n'est pas vide
					if(is_array($current_inventory)) {
							//On parcourt l'inventaire pour voir si on a l'objet demandé
						for($i = 0; $i < sizeof($current_inventory); $i++) {
							if($current_inventory[$i]['id'] == $needed_obj) {
								$bool = true;
							}
						}
						//Si l'objet demandé est dans l'inventaire, on peut afficher la réponse
						if($bool == true) {
							$answer1 = (string)$answers_array[0]['answers'];
						}
					}	

					//Si l'objet n'est pas dans l'inventaire, le réponse ne s'affiche pas
					if($bool == false) {
						$answer1 = "";
					}					
				}
				//Si non :
				else {
					$answer1 = (string)$answers_array[0]['answers'];
				}
			}
			else {
				$answer1 = "";
			}


		//Regarde si il y a une deuxième réponse possible
			if(isset($answers_array[1]['answers']) && !empty($answers_array[1]['answers'])) {
				//Regarde si la réponse a besoin d'un objet pour être affichée. Si oui :
				if($answers_array[1]['neededObj'] != NULL) {
					$needed_obj = $answers_array[1]['neededObj'];
					$bool = false;

					//On regarde si l'inventaire n'est pas vide
					if(is_array($current_inventory)) {
							//On parcourt l'inventaire pour voir si on a l'objet demandé
						for($i = 0; $i < sizeof($current_inventory); $i++) {
							if($current_inventory[$i]['id'] == $needed_obj) {
								$bool = true;
							}
						}
						//Si l'objet demandé est dans l'inventaire, on peut afficher la réponse
						if($bool == true) {
							$answer2 = (string)$answers_array[1]['answers'];
						}
					}

					//Si l'objet n'est pas dans l'inventaire, le réponse ne s'affiche pas
					if($bool == false) {
						$answer2 = "";
					}	
				}
				//Si non :
				else {
					$answer2 = (string)$answers_array[1]['answers'];
				}
				
			}
			else {
				$answer2 = "";
			}


		//Regarde si il y a une troisième réponse possible
			if(isset($answers_array[2]['answers']) && !empty($answers_array[2]['answers'])) {
				//Regarde si la réponse a besoin d'un objet pour être affichée. Si oui :
				if($answers_array[2]['neededObj'] != NULL) {
					$needed_obj = $answers_array[2]['neededObj'];
					$bool = false;

					//On regarde si l'inventaire n'est pas vide
					if(is_array($current_inventory)) {
							//On parcourt l'inventaire pour voir si on a l'objet demandé
						for($i = 0; $i < sizeof($current_inventory); $i++) {
							if($current_inventory[$i]['id'] == $needed_obj) {
								$bool = true;
							}
						}
						//Si l'objet demandé est dans l'inventaire, on peut afficher la réponse
						if($bool == true) {
							$answer3 = (string)$answers_array[2]['answers'];
						}
					}

					//Si l'objet n'est pas dans l'inventaire, le réponse ne s'affiche pas
					if($bool == false) {
						$answer3 = "";
					}	
				}
				//Si non :
				else {
					$answer3 = (string)$answers_array[2]['answers'];
				}			
			}
			else {
				$answer3 = "";
			}		
	}
}


function checkCurrentAnswers ($id_partie, $id_current_text, &$answer1, &$answer2, &$answer3) {
	//Regarde si le texte aura un suivant direct (sans choix)
	if(isThereDirectNext($id_current_text) == true) {
		$answer1 = "Suivant";
		$answer2 = "";
		$answer3 = "";
	}
	//Regarde si le texte est une fin
	else if(isThisEndFromId($id_current_text) == true) {
		$answer1 = "Retour au menu !";
		$answer2 = "";
		$answer3 = "";
	}
	else {
		$answers_array = [];
		$answers_array = getAnswers($id_current_text);
		$current_inventory = readInventory($id_partie);

		//Regarde si il y a une première réponse possible
			if(isset($answers_array[0]['answers']) && !empty($answers_array[0]['answers'])) {
				//Regarde si la réponse a besoin d'un objet pour être affichée. Si oui :
				if($answers_array[0]['neededObj'] != NULL) {
					$needed_obj = $answers_array[0]['neededObj'];
					$bool = false;

					//On regarde si l'inventaire n'est pas vide
					if(is_array($current_inventory)) {
							//On parcourt l'inventaire pour voir si on a l'objet demandé
						for($i = 0; $i < sizeof($current_inventory); $i++) {
							if($current_inventory[$i]['id'] == $needed_obj) {
								$bool = true;
							}
						}
						//Si l'objet demandé est dans l'inventaire, on peut afficher la réponse
						if($bool == true) {
							$answer1 = (string)$answers_array[0]['answers'];
						}
					}	

					//Si l'objet n'est pas dans l'inventaire, le réponse ne s'affiche pas
					if($bool == false) {
						$answer1 = "";
					}					
				}
				//Si non :
				else {
					$answer1 = (string)$answers_array[0]['answers'];
				}
			}
			else {
				$answer1 = "";
			}


		//Regarde si il y a une deuxième réponse possible
			if(isset($answers_array[1]['answers']) && !empty($answers_array[1]['answers'])) {
				//Regarde si la réponse a besoin d'un objet pour être affichée. Si oui :
				if($answers_array[1]['neededObj'] != NULL) {
					$needed_obj = $answers_array[1]['neededObj'];
					$bool = false;

					//On regarde si l'inventaire n'est pas vide
					if(is_array($current_inventory)) {
							//On parcourt l'inventaire pour voir si on a l'objet demandé
						for($i = 0; $i < sizeof($current_inventory); $i++) {
							if($current_inventory[$i]['id'] == $needed_obj) {
								$bool = true;
							}
						}
						//Si l'objet demandé est dans l'inventaire, on peut afficher la réponse
						if($bool == true) {
							$answer2 = (string)$answers_array[1]['answers'];
						}
					}

					//Si l'objet n'est pas dans l'inventaire, le réponse ne s'affiche pas
					if($bool == false) {
						$answer2 = "";
					}	
				}
				//Si non :
				else {
					$answer2 = (string)$answers_array[1]['answers'];
				}
				
			}
			else {
				$answer2 = "";
			}


		//Regarde si il y a une troisième réponse possible
			if(isset($answers_array[2]['answers']) && !empty($answers_array[2]['answers'])) {
				//Regarde si la réponse a besoin d'un objet pour être affichée. Si oui :
				if($answers_array[2]['neededObj'] != NULL) {
					$needed_obj = $answers_array[2]['neededObj'];
					$bool = false;

					//On regarde si l'inventaire n'est pas vide
					if(is_array($current_inventory)) {
							//On parcourt l'inventaire pour voir si on a l'objet demandé
						for($i = 0; $i < sizeof($current_inventory); $i++) {
							if($current_inventory[$i]['id'] == $needed_obj) {
								$bool = true;
							}
						}
						//Si l'objet demandé est dans l'inventaire, on peut afficher la réponse
						if($bool == true) {
							$answer3 = (string)$answers_array[2]['answers'];
						}
					}

					//Si l'objet n'est pas dans l'inventaire, le réponse ne s'affiche pas
					if($bool == false) {
						$answer3 = "";
					}	
				}
				//Si non :
				else {
					$answer3 = (string)$answers_array[2]['answers'];
				}			
			}
			else {
				$answer3 = "";
			}		
	}
}

//Retourne vrai si le texte est une fin
function isThisEndFromId($id_text) {
	$id_type = (int)getTypeTextFromId($id_text);

	if($id_type == 1) {
		return false;
	}
	else if($id_type == 2) {
		return true;
	}
	else {
		exit();
	}
}

?>