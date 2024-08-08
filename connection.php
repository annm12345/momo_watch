<?php
session_start();
$con=mysqli_connect("localhost","root","","momo");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/php/realstate/');
define('SITE_PATH','http://localhost/LMS/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/image/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/image/');
?>