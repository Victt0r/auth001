<?php
ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$db = mysqli_connect('localhost', 'root', '', 'baza1');
require "tokenCheck.php";
$token = tokenCheck($db);

$response = array ('token'=>$token);
echo json_encode($response);

?>
