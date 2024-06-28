<?php 
 $con = mysqli_connect('localhost','i088omor','') or die("接続失敗"); 
 mysqli_select_db($con, 'i088omor') or die("選択失敗"); 
 mysqli_query($con, 'SET NAMES utf8'); 
 $sql = "SELECT * FROM photo"; 
 $res = mysqli_query($con, $sql) or die("抽出失敗"); 
 while ($db = mysqli_fetch_assoc($res)) { 
 $filename = $db['filename']; 
 $account = $db['account']; 
 $date = date("Y/m/d H:i:s", strtotime($db['date'])); 
 $lat = $db['lat']; 
 $lng = $db['lng']; 
 $alt = $db['alt']; 
 $comment = $db['comment']; 
 echo "$lat,$lng,$alt,$account,$filename,$comment,\n"; 
 } 
 mysqli_close($con); 
?>

