<?php
ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$db = mysqli_connect('localhost', 'root', '', 'baza1');

$login = addslashes($_REQUEST['login']) or exit ('введите логин');
$pass  = addslashes($_REQUEST['pass'])  or exit ('введите пароль');

$query = "SELECT id, passhash FROM `users` WHERE login = '$login'";

$result = mysqli_query($db, $query) or exit ('query failed');

list ($id, $hash) = mysqli_fetch_row($result) or exit ('пользователь не найден');
require "password.php";
//exit ("$pass, $hash");
if (!hashCheck($pass, $hash)) exit ('пароль неверный');
echo '{"id": "'.$id.'"}';
?>
