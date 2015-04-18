<?php

require("./template_login.php");// DB接続

// パラメータで受け取った値
$latitude = $_REQUEST["latitude"];
$longitude = $_REQUEST["longitude"];

// 現在地の座標をパラメーターから取得してDBで検索して表示   0
$query_a = mysql_query("SELECT id,name,address,longitude,latitude,total,longitude-$longitude as lon,latitude-$latitude as lat 
	FROM sensorlist ORDER BY abs(longitude-$longitude)+abs(latitude-$latitude) limit 0,1");
$sql_a = mysql_fetch_assoc($query_a);

// 現在地の座標をパラメーターから取得してDBで検索して表示   1
$query_w = mysql_query("SELECT id,name,address,longitude,latitude,total,longitude-$longitude as lon,latitude-$latitude as lat 
	FROM sensorlist ORDER BY abs(longitude-$longitude)+abs(latitude-$latitude) limit 1,1");
$sql_w = mysql_fetch_assoc($query_w);

// 現在地の座標をパラメーターから取得してDBで検索して表示   2
$query_x = mysql_query("SELECT id,name,address,longitude,latitude,total,longitude-$longitude as lon,latitude-$latitude as lat 
	FROM sensorlist ORDER BY abs(longitude-$longitude)+abs(latitude-$latitude) limit 2,1");
$sql_x = mysql_fetch_assoc($query_x);

// 現在地の座標をパラメーターから取得してDBで検索して表示   3
$query_y = mysql_query("SELECT id,name,address,longitude,latitude,total,longitude-$longitude as lon,latitude-$latitude as lat 
	FROM sensorlist ORDER BY abs(longitude-$longitude)+abs(latitude-$latitude) limit 3,1");
$sql_y = mysql_fetch_assoc($query_y);

// 現在地の座標をパラメーターから取得してDBで検索して表示   4
$query_z = mysql_query("SELECT id,name,address,longitude,latitude,total,longitude-$longitude as lon,latitude-$latitude as lat 
	FROM sensorlist ORDER BY abs(longitude-$longitude)+abs(latitude-$latitude) limit 4,1");
$sql_z = mysql_fetch_assoc($query_z);

// echo 'あなたの送信した緯度は'.$latitude.'<br>';
// echo 'あなたの送信した経度は'.$longitude.'<br>';

$map_image = "http://maps.google.com/maps/api/staticmap?&center=".$latitude.",".$longitude."&zoom=12&size=450x450&sensor=false&markers=color:red|".$latitude.",".$longitude."&markers=color:blue|label:A|".$sql_a['latitude'].",".$sql_a['longitude']."&markers=color:yellow|label:B|".$sql_w['latitude'].",".$sql_w['longitude']."&markers=color:green|label:C|".$sql_x['latitude'].",".$sql_x['longitude']."&markers=color:orange|label:D|".$sql_y['latitude'].",".$sql_y['longitude']."&markers=color:purple|label:E|".$sql_z['latitude'].",".$sql_z['longitude'];

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
</ul>

<?php $close_flag = mysql_close($link); ?>
