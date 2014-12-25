<?php
session_start();

require('../conf/config.php');
require('../conf/functions.php');


if(empty($_SESSION['me'])){
   header('Location:'.SITE_URL.'login.php');
    exit;
}

$me=$_SESSION['me'];

$ownerid=$_POST['ownerid'];
$book_id=$_POST['book_id'];

print "hi!! $ownerid:$book_id";

if($me['id']==$ownerid){
  print "自分の持ち物です";
}

/*
・借りる相手にメッセージ（相手はトップページに申請通知が見える:headerあたりに。

・このページでは？
データベース処理
  ・借り手（申請者、貸し手（保持者、未貸出、他の人に貸出し済み、借りてに貸出中、貸出日時、返却予定、貸出期間、料金、
  ・


*/
?>
