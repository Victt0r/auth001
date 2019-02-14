<?php
ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$db = mysqli_connect('localhost', 'root', '', 'baza1');

$user_id = addslashes($_COOKIE['user_id']) or exit ('авторизуйтесь');
$token = addslashes($_COOKIE['token']) or exit ('авторизуйтесь');

$query = "SELECT id FROM sessions
          WHERE user_id = $user_id AND token = '$token'";

$result = mysqli_query($db, $query) or exit ('query failed');
list ($id) = mysqli_fetch_row($result) or exit ('сессия не найдена');

$query = "DELETE FROM sessions WHERE id = $id";
mysqli_query($db, $query) or exit ('query failed');
?>
