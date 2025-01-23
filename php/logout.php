<?php
session_start();
session_destroy();
$_SESSION = array();
setcookie('username', "", time() - 42000, "/");
setcookie('PHPSESSID', "", time() - 42000, "/");
header("location: ../login.php");
?>