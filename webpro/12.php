<!DOCTYPE html> 
<html lang="ja"> 
<head> 
<meta charset="UTF-8"/>
<style>
body{
  text-align: center;
}
.button{
  display: inline-block;
  text-decoration: none;
  background: #87befd;
  color: #000;
  width: 30px;
  height: 30px;
  line-height: 30px;
  text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
  border-radius: 50%;
  overflow: hidden;
  transition: .4s;
}
.button:hover {
  background: #668ad8;
}
.button1{
  display: inline-block;
  padding: 0.5em 1em;
  text-decoration: none;
  font-weight: bold;
  border-radius: 4px;
  color: #000;
  text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
  background-image: linear-gradient(#6795fd 0%, #87befd 100%);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.29);
  border-bottom: solid 3px #5e7fca;
}
.button1:active {
  -webkit-transform: translateY(4px);
  transform: translateY(4px);
  box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.2);
  border-bottom: none;
}
.button1:hover {
  background: #668ad8;
}
.button2{
  display: inline-block;
  padding: 0.5em 1em;
  text-decoration: none;
  font-weight: bold;
  border-radius: 4px;
  color: #000;
  text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
  background-image: linear-gradient(#ff6347 0%, #ff7f50 100%);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.29);
  border-bottom: solid 3px #d2691e;
}
.button2:active {
  -webkit-transform: translateY(4px);
  transform: translateY(4px);
  box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.2);
  border-bottom: none;
}
.button2:hover {
  background: #ff6347;
}
.textbox{
  padding: 0.5em 1em;
  margin: 2em 0;
  color: #87befd;
  background: white;
  border-top: solid 5px #87befd;
  box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
}
.textbox1{
  padding: 0.5em 1em;
  margin: 2em 0;
  color: #ff8c00;
  background: white;
  border-top: solid 5px #ff8c00;
  box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
}
.eiwa{
  margin:2em 0;
  position: relative;
  padding: 0.25em 1em;
  border: solid 2px #87befd;
  border-radius: 20px 0 20px 0;
  background-color:  rgba(87, 124, 224, 0.2);
}
.waei{
  margin:2em 0;
  position: relative;
  padding: 0.25em 1em;
  border: solid 2px #ff8c00;
  border-radius: 0 20px 0 20px;
  background-color:  rgba(255, 92, 0, 0.2);
}
.test{
  margin:2em 0;
  position: relative;
  padding: 0.25em 1em;
  border: solid 2px #87befd;
  border-radius: 20px 0 20px 0;
  background-color:  rgba(87, 124, 224, 0.2);
}
</style> 
</head> 
<body> 
<h2>英単語学習サービス</h4> 
<div class="eiwa">
<b>英和辞典</b><br> 
<form action="12-1.php" method="POST"> 
<input type="text" class="textbox" name="word" size=20 placeholder="単語を入力して下さい"><br> 
<input type="submit" class="button1" value="意味を表示する"> 
</form><br>
</div>
<div class="waei">
<b>和英辞典</b><br>
<form action="12-3.php" method="POST">
<input type="text" class="textbox1" name="meaning" size=20 placeholder="日本語を入力して下さい"><br>
<input type="submit" class="button2" value="単語を表示する">
</form><br>
</div>
<div class="test">
<b>語彙力テスト(英単語から日本語)</b><br>
<form action="12-2.php" method="POST">
<?php
 session_start();
 $con = mysqli_connect('localhost','i088omor','') or die("接続失敗");
 mysqli_select_db($con, 'i088omor') or die("選択失敗");
 mysqli_query($con, 'SET NAMES utf8');
 $sql = "SELECT * FROM user WHERE dt1 is not null";
 $res = mysqli_query($con, $sql) or die("エラー");
 $d = array(); // この行を追加してください
 while ($db = mysqli_fetch_assoc($res)) {
 $d[$db['level'] * 1000 + $db['id'] * 1000 - 1] = 1;
 }
 echo "あなたの得点：".count($d)."<br>";
 while(1){
 $r = rand(1000, 5999);
 if( !isset($d[$r]) ) break;
 }
 $level = (int)($r / 1000);
 $id = $r % 1000 + 1;
 $sql = "SELECT * FROM svl5000 WHERE level=$level and id=$id";
 $res = mysqli_query($con, $sql) or die("エラー");
 $db = mysqli_fetch_assoc($res);
 echo $db['word']."の意味は下記の中のどれでしょうか？<br>";
 $meaning = $db['meaning'];
 $rp = rand(1, 5);
 $_SESSION['level'] = $level;
 $_SESSION['id'] = $id;
 $_SESSION['answer'] = $rp;
 for($i = 1; $i <= 5; $i++){
 if( $i == $rp ) {
 echo $i.". ".$meaning."<br>";
 }else{
 $r = rand(1000,5999);
 $level = (int)($r / 1000);
 $id = $r % 1000 + 1;
 $sql = "SELECT * FROM svl5000 WHERE level=$level and id=$id";
 $res = mysqli_query($con, $sql) or die("エラー");
 $db = mysqli_fetch_assoc($res);
 echo $i.". ".$db['meaning']."<br>";
 }
 }
 mysqli_close($con);
?>
<input type="submit" class="button" name="r" value="1">
<input type="submit" class="button" name="r" value="2">
<input type="submit" class="button" name="r" value="3">
<input type="submit" class="button" name="r" value="4">
<input type="submit" class="button" name="r" value="5">
</form>
</div>
</body> 
</html>
