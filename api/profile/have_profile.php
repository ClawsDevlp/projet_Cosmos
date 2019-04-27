<?php
/*
 *  Create a game
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

//Infos player
$stmtInfosPlayer = MyPDO::getInstance()->prepare(<<<SQL
    SELECT j.pseudo, j.mail, j.id_avatar
    FROM joueur j
    WHERE j.id_joueur = :id_player;
SQL
    );
$stmtInfosPlayer->execute(array(":id_player" => $id_player));
while (($row = $stmtInfosPlayer->fetch()) !== false) {
    $json["player"]["pseudo"] = $row["pseudo"];
    $json["player"]["mail"] = $row["mail"];
    $json["player"]["id_avatar"] = $row["id_avatar"];
}

//Infos games
$stmtInfosGames = MyPDO::getInstance()->prepare(<<<SQL
    SELECT * FROM
    (SELECT COUNT(DISTINCT p.id_texte) AS "nb_ends"
    FROM partie p
        INNER JOIN textes t ON p.id_texte = t.id_texte
    WHERE p.id_joueur = :id_player AND t.id_type = 2
    GROUP BY p.id_joueur) e,
    (SELECT COUNT(p.id_partie) AS "nb_games"
    FROM partie p
    WHERE p.id_joueur = :id_player
    GROUP BY p.id_joueur) g
SQL
    );
$stmtInfosGames->execute(array(":id_player" => $id_player));
while (($row = $stmtInfosGames->fetch()) !== false) {
    $json["statistics"]["nb_ends"] = $row["nb_ends"];
    $json["statistics"]["nb_games"] = $row["nb_games"];
}

//Infos badges
$stmtInfosBadges = MyPDO::getInstance()->prepare(<<<SQL
    SELECT b.id_badge, b.nom_badge, b.description_badge, b.link
    FROM badgesobtenus bo 
    INNER JOIN badges b ON bo.id_badge = b.id_badge
    WHERE bo.id_joueur = :id_player
SQL
    );
$stmtInfosBadges->execute(array(":id_player" => $id_player));
while (($row = $stmtInfosBadges->fetch()) !== false) {
    $json["badges"][] = array("id_badge" => $row["id_badge"], "name_badge" => $row["nom_badge"], "description_badge" => $row["description_badge"], "link" => $row["link"]);
}

//Response
http_response_code(200);
echo json_encode($json);

exit();

?>