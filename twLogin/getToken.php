<?php
session_start();

require_once('config.php');
require_once('twitteroauth.php');
 

// request token取得
$tw = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
$token = $tw->getRequestToken(CALLBACK_URL);
if(! isset($token['oauth_token'])){
    echo "error: getRequestToken\n";
    exit;
}
 
// callback.php で使うので session に突っ込む
$_SESSION['oauth_token']        = $token['oauth_token'];
$_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
 
// 認証用URL取得してredirect
$authURL = $tw->getAuthorizeURL($_SESSION['oauth_token']);
header("Location: " . $authURL);