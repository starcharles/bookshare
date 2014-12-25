<?php
session_start();

require_once('functions.php');
require_once('config.php');
require_once('twitteroauth.php');
 
// getToken.php でセットした oauth_token と一致するかチェック
if ($_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
    unset($_SESSION);
    echo '<a href="getToken.php">トークンが一致しません。やり直してください。</a>';
    exit;
}
 
// access token 取得
$tw = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
    $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

$access_token = $tw->getAccessToken($_REQUEST['oauth_verifier']);
 


if (empty($access_token['oauth_token'])) {
    print '<a href="getToken.php">認証に失敗しました。やり直してください。(アクセストークンがありません）</a>';

    /* アクセス・トークンがなければ、何らかの理由で取得失敗した。
      もう一度リクエスト・トークンを生成して認証を試みる。
     */

      exit;
}


$_SESSION['oauth_token'] = $access_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $access_token['oauth_token_secret'];

//*** 認証成功、$twはそのまま通信に使える ***

/*
// 初回ユーザかチェックするロジック
if( ){
 
    // 初回ユーザならDatabaseへの登録処理・・・などなど
 
}
 */

// ログイン後の画面へ遷移

// Twitter の user_id + screen_name(表示名)
$user_id     = $access_token['user_id'];
$screen_name = $access_token['screen_name'];
 
 //print "$screen_name さん（Twitter id: $user_id)  こんにちは";

$dbh=connectDB();
$sql = "select * from users where tw_user_id = :id limit 1";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(":id" => $user_id));
$user = $stmt->fetch();

if(empty($user)){

    $sql="insert into users
      (tw_user_id,tw_screen_name,tw_access_token,tw_access_token_secret,created,modified)
      values 
      (:user_id,:name,:access_token,:access_token_secret,now(),now())";

    $stmt=$dbh->prepare($sql);
    $params=array(":user_id"=>$user_id,
                                            ":name"=>$screen_name,
                                            ":access_token"=> $access_token['oauth_token'],
                                            ":access_token_secret"=>$access_token['oauth_token_secret']
                                            );

    $stmt->execute($params);
    
    $myId = $dbh->lastInsertId();
    $sql = "select * from users where id = :id limit 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(":id" => $myId));
    $user = $stmt->fetch();

}

    // ログイン処理
    if (!empty($user)) {
        // セッションハイジャック対策
        session_regenerate_id(true);
        $_SESSION['me'] = $user;
    }
    
    // ホームに飛ばす
    header('Location: '.SITE_URL);
    
