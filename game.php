<?php
    session_start();
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
            <audio id="music" autoplay="true" src="sounds/ambiant_01.mp3" loop="true" controls hidden></audio>
            <audio id="button_sound" src="sounds/button_sound_01.mp3" controls hidden></audio>
			
            <div id="back">
                <span>Accueil</span>
                <a href="home.php">
                    <img src="http://placehold.it/50x50/ea0d0d/fff&text=Accueil">
                </a>
            </div>
			
            <div id="game_story">
                <p id="text"></p>
                <div id="game_badges" class="hide">
                    <p>Badges obtenus :</p>
                    <div id="badges">
                    </div>
                </div>
            </div>

            <div id="game_choice">
                <button data-idChoice="0" type="button" class="btn"></button>
                <button type="button" class="btn"></button>
                <button type="button" class="btn"></button>
                <button type="button" class="btn"></button>
            </div>

            <div id="inventory">
            </div>
			
        </section>
		
        <div id="music_button"><img id="music_img" src="images/Logo_Music.png" alt="Bouton musique"></div>
        <div id="fx_button"><img id="fx_img" src="images/Logo_FX.png" alt="Bouton FX"></div>

		<div id="popup_badge">
			<div id="contenu_popup"></div>
			<div id="img_popup"></div>
			<a id="pop_button" style="display:block;">x</a>
		</div>
   
    </main>

    <!-- JavaScript -->
    <script src="js/game.js"></script>
</body>

</html>