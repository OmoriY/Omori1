<!DOCTYPE html> 
<html lang="ja"> 
<head> 
<meta charset="UTF-8"/> 
</head> 
<body> 
<b>投稿確認</b><br><br>
<?php
$upfile = $_FILES['upfile']['tmp_name'];
$upfile_name = $_FILES['upfile']['name']; // 投稿者が指定したファイル名
$upfile_type = $_FILES['upfile']['type'];
move_uploaded_file($upfile,"upload/$upfile_name");
$uploadfilename = date("ymdHis").$upfile_name;
?>
<?php 
$name = $_POST['name']; 
$body = $_POST['body'];
if( $name=='' || $body==''){ 
 echo "全ての項目を記入して下さい。<br><br>\n"; 
 echo '<a href="javascript:history.back()">戻る</a>'; 
 echo "</body></html>\n"; 
 exit; 
}
?>
<?php
$date = date("Y/m/d H:i:s"); 
$ip = $_SERVER['REMOTE_ADDR']; 
$host = gethostbyaddr($ip); 
$f = fopen("5.txt", "a");
fwrite($f, "$date,$ip,$host,$name\n");
fwrite($f, "$body\n");
fwrite($f, "<IMG>\n"); // 記事と添付ファイルとの区切り ← 重要
fwrite($f, "$upfile_name\n");
fwrite($f, "<END>\n");
fclose($f);
?>
投稿が終わりました。<br><br> 
<a href="5.php">掲示板に戻る</a><br><br> 
</body> 
</html>

