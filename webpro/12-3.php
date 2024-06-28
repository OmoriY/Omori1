<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8"/>
</head>
<body>
<b>和英辞典</b><br>
<br>
<?php
 $con = mysqli_connect('localhost','i088omor','') or die("接続失敗");
 mysqli_select_db($con, 'i088omor') or die("選択失敗");
 mysqli_query($con, 'SET NAMES utf8');
 $meaning = $_POST['meaning'];
 $meaning = addslashes($meaning);
 $sql = "SELECT * FROM svl5000 WHERE meaning like '%$meaning%'";
 $res = mysqli_query($con, $sql) or die("エラー");
 while ($db = mysqli_fetch_assoc($res)) {
 echo "<table border=1><tr><td>英単語</td><td>${db['word']}</td></tr>";
 echo "<tr><td>レベル</td><td>${db['level']}</td></tr>";
 echo "<tr><td>意味</td><td>${db['meaning']}</td></tr></table>";
 }
 mysqli_close($con);
?>
<br>
<a href="javascript:history.back()">戻る</a>
</body>
</html>

