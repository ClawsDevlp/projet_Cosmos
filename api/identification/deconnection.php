<?php
/*
 *  Deconnect a player
 */

session_start(); 

//Headers
header("Content-Type: application/json; charset=UTF-8");

//Check HTTP method
$method = strtolower($_SERVER["REQUEST_METHOD"]);
if($method !== "get") {
    http_response_code(405);
    echo json_encode(array("message" => "This method is not allowed."));
    exit();
}

//Deconnection
$_SESSION = array();
session_destroy();

//Response
http_response_code(200);
echo json_encode(array("message" => "Done."));

exit();

?>