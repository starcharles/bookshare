<?php
session_start();

require(dirname(__FILE__).'/conf/config.php');
require(dirname(__FILE__).'/conf/functions.php');


if(empty($_SESSION['me'])){
   header('Location:'.SITE_URL.'login.php');
    exit;
}

$me=$_SESSION['me'];



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザーマイページ</title>
</head>
<body>
<div>
<?php include(dirname(__FILE__).'/header.php');?>

</div>
<div>
    <h1>所持アイテムの変更・削除</h1>

</div>

<div>
<h2>ユーザー削除</h2>

</div>
<div>
    <h1>貸借一覧</h1>

</div>

</body>
</html>

