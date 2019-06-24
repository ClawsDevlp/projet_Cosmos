<?php
    session_start();
    if (!(isset($_SESSION["id"]))){ //Player is not connected
        header("Location: index.php");
    }
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
    <title>Projet Cosmos · Accueil</title>
    
    <!-- Open Graph Data -->
    <meta property="og:title" content="Projet Cosmos · Accueil" />
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
        <section id="home" class="hide">

            <div id="home_profile">
                <a href="profile.php">
                    <img id="avatar" src="" alt="Image avatar">
                </a>
                <span id="pseudo"></span>
                <a id="log_out"></a>
            </div>

            <div id="home_visual">
                <h1>Projet Cosmos</h1>
                <img src="./images/Visuel_02.jpg" alt="visuel 2" />
            </div>

            <div id="home_choice">
                <button id="start_game" type="button" class="btn">Me réveiller</button>
                <button id="go_profile" type="button" class="btn">Consulter mon profil</button>
            </div>

        </section>

        <div id="popup_bg" class="hide">
            <form id="popup" class="popup_animation">
                <p>Souhaitez-vous reprendre votre aventure là où vous vous étiez arrêté.e ?</p>
                <div>
                    <button type="button" id="validate" class="btn">Oui</button>
                    <button type="button" id="validate_no" class="btn">Non</button>
                    <button type="button" id="cancel" class="btn">Annuler</button>
                </div>
            </form>
        </div>

        <div id="slider">
            <p id="slider_message"></p>
        </div>

    </main>

    <!-- JavaScript -->
    <script src="js/home.js"></script>
</body>

</html>