<?php session_start(); 

    include_once "../data/MyPDO.projet-php-dictature.include.php";
    
    $_SESSION = array();
    session_destroy();
    
    header('Location:../index.php');

?>