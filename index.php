<?php
session_start();

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

<div class="child1">
<h1>ユーザー一覧</h1>

<ul>
<?php foreach ($users as $user) : ?>
    <?php if(empty($user['name'])): ?>
        <li><a href="profile.php?id=<?php echo h($user['id']); ?>"><?php echo h($user['tw_screen_name']); ?></a></li>

        <?php else: ?>
           <li><a href="profile.php?id=<?php echo h($user['id']); ?>"><?php echo h($user['name']); ?></a></li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>

<h2><a href="./book_form.php">本の登録</a></h2>
</div>

<div class="child2">

<?php include(dirname(__FILE__).'/comments/bbs.php'); ?>

</div>


</body>

</html>

