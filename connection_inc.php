<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "HRS");

define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/hrs/');
define('SITE_PATH','http://127.0.0.1/hrs/');
define('HOUSE_IMAGE_SERVER_PATH',SERVER_PATH.'media/houses/');
define('HOUSE_IMAGE_SITE_PATH',SITE_PATH.'media/houses/');
?>