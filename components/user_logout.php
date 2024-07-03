<?php
session_start();
session_destroy();
setcookie('user_id', '', time() - 1, '/');
unset($_COOKIE['user_id']);
header('location:../index.php');
exit;
?>