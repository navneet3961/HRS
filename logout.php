<?php
session_start();
unset($_SESSION['USER_LOGIN']);
unset($_SESSION['USER_USERNAME']);
unset($_SESSION['USER_ID']);
header('location:index.php');
die();
?>