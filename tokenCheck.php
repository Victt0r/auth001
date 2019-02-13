<?php

function tokenCheck($db) {
  global $_COOKIE;
  $id = addslashes($_COOKIE['user_id']) or exit ('авторизуйтесь');
  $token = addslashes($_COOKIE['token']) or exit ('авторизуйтесь');

  $query = "SELECT `id` FROM `users` WHERE `id` = $id AND `token` = '$token'";
  $result = mysqli_query($db, $query) or exit ('query failed');
  mysqli_fetch_row($result) or exit ('пользователь не найден');

  require "password.php";
  $token = randStr();
  $query = "UPDATE `users` SET `token`= '$token' WHERE `id` = $id";
  mysqli_query($db, $query) or exit ('query failed');
  return $token;
}

?>
