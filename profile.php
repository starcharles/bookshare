<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'] .'/bookshare/'.'config.php');
require($_SERVER['DOCUMENT_ROOT'] .'/bookshare/'.'functions.php');

//require('config.php');
//require('functions.php');

if(empty($_SESSION['me'])){
   header('Location:'.SITE_URL.'login.php');
    exit;
}

$me=$_SESSION['me'];

$dbh = connectDb();

$sql="select * from users where id= :id limit 1";
$stmt=$dbh->prepare($sql);
$stmt->execute(array(":id"=> (int)$_GET['id']));

$user=$stmt->fetch();

if(!$user){
    echo "No such user";
    exit;
}

//このユーザーの蔵書一覧
    $ownerid=(int)$_GET['id'];
    $sql="select * from books where ownerid= :ownerid";
    $stmt=$dbh->prepare($sql);
    $params=array(
            ":ownerid"=> $ownerid
              );
    $stmt->execute($params);
    $books=$stmt->fetchAll();

    $index =array("title","author","year","category","recommend");


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザープロフィール</title>
</head>
<body>
<div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/bookshare/header.php');?>

</div>
<h1><?php echo h($user['name']); ?>さんのアイテム一覧</h1>



<table border="1"> 
<tr>
<th>書名</th><th>著者</th><th>出版年</th><th>カテゴリ</th><th>紹介文</th>
</tr>
<?php for($i=0; $i < count($books) ;$i++) : ?><tr>
    <?php    $book= $books[$i];?>
              <?php foreach ($index as $key) : ?>
    <td><?php print h($book[$key]);?></td>
  <?php endforeach;?>
</tr><?php endfor;?>
</table>

<p><a href="index.php">一覧へ</a></p>


</body>
</html>

