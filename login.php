<?php
session_start();
require(dirname(__FILE__).'/config.php');
require(dirname(__FILE__).'/functions.php');


if(!empty($_SESSION['me'])){
    header('Location:'.SITE_URL);
    exit;
}

function getUser($email, $password, $dbh){
    $sql="select * from users where email =:email and password = :password limit 1";
    $stmt=$dbh->prepare($sql);
    $stmt->execute(array(":email" =>$email,":password"=>getSha1password($password)));
        $user=$stmt->fetch();

        return $user ? $user :false;
}

if($_SERVER['REQUEST_METHOD'] != "POST"){

    setToken();

}else{
    checkToken();

    
    $email =$_POST['email'];
    $password=$_POST['password'];

    //check error input
    $dbh=connectDb();
      
    $err = array();

            //email is not registered
 if(! emailExists($email,$dbh)){
          $err['email']="This email address is not registered";
    }
        //form of email err
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

        $err['email']="email format is wrong";
    }
        //null
     if($email==NULL){
       $err['email']="plz input email address.";
    }
    
        //email and pass is mismatch

    $me= getUser($email, $password, $dbh);


    if(!$me){
            $err['password']="email and password is invalid ";
    }

    

        //password null    
    if($password==NULL){
        $err['password']="plz input password.";
    }


    if(empty($err)){
        $_SESSION['me'] = $me;
        //var_dump($_SESSION['me']);
       header('Location: '.SITE_URL);
        exit;
    }
    
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>

<div><a href="signup.php">新規ユーザー登録はこちら</a></div>
<div>
<h1>ログイン</h1>
<form action="" method="POST">
<p>E-mail : <input type ="text" name="email" value="<?php echo h($email);  ?>"><?php echo h($err['email']);  ?></p>
<p>Password : <input type ="password" name="password" value=""><?php echo h($err['password']);  ?></p>
<input type ="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
<p><input type ="submit" value="login"></p>
</form>
</div>

<div>
<h1><a href="twLogin/getToken.php">Twitterでユーザー登録・ログインする</a></h1>
<p>（Twitter認証画面へ遷移します）</p>

</div>





</body>

</html>

