<?php
session_start();
require(dirname(__FILE__).'/config.php');
require(dirname(__FILE__).'/functions.php');

if($_SERVER['REQUEST_METHOD'] != "POST"){

    setToken();

}else{
    checkToken();

    $name=$_POST['name'];
    $email =$_POST['email'];
    $password=$_POST['password'];

    //check error input
    $dbh=connectDb();

         //name,email,password

    if($name==NULL){
       $err['name']="ユーザー名を入力してください";
    }

    if($email==NULL){
        $err['email']="E-mailアドレスを入力してください";
    }
 if($password==NULL){
        $err['password']="パスワードを入力してください";
    }

    
//confirm email
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

        $err['email']="使用可能なアドレスではありません";
    }

    if(emailExists($email,$dbh)){
          $err['email']="このアドレスはすでに登録されています。";
    }


    if(empty($err)){
            //register form

        $sql="insert into users 
                (name,email,password,created,modified)
                values 
                (:name,:email,:password,now(),now())";

            $stmt=$dbh->prepare($sql);

            $params=array(
             ":name"=>$name,
            ":email"=>$email,
            ":password"=> getSha1password($password)
              );
            $stmt->execute($params);
            header('Location:'.SITE_URL.'login.php');

            exit;




    }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
</head>
<body>

<h1 style="color:blue;font-family:Arial">ユーザー登録</h1>
<form action="./signup.php" method="POST">
<p>ユーザー名: <input type ="text" name="name" value="<?php echo h($name);  ?>"><?php echo h($err['name']);  ?></p>
<p>E-mail : <input type ="text" name="email" value="<?php echo h($email);  ?>"><?php echo h($err['email']);  ?></p>
<p>パスワード: <input type ="password" name="password" id="pass1" value="<?php echo h();  ?>"><?php echo h($err['password']);  ?></p>
<p>パスワード(確認）: <input type ="password" name="password" id="pass2"></p>

<input type ="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
<p><input type ="submit" value="Register">
<br><a href="index.php">トップへ戻る</a></p>
</form>

<script type="text/javascript">
 
    $("form").submit(function(){
                var pass1=$("#pass1").val();
                var pass2=$("#pass2").val();

                if(pass1!==pass2){
                    alert("パスワードが一致しません。確認してください。");
                    return false;
                }else{
                    return true;
                }
            })

</script>
</body>

</html>

