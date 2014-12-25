<?php
session_start();
require(dirname(__FILE__).'/config.php');
require(dirname(__FILE__).'/functions.php');


if(empty($_SESSION['me'])){
    header('Location:'.SITE_URL);
    exit;
}else{
$me=$_SESSION['me'];

$dbh = connectDb();
$ownerid=h($me['id']);
    $sql="select * from books where ownerid= :ownerid";
    $stmt=$dbh->prepare($sql);
    $params=array(
            ":ownerid"=> $ownerid
              );
    $stmt->execute($params);
    $books=$stmt->fetchAll();

    $index =array("title","author","year","category","recommend");
}

if($_SERVER['REQUEST_METHOD'] != "POST"){

    setToken();

}else{
    checkToken();

    $title=$_POST['title'];
    $author =$_POST['author'];
    $category =$_POST['category'];
    $year =$_POST['year'];
    $ownerid =$_POST['ownerid'];
    $recommend=$_POST['recommend'];

    //check error input
    $dbh=connectDb();

    if($title==NULL){
       $err['title']="書名を入力してください";
    }

    if($author==NULL){
        $err['author']="著者を入力してください";
    }

    if($category==NULL){
        $err['category']="分類を入力してください";
    }

    if($year==NULL){
        $err['year']="出版年を入力してください";
    }


    if(empty($err)){
            //register form

        $sql="insert into books 
        (title,author,year,category,recommend,ownerid,created,modified) 
        values 
        (:title,:author,:year,:category,:recommend,:ownerid,now(),now())";

            $stmt=$dbh->prepare($sql);

            $params=array(
             ":title"=>$title,
            ":author"=>$author,
              ":year"=>$year,
            ":category"=>$category,          
            ":recommend"=> $recommend,
            ":ownerid"=> $ownerid
              );
            $stmt->execute($params);
            header('Location:'.SITE_URL.'book_form.php');

        
            //print "登録いたしました。更に登録を続ける場合は引き続き下のフォームに入力してください。";

            
            }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>本の登録</title>
</head>
<body>
<div>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/bookshare/header.php');?>

</div>

<div>
<h1>本の登録</h1>
<form action="./book_form.php" method="POST">
<p>本のタイトル: <input type ="text" name="title" value="<?php echo h($title);  ?>"><?php echo h($err['title']);  ?></p>
<p>本の著者 : <input type ="text" name="author" value="<?php echo h($author);  ?>"><?php echo h($err['author']);  ?></p>
<p>出版年 : <input type ="number" name="year" value="<?php echo h($year);  ?>"><?php echo h($err['year']);  ?></p>

<p>分類 : 
<select name="category" >
<option value="評論・時事">評論・時事</option>
<option value="文学・小説" >文学・小説</option>
<option value="サブカルチャー">サブカルチャー</option>
<option value="社会">社会</option>
<option value="哲学">哲学・思想</option>
<option value="社会科学">社会科学</option>
<option value="自然科学" >自然科学</option>
<option value="その他">その他</option>
</select>
</p>

<p> <input type ="hidden" name="ownerid" value=<?php echo h($me['id']);?>></p>
<p>オススメ紹介文 （任意）: <input type="text" name="recommend" value="<?php echo h($recommend);  ?>"><?php echo h($err['recommend']);  ?></p>
<input type ="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
<p><input type ="submit" value="登録する">
<br><a href="index.php">ユーザー一覧へ</a></p>
</form>
</div>

<div>
<h1 style="color:blue"><center >登録済みアイテム</center></h1>
<table border="1" align="center"> 
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
</div>


</body>

</html>

