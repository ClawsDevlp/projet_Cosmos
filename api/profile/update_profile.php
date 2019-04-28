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
if((!isset($data["pseudo"]) || empty($data["pseudo"])) && (!isset($data["mail"]) || empty($data["mail"])) && (!isset($data["pwd"]) || empty($data["pwd"])) || (!isset($data["avatar"]) || empty($data["avatar"]))){
    http_response_code(422);
    echo json_encode(array("message" => "Missing parameters."));
    exit();
}
$pseudo = (isset($data["pseudo"])) ? $data["pseudo"] : NULL;
$mail = (isset($data["mail"])) ? $data["mail"] : NULL;
$pwd = (isset($data["pwd"])) ? $data["pwd"] : NULL;
$id_avatar = $data["avatar"];
$id_player = $_SESSION["id"];

//Include data bdd
 include_once "../data/MyPDO.projet_cosmos_2.include.php";

//Change pseudo
if($pseudo){
    $stmtCheckPseudo = $db->prepare(<<<SQL
        UPDATE joueur
        SET pseudo = :pseudo
        WHERE id_joueur = :id_player;
SQL
);
$stmtCheckPseudo->execute(array(":pseudo" => $pseudo, ":id_player" => $id_player));
}

//Change mail
if($mail){
    $stmtCheckPseudo = $db->prepare(<<<SQL
        UPDATE joueur
        SET mail = :mail
        WHERE id_joueur = :id_player;
SQL
);
$stmtCheckPseudo->execute(array(":mail" => $mail, ":id_player" => $id_player));
}

//Change pwd
if($pseudo){
    $stmtCheckPseudo = $db->prepare(<<<SQL
        UPDATE joueur
        SET mdp = :pwd
        WHERE id_joueur = :id_player;
SQL
);
$stmtCheckPseudo->execute(array(":pwd" => md5($pwd), ":id_player" => $id_player));
}

//Change avatar
$stmtCheckPseudo = $db->prepare(<<<SQL
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