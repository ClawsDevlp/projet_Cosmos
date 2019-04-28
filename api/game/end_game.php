<?php
/*
 *  End of a game
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
if(!isset($_GET["id_game"]) || empty($_GET["id_game"])){
    http_response_code(422);
    echo json_encode(array("message" => "Missing parameters."));
    exit();
}
$id_game = $_GET["id_game"];
$id_player = $_SESSION["id"];
$json = array();

//Include data bdd
include_once "../data/MyPDO.projet_cosmos.include.php";

//Infos game and games
$stmtInfosGamesGame = MyPDO::getInstance()->prepare(<<<SQL
    SELECT * FROM
    (SELECT COUNT(DISTINCT p.id_texte) AS "nb_ends"
    FROM partie p
        INNER JOIN textes t ON p.id_texte = t.id_texte
    WHERE p.id_joueur = :id_player AND t.nb_end IS NOT NULL
    GROUP BY p.id_joueur) e,
    (SELECT t.nb_end
    FROM partie p
    INNER JOIN textes t ON p.id_texte = t.id_texte
    WHERE p.id_partie = :id_game) f;
SQL
    );
$stmtInfosGamesGame->execute(array(":id_game" => $id_game, ":id_player" => $id_player));
if (($row = $stmtInfosGamesGame->fetch()) !== false) {
    $json["statistics"]["nb_end"] = $row["nb_end"];
    $json["statistics"]["nb_ends"] = $row["nb_ends"];
}

//Infos badges game
$stmtInfosBadgesGame = MyPDO::getInstance()->prepare(<<<SQL
    SELECT b.id_badge, b.nom_badge, b.description_badge, b.link
    FROM partie p
    INNER JOIN badgesobtenus bo ON p.id_partie = bo.id_partie
    INNER JOIN badges b ON bo.id_badge = b.id_badge
    WHERE p.id_partie = :id_game;
SQL
    );
$stmtInfosBadgesGame->execute(array(":id_game" => $id_game));
while (($row = $stmtInfosBadgesGame->fetch()) !== false) {
    $json["badges"][] = array("id_badge" => $row["id_badge"], "name_badge" => $row["nom_badge"], "description_badge" => $row["description_badge"], "link" => $row["link"]);
}

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>