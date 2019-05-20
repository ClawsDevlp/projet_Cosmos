<?php
/*
 *  Add badges
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
$stmtCheckBadges = MyPDO::getInstance()->prepare(<<<SQL
    SELECT b.id_badge
    FROM badges b
    WHERE b.id_badge =
        (SELECT DISTINCT b.id_badge
        FROM partie p LEFT OUTER JOIN textes t ON p.id_texte = t.id_texte,
            badges b LEFT OUTER JOIN badgesobtenus bo ON b.id_badge = bo.id_badge
        WHERE p.id_joueur = :id_player AND b.id_badge = 16 AND bo.id_joueur IS NULL AND t.nb_end IS NOT NULL
        GROUP BY p.id_joueur
        HAVING COUNT(DISTINCT p.id_texte) >= 10)
    OR b.id_badge =
        (SELECT DISTINCT b.id_badge
        FROM partie p, 
            badges b LEFT OUTER JOIN badgesobtenus bo ON b.id_badge = bo.id_badge
        WHERE p.id_joueur = :id_player AND b.id_badge = 17 AND bo.id_joueur IS NULL AND p.id_texte = 6
        GROUP BY p.id_joueur
        HAVING COUNT(p.id_partie) >= 10)
    OR b.id_badge =
        (SELECT DISTINCT b.id_badge
        FROM partie p, 
            badges b LEFT OUTER JOIN badgesobtenus bo ON b.id_badge = bo.id_badge
        WHERE p.id_joueur = :id_player AND b.id_badge = 18 AND bo.id_joueur IS NULL
        GROUP BY p.id_joueur
        HAVING COUNT(p.id_partie) >= 30)
    OR b.id_badge =
        (SELECT DISTINCT b.id_badge
        FROM partie p, 
            badges b LEFT OUTER JOIN badgesobtenus bo ON b.id_badge = bo.id_badge
        WHERE p.id_joueur = :id_player AND b.id_badge = 19 AND bo.id_joueur IS NULL AND (SELECT COUNT(bo.id_badge) FROM badgesobtenus bo WHERE bo.id_joueur = :id_player GROUP BY bo.id_joueur) >= 18
        GROUP BY p.id_joueur)
    OR b.id_badge =
        (SELECT DISTINCT b.id_badge
        FROM joueur j, 
            badges b LEFT OUTER JOIN badgesobtenus bo ON b.id_badge = bo.id_badge
        WHERE j.id_joueur = :id_player AND b.id_badge = 20 AND bo.id_joueur IS NULL AND LOWER(j.pseudo) LIKE "%pascale%")
    ;
SQL
    );
$stmtCheckBadges->execute(array(":id_player" => $id_player));
while (($row = $stmtCheckBadges->fetch()) !== false) {
    $id_badge = $row["id_badge"];
    $stmtAddBadge = MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO badgesobtenus (id_joueur, id_badge)
        VALUES (:id_player, :id_badge);
SQL
    );
    $stmtAddBadge->execute(array(":id_player" => $id_player, ":id_badge" => $id_badge));
}

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));

exit();

?>