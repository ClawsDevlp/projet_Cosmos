<?php 
/*
 *  Deconnect a player
 */

session_start(); 

//Include data bdd
include_once "../data/MyPDO.projet_cosmos_2.include.php";

//Deconnection
$_SESSION = array();
session_destroy();
header("Location: ../../index.php");

?>