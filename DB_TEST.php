<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Live_E!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
// ***DB接続の確立
require("template_login.php");
if (!$link) die('接続失敗です。'.mysql_error());
// print('<p>接続に成功しました。</p>');

// ***DBテーブルの選択
$db_selected = mysql_select_db('tomoyk_live-e', $link);
if (!$db_selected) die('データベース選択失敗です。'.mysql_error());
// print('<p>live-eデータベースを選択しました。</p>');

// ***文字コード設定
mysql_set_charset('utf8');

// ***クエリの実行
$sql = "SELECT * FROM `sensorlist` WHERE `id` = 1 LIMIT 0, 30 ";
$result = mysql_query($sql);
if (!$result) die('クエリーが失敗しました。'.mysql_error());

// ***DB接続の切断
$close_flag = mysql_close($link);
// if ($close_flag) print('<p>切断に成功しました。</p>');



// 気象データ格納DBから指定IDの最新データを取得
$query = mysql_query("SELECT * FROM test WHERE id = $id_url ORDER BY Gettime DESC LIMIT 1");
$sqldb = mysql_fetch_assoc($query);
	$DayRainFall = $sqldb['DayRainFall'];
	$Humidity = $sqldb['Humidity'];
	$Pressure = $sqldb['Pressure'];
	$RainFall = $sqldb['RainFall'];
	$Temperature = $sqldb['Temperature'];
	$WindDir = $sqldb['WindDir'];
	$WindSpeed = $sqldb['WindSpeed'];
	$dbtime = $sqldb['Gettime'];
	$Getmonth = substr($dbtime, 5, 2);
	$Getday = substr($dbtime, 8, 2);
	$Gettime = substr($dbtime, 11, 5);
?>
</body>
</html>
