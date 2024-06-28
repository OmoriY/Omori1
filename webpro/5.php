<!DOCTYPE html> 
<html lang="ja"> 
<head> 
<meta charset="UTF-8"/> 
<title>おすすめのゲームについて</title> 
<style>
body{
 background: #ffffe0;
 padding: 10px;
}
#input_form{
 position: fixed;
 bottom: 10px;
 right: 20px;
 border-radius: 6px;
 background-color: rgba(255, 80, 0, 0.8);
 padding: 20px 15px;
}
#text_box{
 width: 500px;
 height: 80px;
 overflow: scroll;
 border: green 3px solid;
}
</style>
</head> 
<body> 
<b style="font-size:35px; ">おすすめのゲームについて</b><br>
<pre>
<?php
$f = file_get_contents("5.txt");
$item = explode("\n<END>\n", $f);
for($i = 0; $i < count($item) - 1; $i++){
list($header, $body) = explode("\n", $item[$i], 2);
list($date, $ip, $host, $name) = explode(',', $header);
list($text, $imgfile) = explode("\n<IMG>\n", $body);
echo '<font color="#008000"><b>'.($i+1).": $date $host($ip) $name</b></font>\n";
echo htmlspecialchars($text);
echo "\n\n";
if($imgfile != ""){
echo "<img src = './upload/$imgfile' width = '450px'>";
}
echo "\n\n";
//if( md5($_POST['adminpasswd']) == '9e5d905f28593fc6cfd1c4a0c3c99d65' ){
//}else{
//}
}
?>
</pre>
<form enctype="multipart/form-data" id="input_form" action="5_submit.php" method="POST">
<input type="text" name="name" size=20 placeholder="氏名"><br> 
<textarea name="body" id="text_box" rows=4 cols=80 placeholder="本文の入力"></textarea><br>
添付ファイル：<input type="file" name="upfile" size=100><br>
<input type="submit" name="post_text" value=" 記事を投稿する">
</form>
<//form action="5_delete.php" method="post">
<//input type="number" name = "delete" placeholder="削除対象番号">
<//input type="submit" value = "削除">
<///form>
</body> 
</html>
