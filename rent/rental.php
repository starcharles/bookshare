<?php
session_start();

//ini_set( 'display_errors', 1 );

require('../conf/config.php');
require('../conf/functions.php');


if(empty($_SESSION['me'])){
   header('Location:'.SITE_URL.'login.php');
    exit;
}

$me=$_SESSION['me'];

$ownerid=$_POST['ownerid'];
$book_id=$_POST['book_id'];



if($me['id']==$ownerid){
  print "自分の持ち物です";
  exit;
}

//本のデータ取得

$dbh = connectDb();

    $sql="select * from books where ownerid= :ownerid and id=:book_id limit 1";
    $stmt=$dbh->prepare($sql);
    $params=array(
            ":ownerid"=> $ownerid,
            ":book_id"=>$book_id
              );

    $stmt->execute($params);
    $book=$stmt->fetch();


if(empty($book)){
    print "エラー：申請した本のデータがありません";
    exit;
}

//print_r($book);

//本の所持ユーザーを取得
$sql="select * from users where id= :id limit 1";
$stmt=$dbh->prepare($sql);
$stmt->execute(array(":id"=>$ownerid));

$user=$stmt->fetch();
$index =array("title","author","year");


if(empty($user['name'])){
        $user_name=h($user['tw_screen_name']);
}else{
         $user_name=h($user['name']);
       }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>レンタル申請</title>
    <style type="text/css">
    table{
        text-align:center;
    }
    </style>
</head>
<body>
<div>
<?php include('../header.php');?>

</div>

<div>
    <p><h1>申請した本</h1></p>
    <p><h2><?php echo $user_name ?>さんのアイテム</h2></p>

</div>

<table border="1"> 
<tr>
<th>書名</th><th>著者</th><th>出版年</th>
</tr>
<tr>
    <?php foreach ($index as $key) : ?>
    <td><?php print h($book[$key]);?></td>
  <?php endforeach;?>
</tr>
</table>


<div>
<p>
    この本の貸出申請をしてもよろしいですか?
    <form method="POST" action="rental_result.php">
        <input type="hidden" name="ownerid" value="<?php print $ownerid; ?>">
         <input type="hidden" name="book_id" value="<?php print $book_id; ?>">
        <button type="submit">はい</button>
    </form>
    </p>
</div>
<p><a href="../index.php">一覧へ戻る</a></p>


</body>
</html>