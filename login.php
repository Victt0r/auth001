<?php
ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$db = mysqli_connect('localhost', 'root', '', 'baza1');

$login = addslashes($_REQUEST['login']) or exit ('введите логин');
$pass  = addslashes($_REQUEST['pass'])  or exit ('введите пароль');

$query = "SELECT id FROM `users` WHERE login = '$login' AND passhash = '$pass'";

$result = mysqli_query($db, $query) or exit ('query failed');
list ($id) = mysqli_fetch_row($result) or exit ('логин или пароль неверный');

echo '{"id": "'.$id.'"}';
?>
