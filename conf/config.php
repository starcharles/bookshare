<?php

define('DSN','mysql:host=localhost;dbname=php_bookshare');
define('DB_USER','book_dbuser');
define('DB_PASSWORD','7n4Ety');
define('SITE_URL','http://monapgs.luna.ddns.vc/bookshare/');
//define('SITE_URL','http://localhost/~ns/bookshare/');
define('PASSWORD_KEY','xdf8sdf(!sdf');

error_reporting(E_ALL & ~E_NOTICE); 
session_set_cookie_params(0, '/bookshare/');
?>
