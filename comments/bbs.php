<?php
session_start();

if(empty($_SESSION['me'])){
    header('Location:'.SITE_URL.'login.php');
    exit;
}

$me=$_SESSION['me'];
$user_id=$me['id'];


if(!empty($me['name'])){
  $name=$me['name'];
  }else if(isset($me['tw_screen_name'])){
    $name=$me['tw_screen_name'];
  }

if(empty($_POST['comment'])){
	$err="コメントを入力してください";
}else{
	$comment=h($_POST['comment']);

$dbh = connectDb();

$sql = "insert into comments (user_id,name,comment,created) values (:user_id,:name,:comment,now())";
$stmt=$dbh->prepare($sql);

$params=array(':name' => $name,
				':comment'=>$comment,
                              ':user_id'=>$user_id);

$stmt->execute($params);
}

if(empty($err)){
    header("Location:".SITE_URL);
}

if(empty($dbh)){
    $dbh = connectDb();
}

$sql="select * from comments";

$comments=array();

foreach ($dbh->query($sql) as $row) {
        array_unshift($comments, $row);
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>コメントページ</title>
    <link type="text/css" rel="stylesheet" href="bbs.css"/>
</head>
<body>

<div>
    <form action="" method="post" class="form-inline" role="form">
    <p>Username:<?php echo $name; ?></p>
    <p>comment:<input type="text" name="comment" id="comment" size="50" placeholder="コメントを残す"></p>
   <p><?php print "$err";?></p>
    <p><input type="submit"  id="submit" value="投稿"></p>
    </form>
</div>

<div>
        <ul>
<?php foreach ($comments as $comment) : ?>
    <li><?php echo h($comment['name'])." さん   :   ".h($comment['comment'])."      (".$comment['created']." ) ";  ?></li>
<?php endforeach; ?>
        </ul>

</div>

</body>
</html>