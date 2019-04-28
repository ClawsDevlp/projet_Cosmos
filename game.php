<?php
    session_start();
    include_once "api/data/MyPDO.projet_cosmos_2.include.php";
    if (!(isset($_SESSION["id"]))){ //Player is not connected
        header("Location: index.php");
    }
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
    <!--<link rel="shortcut icon" href="" />-->
    <title>Projet Cosmos · Jeu</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet Cosmos : fiction intéractive se déroulant dans l'espace" />
    <meta name="keywords" content="fiction, intéractive, interactive, aventure, adventure, textuel, textual, text, jeu, game, choix, choice, espace, space, amnésie, amnesia">

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=VT323" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>

<body>
    <main>
        <section id="game">

            <div id="back_menu">
                <span>Menu</span>
                <a href="home.php">
                    <img src="http://placehold.it/50x50/ea0d0d/fff&text=Menu">
                </a>
            </div>

            <div id="game_story">
                <p id="text"></p>
                <div id="game_badges" class="hide">
                    <p>Badges obtenus :</p>
                </div>
            </div>

            <div id="game_choice">
                <button data-idChoice="0" type="button" class="btn"></button>
                <button type="button" class="btn"></button>
                <button type="button" class="btn"></button>
                <button type="button" class="btn"></button>
            </div>

        </section>
    </main>

    <!-- JavaScript -->
    <script src="js/game.js"></script>
</body>

</html>