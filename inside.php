<?php

ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$id = $_COOKIE['user_id'] or exit ('авторизуйтесь');
$token = $_COOKIE['token'] or exit ('авторизуйтесь');

$db = mysqli_connect('localhost', 'root', '', 'baza1');
$query = "SELECT `token` FROM `users` WHERE `id` = $id";
$result = mysqli_query($db, $query) or exit ('query failed');

if (!(list ($dbToken) = mysqli_fetch_row($result))) exit ('пользователь не найден');
if ($token !== $dbToken) exit ('авторизуйтесь');
require "password.php";
$token = randStr();
$query = "UPDATE `users` SET `token`= '$token' WHERE `id` = $id";
mysqli_query($db, $query) or exit ('query failed');

$query = "SELECT login FROM `users`";
$result = mysqli_query($db, $query) or exit ('query failed');
while (list ($login) = mysqli_fetch_row($result)) $logins[] = $login;
$response = array ('logins'=>$logins, 'token'=>$token);
echo json_encode($response);

?>
