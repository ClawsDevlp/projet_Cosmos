<?php
    include_once "../data/MyPDO.projet-php-dictature.include.php";

    $prep = $db->prepare("SELECT * FROM joueur WHERE pseudo = :pseudo");
    $prep->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);

    var_dump($_POST);
    if($prep->execute() == 0){
        // mauvais login
        header('Location:../index.php?err=1');
        
    } else {
        
        $res = $prep->fetch(PDO::FETCH_ASSOC);
        
        if(md5($_POST['mdp']) != $res["mdp"]){
            // mauvaix mdp
            header('Location:../index.php?err=1');
            echo md5($_POST['mdp']);
            echo "<br/>";
            echo $res;
        } else {

            echo "Vous êtes bien connecté <br>";
            session_start();
            $_SESSION["id"] = $res["id"];
            $_SESSION["pseudo"] = $res["pseudo"];
            $_SESSION["mail"] = $res["mail"];

            header('Location:../partie_home.php');
        }
    }
?>