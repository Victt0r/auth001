<?php

ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$db = mysqli_connect('localhost', 'root', '', 'baza1');
require "tokenCheck.php";
$token = tokenCheck($db);

$query = "SELECT COUNT(id) FROM `users` WHERE LENGTH(passhash) > 32";
$result = mysqli_query($db, $query) or exit ('query failed');
list ($number) = mysqli_fetch_row($result);

$response = array ('token'=>$token, 'number'=>$number);
echo json_encode($response);

?>
