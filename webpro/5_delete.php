<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8"/>
</head>
<body>
<b>Web 掲示板 ここにテーマを記入(18 文字以下)</b><br><br>
<pre>
<?php

    // 削除対象番号を受信受信した削除対象番号を変数に代入
$delete = $_POST["delete"];

    // ファイルを開く
$f = fopen("5.txt", "w");

if($delete="削除対象番号"){
	fclose($f);
	echo "削除対象が見つかりません。";
	echo '<a href="5.php">掲示板に戻る</a><br><br>';
}else{
    // ファイルの中身を1行1要素として配列変数に代入する
$lines = file($f,FILE_IGNORE_NEW_LINES);

    // ファイルの行数の数だけ繰り返し処理を行う
for ($i = 0; $i < count($lines); $i++){

        // 区切り文字「<>」で分割
 $line = explode("<END>", $lines[$i]);

        // 投稿番号の取得
 $postnum = $line[0];

        // 投稿番号と削除対象番号が一致しない場合、書き込む
 if ($postnum != $delete){ 
  fwrite("5.txt", $lines[$i].PHP_EOL);
        }
    }

    // ファイルを閉じる
fclose($f);
 echo "削除しました。";
 echo '<a href="5.php">掲示板に戻る</a><br><br>';
}
?>
</pre>
</body>
</html>

