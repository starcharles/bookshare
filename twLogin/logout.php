<?php
require('config.php');
require('functions.php');

$_SESSION=array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/twLogin/');
}

session_destroy();
 
header('Location: '.SITE_URL.'login.php');

