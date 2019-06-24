<?php
    session_start();
    if (!(isset($_SESSION["id"]))){ //Player is not connected
        header("Location: index.php");
    }
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
    <title>Projet Cosmos · Profil</title>
    
    <!-- Open Graph Data -->
    <meta property="og:title" content="Projet Cosmos · Profil" />
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
        <section id="profile" class="hide">

            <div id="back">
                <a href="home.php">
                    <span>Accueil</span>
                    <div class="home_back"></div>
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
                        <label for="planete">Planète d'origine</label>
                        <input type="text" name="planete" maxlength="20">
                    </div>
                    <div>
                        <label for="pwd">Nouveau mot de passe</label>
                        <input type="password" name="pwd" minlength="6" maxlength="32">
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
                    <a class="badge_infobulle">
                        <img data-idBadge="1" src="images/badges/locked.jpg" alt="Petit ange parti trop tôt" class="infobulle">
                        <span>Petit ange parti trop tôt</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="2" src="images/badges/locked.jpg" alt="Noir c'est noir">
                        <span>Noir c'est noir</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="3" src="images/badges/locked.jpg" alt="La race avant tout">
                        <span>La race avant tout</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="4" src="images/badges/locked.jpg" alt="440 Hz">
                        <span>440 Hz</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="5" src="images/badges/locked.jpg" alt="Complètement marteau">
                        <span>Complètement marteau</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="6" src="images/badges/locked.jpg" alt="Oh no.">
                        <span>Oh no.</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="7" src="images/badges/locked.jpg" alt="MacGyver">
                        <span>MacGyver</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="8" src="images/badges/locked.jpg" alt="Tapez dans l'dos !">
                        <span>Tapez dans l'dos !</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="9" src="images/badges/locked.jpg" alt="Bienvenue dans la grappe">
                        <span>Bienvenue dans la grappe</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="10" src="images/badges/locked.jpg" alt="	Les Raisins de la colère">
                        <span>Les Raisins de la colère</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="11" src="images/badges/locked.jpg" alt="Caaapitaine Flam">
                        <span>Caaapitaine Flam"</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="12" src="images/badges/locked.jpg" alt="Poussières d’étoiles">
                        <span>Poussières d’étoiles</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="13" src="images/badges/locked.jpg" alt="Chorémanie">
                        <span>Chorémanie</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="14" src="images/badges/locked.jpg" alt="Mon langage de requête structurée">
                        <span>Mon langage de requête structurée</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="15" src="images/badges/locked.jpg" alt="Premier degré">
                        <span>Premier degré</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="16" src="images/badges/locked.jpg" alt="Fintastique !">
                        <span>Fintastique !</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="17" src="images/badges/locked.jpg" alt="C'EST LE BOUTON ROUGE">
                        <span>C'EST LE BOUTON ROUGE</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="18" src="images/badges/locked.jpg" alt="Passion amnésie spatiale">
                        <span>Passion amnésie spatiale</span>
                    </a>
                    <a class="badge_infobulle">
                        <img data-idBadge="19" src="images/badges/locked.jpg" alt="J'adore ce que vous faîtes">
                        <span>J'adore ce que vous faîtes</span>
                    </a>
                </div>
            </section>

        </section>

        <div id="popup_bg" class="hide">
            <form id="popup" class="popup_animation">
                <p>Entrez votre mot de passe pour valider :</p>
                <input id="update_profile_pwd" type="password" name="pwd" minlength="6" maxlength="32" required autofocus>
                <div>
                    <button type="submit" id="validate" class="btn">Valider</button>
                    <button type="button" id="cancel" class="btn">Annuler</button>
                </div>
            </form>
        </div>

        <div id="slider">
            <p id="slider_message"></p>
        </div>
    </main>

    <!-- JavaScript -->
    <script src="js/profile.js"></script>
</body>

</html>