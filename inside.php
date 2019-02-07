<?php

ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);
if ($_COOKIE['token'] !== '47') exit ('авторизуйтесь');

$db = mysqli_connect('localhost', 'root', '', 'baza1');

$query = "SELECT login FROM `users`";
$result = mysqli_query($db, $query) or exit ('query failed');
while (list ($login) = mysqli_fetch_row($result)) $logins[] = $login;
echo json_encode($logins);


?>
