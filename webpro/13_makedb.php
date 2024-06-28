<!DOCTYPE html> 
<html lang="ja"> 
<head> 
<meta charset="UTF-8"/> 
<title>写真データベース</title> 
</head> 
<body> 
<pre> 
<?php 
function normalize($v) // GPS 情報は "35/1" のような書式となるので、小数に変換 
{ 
 $frac = explode("/", $v); 
 if( count($frac) != 2 ) return $v; 
 if( $frac[1] == 0 ) return 0; 
 return $frac[0] / $frac[1]; 
} 
function normalizeLatLng($value) // 基本的に、緯度と経度は「度;分;秒」に分かれているので合成 
{ 
 if( count($value) == 1 ){ //「度;分;秒」に分かれていない 
 return normalize($value); // 配列ではなく変数として扱う 
 }else if( count($value) == 3 ){ 
 $degrees = normalize($value[0]); 
 $minutes = normalize($value[1]); 
 $seconds = normalize($value[2]); 
 return $degrees + ( $minutes / 60.0 ) + ( $seconds / 3600 ); 
 } 
} 
exec("find /home/i*/public_html/photo -type d", $find); // 各アカウントの中の写真を漁る 
$con = mysqli_connect('localhost','i088omor','') or die("接続失敗"); 
mysqli_select_db($con, 'i088omor') or die("選択失敗"); //データベース名はアカウントと同一にしてね 
mysqli_query($con, 'SET NAMES utf8'); 
$sql = "TRUNCATE TABLE photo"; //テーブルの中身は一旦全て削除して作り直します 
$res = mysqli_query($con, $sql) or die("テーブル削除に失敗"); 
echo count($find)."個のディレクトリが見つかりました。\n"; 
for($i = 0; $i < count($find); $i++){ 
 if( file_exists("$find[$i]/list.txt") ){ 
 $listfile = file("$find[$i]/list.txt"); 
 $db = []; 
 for($j = 0; $j < count($listfile); $j++){ 
 $a = explode(',', rtrim($listfile[$j])); 
 $db["$find[$i]/$a[0]"] = $a[1]; 
 } 
 } 
 foreach(glob("$find[$i]/*.*") as $full_filename){ 
 $a = explode('/', $full_filename, 6); 
 $account = $a[2]; 
 $filename = $a[5]; 
 if( isset($db[$full_filename]) ) $comment = $db[$full_filename]; 
 else $comment = ''; 
 $lat = $lng = $alt = 'NULL'; 
 $exif = @exif_read_data($full_filename, 0, true); //Exif 情報の取得 
 if( $exif ){ 
 foreach ($exif as $key => $section) { 
 foreach ($section as $name => $value) { 
 if( "$key.$name" == 'EXIF.DateTimeOriginal' ) $date = $value; 
 else if( "$key.$name" == 'GPS.GPSLatitude' ) $lat = normalizeLatLng($value); 
 else if( "$key.$name" == 'GPS.GPSLongitude' ) $lng = normalizeLatLng($value); 
 else if( "$key.$name" == 'GPS.GPSAltitude' ) $alt = normalize($value); 
 } 
 } 
 $sql = "INSERT INTO photo(filename, account, date, lat, lng, alt, comment) "; 
 $sql .= "VALUES('$filename','$account','$date',$lat,$lng,$alt,'$comment')"; 
 echo "$account $filename $date $lat $lng $alt $comment\n"; 
 $res = mysqli_query($con, $sql) or die("追加失敗 $sql"); 
 } 
 } 
} 
mysqli_close($con); 
?> 
</pre> 
<a href="javascript:history.back()">戻る</a> 
</body> 
