<?php

ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$id = addslashes($_COOKIE['user_id']) or exit ('авторизуйтесь');
$token = addslashes($_COOKIE['token']) or exit ('авторизуйтесь');

$db = mysqli_connect('localhost', 'root', '', 'baza1');
$query = "SELECT `id` FROM `users` WHERE `id` = $id AND `token` = '$token'";
$result = mysqli_query($db, $query) or exit ('query failed');
mysqli_fetch_row($result) or exit ('пользователь не найден');

require "password.php";
$token = randStr();
$query = "UPDATE `users` SET `token`= '$token' WHERE `id` = $id";
mysqli_query($db, $query) or exit ('query failed');

$query = "SELECT COUNT(id) FROM `users` WHERE LENGTH(passhash) > 32";
$result = mysqli_query($db, $query) or exit ('query failed');
list ($number) = mysqli_fetch_row($result);

$response = array ('token'=>$token, 'number'=>$number);
echo json_encode($response);

?>
