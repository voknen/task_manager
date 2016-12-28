<?php 
unset($_COOKIE['id']);
unset($_COOKIE['is_logged']);
setcookie('id', null, -1, '/');
setcookie('is_logged', null, -1, '/');

echo "<meta charset='UTF-8' http-equiv='refresh' content='1;URL=login.php'>You left!";

?>