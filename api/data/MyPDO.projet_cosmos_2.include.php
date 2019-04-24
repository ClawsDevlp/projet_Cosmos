<?php

	require_once "MyPDO.class.php";

	if (isset($_SERVER["HTTP_ORIGIN'"])) {
		header("Access-Control-Allow-Origin: {$_SERVER["HTTP_ORIGIN"]}");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 86400"); // Cache for 1 day
	}

	// Access-Control headers are received during OPTIONS requests
	if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
		if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
		if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
			header("Access-Control-Allow-Headers {$_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]}");
		exit(0);  
	}

	try { 
		$db = new PDO("mysql:host=localhost;dbname=projet_cosmos;charset=utf8", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	} 

	catch(PDOException $e){ echo($e->getMessage()); }

?>
