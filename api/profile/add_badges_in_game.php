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

//Check params
$data = json_decode(file_get_contents("php://input"), true);
if(!isset($data["id_game"]) || empty($data["id_game"])){
    http_response_code(422);
    echo json_encode(array("message" => "Missing parameters."));
    exit();
}
$id_game = $data["id_game"];
$id_player = $_SESSION["id"];

// Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Create a new game
$stmtCheckBadges = MyPDO::getInstance()->prepare(<<<SQL
    SELECT DISTINCT b.id_badge
    FROM partie p
    INNER JOIN badges b ON p.id_texte = b.id_texte
        LEFT OUTER JOIN badgesobtenus bo ON b.id_badge = bo.id_badge
    WHERE bo.id_badge IS NULL AND p.id_joueur = :id_player AND p.id_partie = :id_game AND p.id_texte = b.id_texte;
SQL
    );
$stmtCheckBadges->execute(array(":id_player" => $id_player, ":id_game" => $id_game));
while (($row = $stmtCheckBadges->fetch()) !== false) {
    $id_badge = $row["id_badge"];
    $stmtAddBadge = MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO badgesobtenus 
        VALUES (:id_player, :id_badge, :id_partie);
SQL
    );
    $stmtAddBadge->execute(array(":id_player" => $id_player, ":id_badge" => $id_badge, ":id_partie" => $id_game));
}

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));

exit();

?>