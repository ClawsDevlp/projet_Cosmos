<?php
/*
 *  Update a game
 */

session_start();

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Check HTTP method
$method = strtolower($_SERVER["REQUEST_METHOD"]);
if($method !== "put") {
    http_response_code(405);
    echo json_encode(array("message" => "This method is not allowed."));
    exit();
}

//Check params
$data = json_decode(file_get_contents("php://input"), true);
if((!isset($data["id_text"]) || empty($data["id_text"])) 
   && (!isset($data["id_game"]) || empty($data["id_game"]))){
    http_response_code(422);
    echo json_encode(array("message" => "Missing parameters."));
    exit();
}
$id_text = $data["id_text"];
$id_game = $data["id_game"];
$id_player = $_SESSION["id"];

//Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Update a game
$stmtUpdateGame = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE partie
    SET id_texte = :id_text
    WHERE id_partie = :id_game AND id_joueur = :id_player;
SQL
    );
$stmtUpdateGame->execute(array(":id_text" => $id_text, ":id_game" => $id_game, ":id_player" => $id_player));

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));

exit();

?>