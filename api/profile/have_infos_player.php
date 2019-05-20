<?php
/*
 *  Have infos player
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

//Params
$id_player = $_SESSION["id"];

// Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Avatar player
$stmtInfosPlayer = MyPDO::getInstance()->prepare(<<<SQL
    SELECT j.pseudo, j.id_avatar, a.link
    FROM joueur j
    INNER JOIN avatar a ON j.id_avatar = a.id_avatar
    WHERE j.id_joueur = :id_player;
SQL
    );
$stmtInfosPlayer->execute(array(":id_player" => $id_player));
while (($row = $stmtInfosPlayer->fetch()) !== false) {
    $json["pseudo"] = $row["pseudo"];
    $json["id_avatar"] = $row["id_avatar"];
    $json["link"] = $row["link"];
}

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>