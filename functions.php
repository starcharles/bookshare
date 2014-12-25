<?php

function connectDb(){
    try{
        return new PDO(DSN,DB_USER,DB_PASSWORD);
    }catch(PDOException $e){
        echo $e->getMessage();
        exit;
    }
}

function h($s){
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}


function setToken(){
    $token=sha1(uniqid(mt_rand(),true));
    $_SESSION['token']=$token;
}

function checkToken(){
        if(empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token']) ){
                print "POST is wrong (Token is not found or mismatched)";
                exit;
        }
}

function emailExists($email,$dbh){
    $sql="select * from users where email= :email limit 1";
    $stmt=$dbh->prepare($sql);
    $stmt->execute(array(":email"=>$email));
    $user=$stmt->fetch();
    return $user ? true : false ;

}

function getSha1password($s){
    return (sha1(PASSWORD_KEY.$s));

}

function session_regenerate(){
    if(mt_rand(1, 30)==1) { // 実行確率
 $sess_file = 'sess_'.session_id();
 $sess_dir_path = ini_get('session.save_path');
 $sess_file_path = $sess_dir_path. '/'. $sess_file;
 $timestamp = filemtime($sess_file_path);
 $span = 5*60;      // 経過時間
 
 if(($timestamp+$span) < time()) {
   session_regenerate_id(true);
    }// end if
    
    }//end if
}

?>