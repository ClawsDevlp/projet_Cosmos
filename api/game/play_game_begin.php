<?php
/*
 *  Play a game - beginning
 */

session_start();

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
$id_player = $_SESSION["id"];
$id_text = "";
$objects_player = array();
$json = array();

// Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Recover infos player and game (not end)
$stmtInfosGame = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT p.id_partie, p.id_texte, ob.id_objet, nom_objet, o.link
    FROM partie p 
    LEFT OUTER JOIN objetsrecuperes ob ON p.id_partie = ob.id_partie
    LEFT OUTER JOIN objets o ON ob.id_objet = o.id_objet
    INNER JOIN textes t ON p.id_texte = t.id_texte
    WHERE p.date_texte = (SELECT MAX(p.date_texte) FROM partie p WHERE p.id_joueur = :id_player) AND t.nb_end IS NULL;
SQL
    );
$stmtInfosGame->execute(array(":id_player" => $id_player));
while (($row = $stmtInfosGame->fetch()) !== false) {
    $json["id_game"] = $row["id_partie"];
    $id_text = $row["id_texte"];
    $objects_player[] = $row["id_objet"];
    $objects_name[] = $row["nom_objet"];
	$objects_link[] = $row["link"];
}

//Player objects for a query
$in = "";
if($objects_player != NULL){
    foreach ($objects_player as $i => $object){
        $key = ":id".$i;
        $in .= "$key,";
        $in_params[$key] = $object; // collecting values into key-value array
    }
    $in = rtrim($in,","); // :id0,:id1,:id2

    if($objects_name[0] != null){
        $json["objects"] = $objects_name;
		$json["objects_link"] = $objects_link;
    }

}else{
    $in = ":id0";
    $in_params["id0"] = 0;
}

//Recover current text (save)
$stmtCurrentText = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT ts.id_texte_origine, t.contenu_texte
    FROM textesuivant ts
    INNER JOIN textes t ON ts.id_texte_origine = t.id_texte
    WHERE ts.id_texte_origine = :id_text;
SQL
    );
$stmtCurrentText->execute(array(":id_text" => $id_text));
$movies = array();
while (($row = $stmtCurrentText->fetch()) !== false) {
    $id_text = $row["id_texte_origine"];
    $json["text"]["id_text"] = $id_text;
    $json["text"]["text_content"] = $row["contenu_texte"];
}

//Recover choices (save)
$stmtNextChoices = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT r.id_reponse, r.contenu_reponse
    FROM reponses r
    WHERE r.id_texte_declencheur = :id_text AND (r.id_objet_necessaire IN ($in) OR r.id_objet_necessaire IS NULL);
SQL
    );
$params = [":id_text" => $id_text]; 
$stmtNextChoices->execute(array_merge($params, $in_params)); // just merge two arrays
while (($row = $stmtNextChoices->fetch()) !== false) {
    $json["choices"][] = array("id_choice" => $row["id_reponse"], "text_choice" => $row["contenu_reponse"]);
}

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>