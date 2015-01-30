<?php
session_start();
require(dirname(__FILE__).'/conf/config.php');
require(dirname(__FILE__).'/conf/functions.php');

$_SESSION=array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(),"", time()-86400, '/');
}

session_destroy();
 
header('Location: '.SITE_URL.'login.php');

