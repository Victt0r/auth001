<?php

ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$db = mysqli_connect('localhost', 'root', '', 'baza1');
require "tokenCheck.php";
$token = tokenCheck($db);

$query = "SELECT login FROM `users`";
$result = mysqli_query($db, $query) or exit ('query failed');
while (list ($login) = mysqli_fetch_row($result)) $logins[] = $login;

$response = array ('token'=>$token, 'logins'=>$logins);
echo json_encode($response);

?>
