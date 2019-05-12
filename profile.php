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
        <section id="profile">

            <div id="back">
                <span>Accueil</span>
                <a href="home.php">
                    <img src="http://placehold.it/50x50/ea0d0d/fff&text=Accueil">
                </a>
            </div>

            <section id="infos_player">
                <h2>Mes informations</h2>
                <form id="form_profile">
                    <div>
                        <label for="pseudo">Pseudo</label>
                        <input type="text" name="pseudo" minlength="4" maxlength="20">
                    </div>
                    <div>
                        <label for="pwd">Mot de passe</label>
                        <input type="password" name="pwd" minlength="6" maxlength="32">
                    </div>
                    <div>
                        <label for="planete">Planète d'origine</label>
                        <input type="text" name="planete" maxlength="20">
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
                    <div>
                        <button type="submit" class="btn">Mettre à jour mes infos</button>
                    </div>
                </form>
            </section>

            <hr>

            <section id="infos_games">
                <h2>Mes réveils</h2>
                <p><span id="nb_ends">0</span> fins sur 10</p>
                <p><span id="nb_games">0</span> réveils</p>
            </section>

            <section id="info_badges">
                <h2>Mes badges</h2>
                <div id="badges">
                    <img data-idBadge="1" src="http://placehold.it/50x50/A9A9A9/fff&text=1" alt="Petit ange parti trop tôt" title="Petit ange parti trop tôt">
                    <img data-idBadge="2" src="http://placehold.it/50x50/A9A9A9/fff&text=2" alt="Noir c'est noir" title="Noir c'est noir">
                    <img data-idBadge="3" src="http://placehold.it/50x50/A9A9A9/fff&text=3" alt="La race avant tout" title="La race avant tout">
                    <img data-idBadge="4" src="http://placehold.it/50x50/A9A9A9/fff&text=4" alt="440 Hz" title="440 Hz">
                    <img data-idBadge="5" src="http://placehold.it/50x50/A9A9A9/fff&text=5" alt="Complètement marteau" title="Complètement marteau">
                    <img data-idBadge="6" src="http://placehold.it/50x50/A9A9A9/fff&text=6" alt="Oh no." title="Oh no.">
                    <img data-idBadge="7" src="http://placehold.it/50x50/A9A9A9/fff&text=7" alt="MacGyver" title="MacGyver">
                    <img data-idBadge="8" src="http://placehold.it/50x50/A9A9A9/fff&text=8" alt="Tapez dans l'dos !" title="Tapez dans l'dos !">
                    <img data-idBadge="9" src="http://placehold.it/50x50/A9A9A9/fff&text=9" alt="Bienvenue dans la grappe" title="Bienvenue dans la grappe">
                    <img data-idBadge="10" src="http://placehold.it/50x50/A9A9A9/fff&text=10" alt="	Les Raisins de la colère" title="Les Raisins de la colère">
                    <img data-idBadge="11" src="http://placehold.it/50x50/A9A9A9/fff&text=11" alt="Caaapitaine Flam" title="Caaapitaine Flam">
                    <img data-idBadge="12" src="http://placehold.it/50x50/A9A9A9/fff&text=12" alt="Poussières d’étoiles" title="Poussières d’étoiles">
                    <img data-idBadge="13" src="http://placehold.it/50x50/A9A9A9/fff&text=13" alt="Chorémanie" title="Chorémanie">
                    <img data-idBadge="14" src="http://placehold.it/50x50/A9A9A9/fff&text=14" alt="Mon langage de requête structurée" title="Mon langage de requête structurée">
                    <img data-idBadge="15" src="http://placehold.it/50x50/A9A9A9/fff&text=15" alt="Premier degré" title="Premier degré">
                    <img data-idBadge="16" src="http://placehold.it/50x50/A9A9A9/fff&text=16" alt="Fintastique !" title="Fintastique !">
                    <img data-idBadge="17" src="http://placehold.it/50x50/A9A9A9/fff&text=17" alt="C'EST LE BOUTON ROUGE" title="C'EST LE BOUTON ROUGE">
                    <img data-idBadge="18" src="http://placehold.it/50x50/A9A9A9/fff&text=18" alt="Passion amnésie spatiale" title="Passion amnésie spatiale">
                    <img data-idBadge="19" src="http://placehold.it/50x50/A9A9A9/fff&text=19" alt="J'adore ce que vous faîtes" title="J'adore ce que vous faîtes">
                </div>
            </section>

        </section>
        <form id="popup" class="">
            <h3>Veuillez entrer votre mot de passe pour valider</h3>
            <input type="password" name="mdp" minlength="6" maxlength="32">
            <div>
                <button type="button" id="validate" class="btn">Valider</button>
                <button type="button" id="cancel" class="btn">Annuler</button>
            </div>
        </form>
        <div id="slider" class="">
            <h3 id="slider_message">Message</h3>
        </div>
    </main>

    <!-- JavaScript -->
    <script src="js/profile.js"></script>
</body>

</html>