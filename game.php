<?php
    session_start();
    if (!(isset($_SESSION["id"]))){ //Player is not connected
        header("Location: index.php");
    }
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
    <title>Projet Cosmos · Jeu</title>
    
    <!-- Open Graph Data -->
    <meta property="og:title" content="Projet Cosmos · Jeu" />
    <meta property="og:description" content="Projet Cosmos : fiction intéractive se déroulant dans l'espace" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://perso-etudiant.u-pem.fr/~cdaigmor/projetPHP/" />
    <meta property="og:image" content="images/Visuel_site.jpg" />

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet Cosmos : fiction intéractive se déroulant dans l'espace" />
    <meta name="keywords" content="fiction, intéractive, interactive, aventure, adventure, textuel, textual, text, jeu, game, choix, choice, espace, space, amnésie, amnesia">

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=VT323" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />

    <!--Favicon-->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
</head>

<body>
    <main>

        <div id="back">
            <a href="home.php">
                <span>Accueil</span>
                <div class="home_back"></div>
            </a>
        </div>

        <section id="game">

            <div id="game_story">
                <p id="text"></p>
                <div id="game_badges" class="hide">
                    <p>Badges obtenus :</p>
                    <div id="badges">
                    </div>
                </div>
            </div>

            <div id="game_choice">
                <button type="button" class="btn hide"></button>
                <button type="button" class="btn hide"></button>
                <button type="button" class="btn hide"></button>
                <button type="button" class="btn hide"></button>
            </div>

            <div id="inventory">
            </div>

        </section>

        <div id="musicFx">
            <img id="music_img" src="images/Logo_Music.png" alt="Bouton musique">
            <img id="fx_img" src="images/Logo_FX.png" alt="Bouton FX">
            <audio id="music" autoplay="true" src="sounds/ambiant_01.mp3" loop="true" controls hidden></audio>
            <audio id="fx" src="sounds/button_sound_01.mp3" controls hidden></audio>
        </div>

        <div id="popup_badge_bg" class="hide">
            <div id="popup_badge" class="popup_animation">
                <a id="button_popup_badge">x</a>
                <p id="title_popup_badge"></p>
                <img id="img_popup_badge">
                <p id="description_popup_badge"></p>
            </div>
        </div>

    </main>

    <!-- JavaScript -->
    <script src="js/game.js"></script>
</body>

</html>