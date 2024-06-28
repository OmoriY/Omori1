#!/usr/bin/php
<?php
  foreach(file('/usr/share/dict/words') as $line){
// strpos() 関数を使って、文字列 "abc" が含まれる単語を echo "$line"; で表示しなさい。
	  if(strpos($line, 'abc') !== false) echo "$line";
  } 
?>
