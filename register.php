
<?php
ini_set('display_errors', 1);
error_reporting(E_PARSE | E_ERROR);

$db = mysqli_connect('localhost', 'root', '', 'baza1');

$login = addslashes($_REQUEST['login']) or $errors[] = 'login';
$mail  = addslashes($_REQUEST['mail'])  or $errors[] = 'mail';
$pass  = addslashes($_REQUEST['pass'])  or $errors[] = 'pass';

if (isset($errors)) {
  $errors = implode(", ", $errors);
  exit ("These parameters must not be empty: $errors ");
}

$query = "INSERT INTO `users` (`mail`, `login`, `passhash`)
          VALUES ('$mail', '$login', '$pass')";

function startsWith($str, $substr) {return strpos($str, $substr) === 0;}
function endsWith($str, $substr) {
  return substr($str, strlen($str)-strlen($substr)) == $substr;
}

if (mysqli_query($db, $query)) echo "user added";
else {
  $error = mysqli_error($db);
  if (startsWith($error, "Duplicate")) {
    //двойные кавычки нужны тк строка об ошибке содержит имя колонки в кавычках
    if (endsWith($error, "'mail'"))
      echo "this mail already registered, try to log in or restore password";
    else if (endsWith($error, "'login'"))
      echo "this login already occupied";
  }
  else echo $error;
}



?>
