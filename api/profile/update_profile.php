<?php
/*
 *  Register a player
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
if((!isset($data["pseudo"]) || empty($data["pseudo"])) && 
   (!isset($data["planete"]) || empty($data["planete"])) && 
   (!isset($data["pwd"]) || empty($data["pwd"])) || 
   (!isset($data["avatar"]) || empty($data["avatar"]))){
    http_response_code(422);
    echo json_encode(array("message" => "Missing parameters."));
    exit();
}
$pseudo = (isset($data["pseudo"])) ? $data["pseudo"] : NULL;
$planete = (isset($data["planete"])) ? $data["planete"] : NULL;
$pwd = (isset($data["pwd"])) ? $data["pwd"] : NULL;
$id_avatar = $data["avatar"];
$id_player = $_SESSION["id"];

if(!isset($data["currentPwd"]) || empty($data["currentPwd"])){
    http_response_code(422);
    echo json_encode(array("message" => "Missing password."));
    exit();
}
$currentPwd = $data["currentPwd"];


//Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Check current pwd
$stmtCheckPlayer = MyPDO::getInstance()->prepare(<<<SQL
    SELECT * 
    FROM joueur 
    WHERE id_joueur = :id_player AND mdp = :currentPwd;
SQL
);
$stmtCheckPlayer->execute(array(":id_player" => $id_player, ":currentPwd" => md5($currentPwd)));
if(($row = $stmtCheckPlayer->fetch()) == false) {
    http_response_code(422);
    echo json_encode(array("message" => "Password incorrect."));
    exit();
}

//Change pseudo
if($pseudo){
    $stmtCheckPseudo = MyPDO::getInstance()->prepare(<<<SQL
        UPDATE joueur
        SET pseudo = :pseudo
        WHERE id_joueur = :id_player;
SQL
);
$stmtCheckPseudo->execute(array(":pseudo" => $pseudo, ":id_player" => $id_player));
}

//Change planete origine
if($planete){
    $stmtCheckPseudo = MyPDO::getInstance()->prepare(<<<SQL
        UPDATE joueur
        SET planete_origine = :planete
        WHERE id_joueur = :id_player;
SQL
);
$stmtCheckPseudo->execute(array(":planete" => $planete, ":id_player" => $id_player));
}

//Change pwd
if($pwd){
    $stmtCheckPseudo = MyPDO::getInstance()->prepare(<<<SQL
        UPDATE joueur
        SET mdp = :pwd
        WHERE id_joueur = :id_player;
SQL
);
$stmtCheckPseudo->execute(array(":pwd" => md5($pwd), ":id_player" => $id_player));
}

//Change avatar
$stmtCheckPseudo = MyPDO::getInstance()->prepare(<<<SQL
    UPDATE joueur
    SET id_avatar = :id_avatar
    WHERE id_joueur = :id_player;
SQL
);
$stmtCheckPseudo->execute(array(":id_avatar" => $id_avatar, ":id_player" => $id_player));

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));
exit();

?>