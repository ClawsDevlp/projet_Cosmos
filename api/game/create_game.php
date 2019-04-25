<?php
/*
 *  Create a game
 */

session_start();

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Check HTTP method
$method = strtolower($_SERVER["REQUEST_METHOD"]);
if($method !== "post") {
    http_response_code(405);
    echo json_encode(array("message" => "This method is not allowed."));
    exit();
}

//Params
$id_player = $_SESSION["id"];

// Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Create a new game
$stmtInfosGame = MyPDO::getInstance()->prepare(<<<SQL
    INSERT INTO partie (id_texte, id_joueur)
    VALUES (1, :id_player);
SQL
    );
$stmtInfosGame->execute(array(":id_player" => $id_player));

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));

exit();

?>