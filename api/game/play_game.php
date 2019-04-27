<?php
/*
 *  Play a game
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
if((!isset($_GET["id_game"]) || empty($_GET["id_game"])) 
   && (!isset($_GET["choice_player"]) || empty($_GET["choice_player"]))){
    http_response_code(422);
    echo json_encode(array("message" => "Missing parameters."));
    exit();
}
$id_game = $_GET["id_game"];
$id_player = $_SESSION["id"];
$choice_player = $_GET["choice_player"];
$id_text = "";
$objects_player = array();
$json = array();

//Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Add object in inventory according to player's choice
$stmtTestIfObject = MyPDO::getInstance()->prepare(<<<SQL
    SELECT id_objet
    FROM objets
    WHERE id_reponse = :choice_player;
SQL
    );
$stmtTestIfObject->execute(array(":choice_player" => $choice_player));
if (($row = $stmtTestIfObject->fetch()) !== false) {
    $id_object = $row["id_objet"];
    $stmtPutObjectInventory = MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO objetsrecuperes (id_partie, id_objet)
        VALUES (:id_game, :id_object);
SQL
    );
    $stmtPutObjectInventory->execute(array(":id_game" => $id_game, ":id_object" => $id_object));
}

//Recover infos player and game
$stmtInfosGame = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT id_texte, id_objet
    FROM partie p 
    LEFT OUTER JOIN objetsrecuperes o ON p.id_partie = o.id_partie 
    WHERE p.id_partie = :id_game AND p.id_joueur = :id_player
SQL
    );
$stmtInfosGame->execute(array(":id_game" => $id_game, ":id_player" => $id_player));
while (($row = $stmtInfosGame->fetch()) !== false) {
    $id_text = $row["id_texte"];
    $objects_player[] = $row["id_objet"];
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
}else{
    $in = ":id0";
    $in_params["id0"] = 0;
}

//Recover next text
$stmtNextText = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT ts.id_texte_suivant, t.contenu_texte
    FROM textesuivant ts
    LEFT OUTER JOIN reponses r ON ts.id_texte_suivant = r.id_texte_destination
    LEFT OUTER JOIN textes t ON ts.id_texte_suivant = t.id_texte
    WHERE ts.id_texte_origine = :id_text
         AND (r.id_reponse = :choice_player OR r.id_reponse IS NULL OR r.id_texte_declencheur != ts.id_texte_origine) 
         AND (ts.id_objet_necessaire IN ($in) OR ts.id_objet_necessaire IS NULL);
SQL
    );
$params = [":id_text" => $id_text, ":choice_player" => $choice_player]; 
$stmtNextText->execute(array_merge($params, $in_params)); // just merge two arrays
$movies = array();
while (($row = $stmtNextText->fetch()) !== false) {
    $id_text = $row["id_texte_suivant"];
    $json["text"]["id_text"] = $id_text;
    $json["text"]["text_content"] = $row["contenu_texte"];
}

//Recover next choices
$stmtNextChoices = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT r.id_reponse, r.contenu_reponse
    FROM reponses r
    WHERE r.id_texte_declencheur = :id_text AND (r.id_objet_necessaire IN ($in) OR r.id_objet_necessaire IS NULL);
SQL
    );
$params = [":id_text" => $id_text]; 
$stmtNextChoices->execute(array_merge($params,$in_params)); // just merge two arrays
while (($row = $stmtNextChoices->fetch()) !== false) {
    $json["choices"][] = array("id_choice" => $row["id_reponse"], "text_choice" => $row["contenu_reponse"]);
}

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>