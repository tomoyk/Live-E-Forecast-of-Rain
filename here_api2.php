<style>
ul.list5 li {
background: #37CE93;
}
</style>
<?php

require("./template_login.php");// DB接続

// パラメータで受け取った値
$latitude = $_REQUEST["latitude"];
$longitude = $_REQUEST["longitude"];

// 誤差の範囲を指定(緯度の10進法)
// 0.0008998 : 100M
$s_range = 0.0008998 * 50;

// $SQL_CODE ="SELECT id,name,address,longitude,latitude,total,longitude-$longitude as lon,latitude-$latitude as lat FROM sensorlist ORDER BY abs(longitude-$longitude)+abs(latitude-$latitude)";
$SQL_CODE = "SELECT * FROM `sensorlist` WHERE `longitude` < $longitude AND abs(latitude-$latitude) < $s_range ORDER BY abs(longitude-$longitude)";

// Debug
echo $SQL_CODE;

/* キレイにまとめる予定↓ */

// 現在地の座標をパラメーターから取得してDBで検索して表示   0
$query_a = mysql_query("$SQL_CODE limit 0,1");
$sql_a = mysql_fetch_assoc($query_a);
$point_id[0] =  $sql_a['id'];
$point_long[0] =  $sql_a['longitude'];
$point_lati[0] =  $sql_a['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   1
$query_w = mysql_query("$SQL_CODE limit 1,1");
$sql_w = mysql_fetch_assoc($query_w);
$point_id[1] =  $sql_w['id'];
$point_long[1] =  $sql_w['longitude'];
$point_lati[1] =  $sql_w['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   2
$query_x = mysql_query("$SQL_CODE limit 2,1");
$sql_x = mysql_fetch_assoc($query_x);
$point_id[2] =  $sql_x['id'];
$point_long[2] =  $sql_x['longitude'];
$point_lati[2] =  $sql_x['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   3
$query_y = mysql_query("$SQL_CODE limit 3,1");
$sql_y = mysql_fetch_assoc($query_y);
$point_id[3] =  $sql_y['id'];
$point_long[3] =  $sql_y['longitude'];
$point_lati[3] =  $sql_y['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   4
$query_z = mysql_query("$SQL_CODE limit 4,1");
$sql_z = mysql_fetch_assoc($query_z);
$point_id[4] =  $sql_z['id'];
$point_long[4] =  $sql_z['longitude'];
$point_lati[4] =  $sql_z['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   5
$query_aa = mysql_query("$SQL_CODE limit 5,1");
$sql_aa = mysql_fetch_assoc($query_aa);
$point_id[5] =  $sql_aa['id'];
$point_long[5] =  $sql_aa['longitude'];
$point_lati[5] =  $sql_aa['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   6
$query_bb = mysql_query("$SQL_CODE limit 6,1");
$sql_bb = mysql_fetch_assoc($query_bb);
$point_id[6] =  $sql_bb['id'];
$point_long[6] =  $sql_bb['longitude'];
$point_lati[6] =  $sql_bb['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   7
$query_cc = mysql_query("$SQL_CODE limit 7,1");
$sql_cc = mysql_fetch_assoc($query_cc);
$point_id[7] =  $sql_cc['id'];
$point_long[7] =  $sql_cc['longitude'];
$point_lati[7] =  $sql_cc['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   8
$query_dd = mysql_query("$SQL_CODE limit 8,1");
$sql_dd = mysql_fetch_assoc($query_dd);
$point_id[8] =  $sql_dd['id'];
$point_long[8] =  $sql_dd['longitude'];
$point_lati[8] =  $sql_dd['latitude'];

// 現在地の座標をパラメーターから取得してDBで検索して表示   9
$query_ee = mysql_query("$SQL_CODE limit 9,1");
$sql_ee = mysql_fetch_assoc($query_ee);
$point_id[9] =  $sql_ee['id'];
$point_long[9] =  $sql_ee['longitude'];
$point_lati[9] =  $sql_ee['latitude'];

 echo 'あなたの送信した緯度は'.$latitude.'<br>';
 echo 'あなたの送信した経度は'.$longitude.'<br>';

// (はやさm/s)指定した地点の気象データをDBから取り出す
for($i=0;$i<10;$i++){
	$query = mysql_query("SELECT * FROM test WHERE id = $point_id[$i] ORDER BY Gettime DESC limit $i,1");
	$sqldb = mysql_fetch_assoc($query);
	$WindSpeed[$i] = $sqldb['WindSpeed'];
}
// var_dump($WindSpeed);

// (きょりm)現在地の位置情報との差分を絶対値にして計算
for($i=0;$i<10;$i++){
  $absolute_long[$i] = abs($longitude - $point_long[$i]);
  $res_long[$i] = 40077*$absolute_long[$i]/360*100; // 同時にkm->m変換
  // $absolute_lati[$i] = abs($latitude - $point_lati[$i]);
  // $res_lati[$i] = 40009*$absolute_lati[$i]/360*100; // 同時にkm->m変換
}
// var_dump($res_long);

// (じかんs)現在地の位置情報との差分を絶対値にして計算
for($i=0;$i<10;$i++){
  $the_result[$i] = $res_long[$i] / $WindSpeed[$i] / 60;
}
var_dump($the_result);

// マップを読み込み
$map_image = "http://maps.google.com/maps/api/staticmap?&center=".$latitude.",".$longitude."&zoom=10&size=450x450&sensor=false&markers=color:red|".$latitude.",".$longitude."&markers=color:blue|label:A|".$sql_a['latitude'].",".$sql_a['longitude']."&markers=color:yellow|label:B|".$sql_w['latitude'].",".$sql_w['longitude']."&markers=color:green|label:C|".$sql_x['latitude'].",".$sql_x['longitude']."&markers=color:orange|label:D|".$sql_y['latitude'].",".$sql_y['longitude']."&markers=color:purple|label:E|".$sql_z['latitude'].",".$sql_z['longitude']."&markers=color:purple|label:F|".$sql_aa['latitude'].",".$sql_aa['longitude']."&markers=color:purple|label:G|".$sql_bb['latitude'].",".$sql_bb['longitude']."&markers=color:purple|label:H|".$sql_cc['latitude'].",".$sql_cc['longitude']."&markers=color:purple|label:I|".$sql_dd['latitude'].",".$sql_dd['longitude']."&markers=color:purple|label:J|".$sql_ee['latitude'].",".$sqle_ee['longitude'];
?>
<p class="maps-area">
	<a href="https://maps.google.co.jp/maps?q=<?php echo $latitude.','.$longitude; ?>"><img src="<?php echo $map_image; ?>" class="point-maps"></a>
</p>

<ul class="list5">
	<li class="point1">
		<a href="./top.php?id=<?php echo $sql_a['id']; ?>"><span>A</span><?php echo $sql_a['name']; ?></a>
	</li>

	<li class="point2">
		<a href="./top.php?id=<?php echo $sql_w['id']; ?>"><span>B</span><?php echo $sql_w['name']; ?></a>
	</li>

	<li class="point3">
		<a href="./top.php?id=<?php echo $sql_x['id']; ?>"><span>C</span><?php echo $sql_x['name']; ?></a>
	</li>

	<li class="point4">
		<a href="./top.php?id=<?php echo $sql_y['id']; ?>"><span>D</span><?php echo $sql_y['name']; ?></a>
	</li>

	<li class="point5">
		<a href="./top.php?id=<?php echo $sql_z['id']; ?>"><span>E</span><?php echo $sql_z['name']; ?></a>
	</li>

	<li class="point6">
                <a href="./top.php?id=<?php echo $sql_z['id']; ?>"><span>F</span><?php echo $sql_aa['name']; ?></a>
        </li>

	<li class="point7">
                <a href="./top.php?id=<?php echo $sql_z['id']; ?>"><span>G</span><?php echo $sql_bb['name']; ?></a>
        </li>

	<li class="point8">
                <a href="./top.php?id=<?php echo $sql_z['id']; ?>"><span>H</span><?php echo $sql_cc['name']; ?></a>
        </li>

	<li class="point9">
                <a href="./top.php?id=<?php echo $sql_z['id']; ?>"><span>I</span><?php echo $sql_dd['name']; ?></a>
        </li>

	<li class="point10">
                <a href="./top.php?id=<?php echo $sql_z['id']; ?>"><span>J</span><?php echo $sql_ee['name']; ?></a>
        </li>


</ul>

<?php $close_flag = mysql_close($link); ?>
