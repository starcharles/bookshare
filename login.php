<?php
session_start();
require(dirname(__FILE__).'/conf/config.php');
require(dirname(__FILE__).'/conf/functions.php');

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

<body>
<ul  class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
</ul>

<div class="container">
<div class="row">
    <div class="col-xs-5 col-xs-offset-1">
        <p><a href="signup.php">新規ユーザー登録はこちら</a><p>
        <button type ="submit" class="btn btn-default"><a href="twLogin/getToken.php">Twitter login</a></button>
        <p>（Twitter認証画面へ遷移します)</p>
    </div>

    <div  class="col-xs-4">
        <form action="" method="POST">
        <fieldset>
        <div class="form-group">
            <legend>ログイン</legend>
            E-mail : <input type ="text" name="email" class="form-control" value="<?php echo h($email);  ?>"><?php echo h($err['email']);  ?>
        </div>
        <div class="form-group">
            Password : <input type ="password" name="password" class="form-control" value=""><?php echo h($err['password']);  ?>
        </div>
        <input type ="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
        <button type ="submit" class="btn btn-default"><span class="glyphicon glyphicon-log-in"></span> login</button>
        </form>
         </fieldset>
    </div>
</div>
</div>
</body>

</html>

