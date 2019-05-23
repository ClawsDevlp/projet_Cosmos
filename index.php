<?php
    session_start();
    if (isset($_SESSION["id"])){ //Player is connected
        header("Location: home.php");
    }
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
    <title>Projet Cosmos · Bienvenue</title>

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
        <section id="menu">
           
            <div id="back" class="hide">
                <span>Retour</span>
                <a href="">
                    <img src="http://placehold.it/50x50/ea0d0d/fff&text=Retour">
                </a>
            </div>

            <div id="menu_visual">
                <img src="./images/Visuel_01_01.jpg" alt="visuel 1" />
            </div>

            <div id="menu_text">
                <h1>Projet Cosmos</h1>

                <section id="menu_connection">
                    <h2>Embarquer dans ma navette</h2>
                    <form id="form_connection">
                        <div>
                            <label for="pseudo">Pseudo</label>
                            <input type="text" name="pseudo" placeholder="Pseudo" required>
                        </div>
                        <div>
                            <label for="pwd">Mot de passe</label>
                            <input type="password" name="pwd" placeholder="Mot de passe" required>
                        </div>
                        <div>
                            <button type="submit" class="btn">Me connecter</button>
                        </div>
                    </form>
                    <hr>
                    <h2>Postuler pour la mission</h2>
                    <div>
                        <button type="button" class="btn" id="go_registration">M'inscrire</button>
                    </div>
                </section>

                <section id="menu_registration" class="hide">
                    <form id="form_registration">
                        <div>
                            <label for="pseudo">Pseudo*</label>
                            <input type="text" name="pseudo" minlength="4" maxlength="20" required>
                        </div>
                        <div>
                            <label for="pwd">Mot de passe*</label>
                            <input type="password" name="pwd" minlength="6" maxlength="32" required>
                        </div>
                        <div>
                            <label for="planete">Planète d'origine</label>
                            <input type="text" name="planete" maxlength="20" value="Terre">
                        </div>
                        <div class="avatar_choice">
                            <p>Avatar</p>
                            <label>
                                <input type="radio" name="avatar" value="1" checked>
                                <img src="images/avatars/avatar_1.jpg">
                            </label>
                            <label>
                                <input type="radio" name="avatar" value="2">
                                <img src="images/avatars/avatar_2.jpg">
                            </label>
                            <label>
                                <input type="radio" name="avatar" value="3">
                                <img src="images/avatars/avatar_3.jpg">
                            </label>
                            <label>
                                <input type="radio" name="avatar" value="4">
                                <img src="images/avatars/avatar_4.jpg">
                            </label>
                        </div>
                        <div class="cgu_accept">
                            <input type="checkbox" name="cgu" required>
                            <label for="cgu">J'accepte les <a id="cgu_link" href="">Conditions Générales d'Utilisation</a>*</label>
                        </div>
                        <div>
                            <button type="submit" class="btn">Créer mon compte</button>
                        </div>
                    </form>
                </section>
            </div>

        </section>

        <div id="popup_bg" class="hide">
            <form id="popup" class="popup_animation">
                <object data="cgu.html" type="text/html"></object>
                <div>
                    <button type="button" id="return" class="btn">Retour</button>
                </div>
            </form>
        </div>

        <div id="slider">
            <p id="slider_message"></p>
        </div>
    </main>

    <!-- JavaScript -->
    <script src="js/menu.js"></script>
</body>

</html>