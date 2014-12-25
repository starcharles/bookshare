<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] .'/bookshare/'.'config.php');
require($_SERVER['DOCUMENT_ROOT'] .'/bookshare/'.'functions.php');

$_SESSION=array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(),"", time()-86400, '/');
}

session_destroy();
 
header('Location: '.SITE_URL.'login.php');

