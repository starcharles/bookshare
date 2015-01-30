<?php
/*
receive POST from delUse.php 
	and write down to file the requests
	*/



$userId=$_POST['userId'];
$username=$_POST['username'];
$submit_time=$_POST['submit_time'];

$request="name:$username"." userID:$userId  依頼日時:".$submit_time."\n";

$fp = fopen("deleteReq.txt", "a+");
fwrite($fp,$request);
fclose($fp);

$result=array('aa'=>'aaa');
header('Content-type: application/json');
echo json_encode($result);

?>
