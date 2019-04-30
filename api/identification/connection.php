<?php
/*
 *  Connect a player
 */

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
if(!isset($_GET["pseudo"]) || empty($_GET["pseudo"])){
    http_response_code(422);
    echo json_encode(array("message" => "Missing pseudo."));
    exit();
}
if(!isset($_GET["pwd"]) || empty($_GET["pwd"])){
    http_response_code(422);
    echo json_encode(array("message" => "Missing password."));
    exit();
}
$pseudo = $_GET["pseudo"];
$pwd = $_GET["pwd"];

//Include data bdd
 include_once "../data/MyPDO.projet_cosmos.include.php";

//Check infos connection player
$stmtCheckPlayer = MyPDO::getInstance()->prepare(<<<SQL
    SELECT * 
    FROM joueur 
    WHERE pseudo = :pseudo AND mdp = :pwd;
SQL
);
$stmtCheckPlayer->execute(array(":pseudo" => $pseudo, ":pwd" => md5($pwd)));
if(($row = $stmtCheckPlayer->fetch()) == false) {
    http_response_code(422);
    echo json_encode(array("message" => "Pseudo or password incorrect."));
    exit();
}

//Connection
session_start();
$_SESSION["id"] = $row["id_joueur"];
$_SESSION["pseudo"] = $row["pseudo"];
$_SESSION["mail"] = $row["mail"];

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));

exit();

?>