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
<div id="header">
<?php include(dirname(__FILE__).'/header.php');?>

</div>
<div><a href="delUser.php">自分のアカウントを削除する</a>
</div>


<div>
<p>status</p>
	<!-- <?php include('rent.php');?> -->
</div><!--- -->

<div>
    <p>所持アイテムの変更・削除</p>
<!--- <?php include('my_items.php');?> -->

</div><!--- -->

</body>
</html>

