<?php
/*
 *  Connect a player
 */

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Check HTTP method
$method = strtolower($_SERVER["REQUEST_METHOD"]);
if($method !== "post") {
    http_response_code(405);
    echo json_encode(array("message" => "This method is not allowed."));
    exit();
}

//Check params
$data = json_decode(file_get_contents("php://input"), true);
if(!isset($data["pseudo"]) || empty($data["pseudo"])){
    http_response_code(422);
    echo json_encode(array("message" => "Missing pseudo."));
    exit();
}
if(!isset($data["pwd"]) || empty($data["pwd"])){
    http_response_code(422);
    echo json_encode(array("message" => "Missing password."));
    exit();
}
$pseudo = $data["pseudo"];
$pwd = $data["pwd"];

//Include data bdd
 include_once "../data/MyPDO.projet_cosmos_2.include.php";

//Check infos connection player
$stmtCheckPlayer = $db->prepare(<<<SQL
    SELECT * 
    FROM Joueur 
    WHERE pseudo = :pseudo AND mdp = :pwd;
SQL
);
$stmtCheckPlayer->execute(array(":pseudo" => $pseudo, ":pwd" => md5($pwd)));
if(($row = $stmtCheckPlayer->fetch()) == false) {
    http_response_code(422);
    echo json_encode(array("message" => "Pseudo or password incorrect."));
    exit();
}

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));

//Connection
session_start();
$_SESSION["id"] = $row["id_joueur"];
$_SESSION["pseudo"] = $row["pseudo"];
$_SESSION["mail"] = $row["mail"];

exit();

?>