<?php
session_start();

//ini_set( 'display_errors', 1 );
require(dirname(__FILE__).'/conf/config.php');
require(dirname(__FILE__).'/conf/functions.php');

session_regenerate(); //セッションハイジャック対策


if(empty($_SESSION['me'])){
    header('Location:'.SITE_URL.'login.php');
    exit;
}

$me=$_SESSION['me'];

$dbh = connectDb();

$users=array();

$sql = "select * from users order by created desc";

foreach ($dbh->query($sql) as $row) {
    array_push($users, $row);
}


?>
<!DOCTYPE html>


<html lang="ja">
<head>
    <link type="text/css" rel="stylesheet" href="index.css"/>
    <meta charset="UTF-8">
    <title>ユーザー一覧</title>
</head>
<body>
<div>
<?php include(dirname(__FILE__).'/header.php');?>

</div>

<div class="container">
<div class="row">
    <div class="col-xs-5 col-xs-offset-1">
    <p><a href="./book_form.php">本を登録する</a></p>

<p>ユーザー一覧</p>

<ul>
<?php foreach ($users as $user) : ?>
    <?php if(empty($user['name'])): ?>
        <li><a href="profile.php?id=<?php echo h($user['id']); ?>"><?php echo h($user['tw_screen_name']); ?></a></li>

        <?php else: ?>
           <li><a href="profile.php?id=<?php echo h($user['id']); ?>"><?php echo h($user['name']); ?></a></li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>


    </div><!--col-->


     <div  class="col-xs-4">
        <?php include(dirname(__FILE__).'/comments/bbs.php'); ?>
    </div>

</div><!--row-->
</div><!--container-->




</body>

</html>

