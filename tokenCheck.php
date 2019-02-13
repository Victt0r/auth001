<?php

function tokenCheck($db) {
  global $_COOKIE;
  $user_id = addslashes($_COOKIE['user_id']) or exit ('авторизуйтесь');
  $token = addslashes($_COOKIE['token']) or exit ('авторизуйтесь');

  $query = "SELECT `id` FROM `sessions`
            WHERE `user_id` = $user_id AND `token` = '$token'";
  $result = mysqli_query($db, $query) or exit ('query failed');
  list ($id) = mysqli_fetch_row($result) or exit ('сессия не найдена');

  require "password.php";
  $token = randStr();
  $query = "UPDATE `sessions` SET `token`= '$token' WHERE `id` = $id";
  mysqli_query($db, $query) or exit ('query failed');
  return $token;
}

?>
