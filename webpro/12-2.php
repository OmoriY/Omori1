<!DOCTYPE html> 
<html lang="ja"> 
<head> 
<meta charset="UTF-8"/> 
</head> 
<body> 
<br> 
<?php 
 session_start(); 
 if( $_POST['r'] == $_SESSION['answer'] ){ 
 echo "正解です。<br>"; 
 $con = mysqli_connect('localhost','i088omor','') or die("接続失敗"); 
 mysqli_select_db($con, 'i088omor') or die("選択失敗"); 
 mysqli_query($con, 'SET NAMES utf8'); 
 $level = $_SESSION['level']; 
 $id = $_SESSION['id']; 
 $date = date("Y-m-d H:i:s"); 
 $sql = "INSERT INTO user(level, id, dt1) VALUES('$level','$id','$date')"; 
 $res = mysqli_query($con, $sql) or die("エラー"); 
 mysqli_close($con); 
 }else{ 
 echo "不正解です。<br>"; 
 } 
 session_unset(); 
?> 
<br> 
<a href="javascript:history.back()">戻る</a> 
</body> 
</html>
