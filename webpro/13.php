<!DOCTYPE html> 
<html lang="ja"> 
<head> 
<meta charset="UTF-8"/> 
<title>写真データベース</title> 
<style>
body{
background: #5599ff;
}
h3{color:#fff}
p{color:#fff}
</style>
<script type="text/javascript" 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzK1MNll10T76kaYCf3eFxhzmvbQ6Hf0c&libraries=geometry&langu
age=ja"> 
</script> 
<script type="text/javascript" src="https://zeptojs.com/zepto.min.js"></script> 
</head> 
<body>
<h3>おすすめの写真</h3>
<p>マップをズームすることで、表示されている範囲の写真を見ることが出来ます。</p>
<div id="map" style="width:100%; height:600px"></div> 
<script type="text/javascript"> 
var clat = 33.849231; 
var clng = 132.769846; 
var zoom = 8; 
var swlat; //南西の角の緯度 
var swlng; //南西の角の経度 
var nelat; //北東の角の緯度 
var nelng; //北東の角の経度 
var marker = []; //マーカー
var db = []; //写真データベース 
function update() 
{ 
 var table = "<table border=1 cellspacing=0>\n<tr>"; 
 var cnt = 0; 
 for(i = 0; i < db.length; i+=7 ){ 
 if( (swlat < db[i+3]) && (db[i+3] < nelat) && (swlng < db[i+4]) && (db[i+4] < nelng) ){ 
 table += "<td><a target=\"photo\" href=\"/~" + db[i] + "/photo/" + db[i+1] + "\">"; 
 table += "<img src=\"/~" + db[i] + "/photo/" + db[i+1] + "\" width=192></a><br>"; 
 table += '<font size="-1">' + db[i+6] + '</font></td>'; 
 cnt++; 
 if( cnt == 20 ) break; 
 if( cnt % 5 == 0 ) table += "</tr>\n<tr>"; 
 } 
 } 
 table += "</tr>\n</table>\n"; 
 table += (db.length / 7) + "件中 " + cnt + "件ありました。（最大 20 件の表示)<br><br>\n"; 
 document.getElementById("list").innerHTML = table; 
} 
function set_db() 
{ 
 var _d = new Date().getTime(); 
 $.get("13.csv" + "?_d=" + _d, function(data){ 
 db = []; 
 var a = data.split("\n"); //改行で区切る 
 for(i = 0; i < a.length - 1; i++){ 
 var b = a[i].split(","); //カンマで区切る 
 for(j = 0; j < b.length; j++){ 
 db[i*7+j] = b[j]; 
 } 
 } 
 display(); 
 });
 }
function update_all()
{
 var _d = new Date().getTime();
 $.get("13_makecsv.php" + "?_d=" + _d, function(data){
 document.getElementById("list").innerHTML = data;
 set_db();
 });
}
function bchanged()
{
 var b = map.getBounds();
 var sw = b.getSouthWest();
 var ne = b.getNorthEast();
 swlat = sw.lat();
 swlng = sw.lng();
 nelat = ne.lat();
 nelng = ne.lng();
 zoom = map.getZoom();
}
var map = new google.maps.Map(document.getElementById("map"), {
 zoom:zoom, center:new google.maps.LatLng(clat, clng), mapTypeId:google.maps.MapTypeId.ROADMAP});
google.maps.event.addListener(map, 'bounds_changed', bchanged);
</script>
<input type="button" value="表示エリア内の写真を見る" onClick="update()">
<input type="button" value="写真データベースを更新する" onClick="update_all()">
<div id="list" style="float:left;height:85%;width:100%;overflow-x:scroll;overflow-y:scroll;"></div>
<script type="text/javascript">
var infowindow;
function attachMessage(marker, msg) {
 google.maps.event.addListener(marker, 'click', function(event) {
 if ( infowindow) infowindow.close(); // 開いているウィンドウを閉じる
 infowindow = new google.maps.InfoWindow({content: msg});
 infowindow.open(map, marker);
 });
}
function display()
{
 var ii;
 for(ii = 0; ii < marker.length; ii++) marker[ii].setMap(null);
 marker = [];
 for(i=ii=0; i < db.length; i+=7,ii++){
 marker[ii] = new google.maps.Marker({
 position:new google.maps.LatLng(db[i+3], db[i+4]), map:map, title:db[i] + ' ' + db[i+6],
 icon:'bus1.png'
 });
 var msg ='<a target="photo" href="/~' + db[i] + '/photo/' + db[i+1] + '">'
 + '<img width="480" src="/~' + db[i] + '/photo/' + db[i+1] + '"></a><br>'
 + db[i+3] + ' ' + db[i+4] + ' ' + db[i+5];
 attachMessage(marker[ii], msg);
 }
}
update_all();
</script>
</body>
</html>

