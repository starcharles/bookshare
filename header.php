<?php
session_start();


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
    <title>ログイン</title>
<!-- コンパイルして圧縮された最新版の CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- オプションのテーマ -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- コンパイルして圧縮された最新版の JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<style>
.container{
    margin : 20px; 
    padding : 0 ; 
    //background-color:   #87CEFA; 
}
</style>

<div class="container">
	<div class="row">
		<div class="col-xs-7">
		<a href="./index.php">トップへ戻る</a>
			<p>ログインしています</p> 
			<p><?php if(empty($me['name'])): ?>
			     "<?php echo h($me['tw_screen_name']); ?>"(<?php echo "Twitterでのログイン";?>) 登録ID :(<?php echo h($me['id']); ?>)
			        <?php else: ?>
			             "<?php echo h($me['name']); ?>"(<?php echo h($me['email']);?>) 登録ID :(<?php echo h($me['id']); ?>)
			    <?php endif; ?>
			    <a href="logout.php">[ログアウト]</a>
			    </p>
			<p><a href="mypage.php">マイページ（変更・削除など）</a></p>
		</div><!--col-->


	<div id="right" class="col-xs-4 col-xs-offset-1">
	<div>
	お知らせ（<?php echo h($me['tw_screen_name']); ?>）
	</div>

	<div>
	<p>現在の貸し借り状況</p>
	<p>ポイント</p>
	</div>
	
	</div><!--right-->

</div><!--row-->
</div><!--containet-->
</body>

</html>