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
    <title>Projet Cosmos · Accueil</title>

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
        <section id="home">

            <div id="home_profile">
                <a href="profile.php">
                    <img id="avatar" src="" alt="Image avatar">
                </a>
                <span><?php echo $_SESSION["pseudo"] ?></span>
                <img id="log_out" src="css/images/log_out.svg">
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

        <div id="popup_bg">
            <form id="popup" class="">
                <h3>Souhaitez-vous reprendre votre aventure là où vous vous étiez arrêté.e ?</h3>
                <div>
                    <button type="button" id="validate" class="btn">Oui</button>
                    <button type="button" id="cancel" class="btn">Non</button>
                </div>
            </form>
        </div>

    </main>

    <!-- JavaScript -->
    <script src="js/home.js"></script>
</body>

</html>