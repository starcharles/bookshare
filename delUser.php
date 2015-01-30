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

<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<body>


<div id="delete">
<button>アカウントを削除する</button>
</div><!--- -->

<p>メールアドレスを登録している方には確認のメールをいたします。</p>



<script type="text/javascript">

$('#delete button').click(function(){

  if(confirm("本当に削除してよろしいですか？（申請後管理人が手動で削除します）")){
  	  
  	      ajax_post();
  	  }else{
      
	  }
});

var userId=<?php echo $me['id'] ;?>;
var time= "<?php echo date("Y-m-d H:i:s"); ?>";
var username="<?php echo $me['name']; ?>";

function ajax_post(){
	      var result=$.ajax({
            type: "POST",
            url: "userAdmin.php",
            dataType: 'json',
            data: {
                 userId: userId,
                 username:username,
                 submit_time: time,
            },

            
            timeout:10000,
                success: function(data) {
                	    alert("削除申請しました:");
                        
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
			           alert("申請に失敗しました。もう一度試すか管理人に問い合わせてください");
                       }
    });

}

</script>

</body>
</html>