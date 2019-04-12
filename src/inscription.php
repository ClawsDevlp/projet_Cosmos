<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Incription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>

<body>
    <?php // Ci-dessous s'affiche si le joueur est connecté
        if (isset($_SESSION["id"])){
            echo "Coucou ! Tu es déjà connecté.e, tu ne peux pas te ré-inscrire petit chenapan !";
            echo "<br/><a href=\"deconnexion.php\"> Deconnexion </a>";
        
        } else { // Le joueur est non-connecté
    ?>

        <h1> Création du compte </h1>
        <form id="form-inscription">
            <label for="pseudo">Pseudo : </label>
            <input type="text" name="pseudo" id="pseudo"><br/>

            <label for="mail">Email : </label>
            <i>Le mail sert à récupperer ton mot de passe si jamais tu le perds, 
            il n'est en rien obligatoire</i>
            <input type="email" name="mail" id="mail"><br/>

            <label for="mdp">Mot de passe : </label>
            <input type="password" name="mdp" id="mdp"><br/>

            <button id="inscription-send">boom</button>
        </form>
    
    <?php
        }
    ?>

    <br/><br/><a href="../index.php"> Retour accueil </a>
    
	<script src="../js/inscription_form.js"></script>
</body>
</html>