<?php
session_start();


if(empty($_SESSION['me'])){
   header('Location:'.SITE_URL.'login.php');
    exit;
}

$me=$_SESSION['me'];

?>

<div>
<p>ログインしています</p> 
<p>
<?php if(empty($me['name'])): ?>
     "<?php echo h($me['tw_screen_name']); ?>"(<?php echo "Twitterでのログイン";?>) 登録ID :(<?php echo h($me['id']); ?>)
        <?php else: ?>
             "<?php echo h($me['name']); ?>"(<?php echo h($me['email']);?>) 登録ID :(<?php echo h($me['id']); ?>)
    <?php endif; ?>

<a href="logout.php">[ログアウト]</a>
</p>
<p><a href="">マイページ（変更・削除など）</a></p>
</div>


