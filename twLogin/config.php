<?php

define('DSN','mysql:host=localhost;dbname=php_bookshare');
define('DB_USER','book_dbuser');
define('DB_PASSWORD','7n4Ety');
define('SITE_URL','http://monapgs.luna.ddns.vc/bookshare/');

define('CONSUMER_KEY', 'doNwr46fTCxBCeVmVDg5GczgW');
define('CONSUMER_SECRET', 'qj2j4zSLCU39P1CJ4dDxWsDWW99SBJir3o5hK3pcji9i50NyHi');
define('CALLBACK_URL', 'http://monapgs.luna.ddns.vc/bookshare/twLogin/callback.php');
//define('SITE_URL', 'http://localhost/~ns/bookshare/');


error_reporting(E_ALL & ~E_NOTICE);
 
session_set_cookie_params(0, '/bookshare/');
?>
