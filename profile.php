<?php
session_start();

require(dirname(__FILE__).'/conf/config.php');
require(dirname(__FILE__).'/conf/functions.php');


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
    <title>ユーザープロフィール</title>
</head>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<body>
<div>
<?php include(dirname(__FILE__).'/header.php');?>

</div>
<h1><?php echo $user_name ?>さんのアイテム一覧</h1>



<table border="1"> 
<tr>
<th>書名</th><th>著者</th><th>出版年</th><th>カテゴリ</th><th>紹介文</th>
<th>申請</th>
</tr>
<?php for($i=0; $i < count($books) ;$i++) : ?><tr>
    <?php    $book= $books[$i];?>
              <?php foreach ($index as $key) : ?>
    <td><?php print h($book[$key]);?></td>
  <?php endforeach;?>
  <td><form method="POST" action="rent/rental.php">
   <input type="hidden" name="ownerid" value="<?php print h($book['ownerid']); ?>">
  <button type="submit"  name="book_id" value="<?php print h($book['id']); ?>">レンタル申請！</button>
  </form>
  </td>
</tr><?php endfor;?>
</table>

<p><a href="index.php">一覧へ</a></p>

<script type="text/javascript">
  var myId=<?php echo $me['id'] ;?>;
  var ownerid=<?php echo $ownerid;?>;
//  alert(myId+":"+ownerid);


$('form').submit(function(){

  if(myId===ownerid){
      alert("あなたの所持品です");
      return false;
  }else{
    return true;
  }

});

</script>
</body>
</html>

