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
$json = array();

// Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Recover infos player and game
$stmtInfosGame = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT p.id_partie, p.id_texte, t.nb_end
    FROM partie p
    INNER JOIN textes t ON p.id_texte = t.id_texte
    WHERE p.date_texte = (SELECT MAX(p.date_texte) FROM partie p WHERE p.id_joueur = :id_player);
SQL
    );
$stmtInfosGame->execute(array(":id_player" => $id_player));
while (($row = $stmtInfosGame->fetch()) !== false) {
    $json["id_game"] = $row["id_partie"];
    $json["text"]["id_text"] =  $row["id_texte"];
    $json["text"]["nb_end"] = $row["nb_end"];
}

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>