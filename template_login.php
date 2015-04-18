<?php

// DB接続
$link = mysql_connect('localhost', 'user', 'password');

// DB選択
mysql_select_db('tomoyk_live-e', $link);

// 文字タイプ選択
mysql_set_charset('utf8');

?>
