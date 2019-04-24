<?php
    session_start();
    include_once "./data/MyPDO.projet-php-dictature.include.php";
?>

    <h1> Bienvenue sur le JEU </h1>

<?php // Le joueur est connecté
    if (isset($_SESSION["id"])){
?>
    <a href="party_home.php"> Commence une partie !</a><br/>
    <a href="src/deconnexion.php">Deconnexion</a>

<?php
    } else { // Le joueur est non-connecté
?> 

    <h2> Connexion </h2>
    <form action="src/connexion_back.php" method="POST" id="form-connexion">
        <?php if(isset($_GET["err"])){echo 'erreur identifiants <br>';} ?>
        <label for="pseudo">Pseudo : </label>
        <input type="text" name="pseudo" id="pseudo"><br/>

        <label for="mdp">Mot de passe : </label>
        <input type="password" name="mdp" id="mdp"><br/>

        <input type="submit">
    </form>

    <a href="src/inscription.php">Inscription</a>
    
<?php
    }
?>