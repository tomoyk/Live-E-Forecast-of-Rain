<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>トップ - Live_E! GPS</title>
<?php require("./_head.php"); ?>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC6n-DVzT4kVDg9G84YULNS-2QhAnVBMQw&sensor=false"></script>
</head>
<body>
<?php

if( isset($_GET['latitude']) && isset($_GET['longitude']) ) {
  //require("./template_login.php");// DB接続
  $latitude = $_GET['latitude'];
  $longitude = $_GET['longitude'];
  require("./template_login.php");
  // 現在地の座標をパラメーターから取得してDBで検索して表示
  $query_a = mysql_query("SELECT id,point_id,name,address,longitude,latitude,total,longitude-$longitude as lon,latitude-$latitude as lat FROM sensorlist ORDER BY abs(longitude-$longitude)+abs(latitude-$latitude) limit 0,1");
  $sql_a = mysql_fetch_assoc($query_a);
  echo "<script>location.href='./top.php?id=".$sql_a["id"]."';</script>";
}

$id_url = $_GET["id"];
	if($id_url=="") {
		$id_url = 31;
	}
require("./template_login.php");

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

// 指定IDの地点情報を出力
$query_b = mysql_query("SELECT * FROM sensorlist WHERE id = $id_url LIMIT 1");
$sql_b = mysql_fetch_assoc($query_b);
	$name = $sql_b['name'];
	$latitude = $sql_b['latitude'];
	$longitude = $sql_b['longitude'];

$close_flag = mysql_close($link);

/* 不快指数関係 */
$output_hukai = floor(0.81 * $Temperature + 0.01 * $Humidity * (0.99 * $Temperature - 14.3) + 46.3);
if ($output_hukai>=85) { // 85以上
	$output_phrase = "大変暑いです。熱中症に気をつけてください。アイスやかき氷が美味しいですね。";
} elseif ($output_hukai>=80) {
	$output_phrase = "とても暑いです。こまめな水分補給を心がけましょう。熱中症対策は万全に！！";
} elseif ($output_hukai>=75) {
	$output_phrase = "暑いです。外での運動は気をつけて行いましょう。";
} elseif ($output_hukai>=70) {
	$output_phrase = "暖かく感じられます。半袖でも過ごしやすい環境です。";
} elseif ($output_hukai>=65) {
	$output_phrase = "快適に感じられる気象状態です。";
} elseif ($output_hukai>=60) {
	$output_phrase = "過ごしやすく特に何も感じらません。";
} elseif ($output_hukai>=55) {
	$output_phrase = "肌寒く感じられそうです。体調管理に気をつけましょう。";
} elseif ($output_hukai<55) { // 55未満
	$output_phrase = "寒いです。外出する際は暖かい服装をしましょう。";
}

?>

<div id="wrap">
	<?php require("_header.php"); ?>
	<div class="pure-g container">
		<div class="blank-space">
			<h2>トップ</h2>
			<p class="marquee">現在の気象状態は<?php echo $output_phrase; ?>気象データは約30分おきに更新されます。</p>
			<div id="map-area" class="gps">地図を表示</div>
  		  
			  <div class="panel panel2">
				  <span class="label">地点</span>
				  <span class="value"><?php echo $name; ?></span>
			  </div>
			  <div class="panel">
				  <span class="label">湿度</span>
				  <span class="value"><?php echo $Humidity; ?>%</span>
			  </div>
			  <div class="panel">
				  <span class="label">雨量</span>
				  <span class="value"><?php echo $RainFall; ?>mm/h</span>
			  </div>
			  <div class="panel">
				  <span class="label">温度</span>
				  <span class="value"><?php echo $Temperature; ?>℃</span>
			  </div>
			  <div class="panel">
				  <span class="label">風向</span>
				  <span class="value">
					  <span style="display: inline-block;transform: rotate(<?php echo $WindDir; ?>deg);">↑</span>
				  <?php echo $WindDir; ?>°</span>
			  </div>
			  <div class="panel clear-float">
				  <span class="label">風速</span>
				  <span class="value"><?php echo $WindSpeed; ?>m/s</span>
			  </div>
			<div class="clear-style"></div>
		</div>
	</div>
	<footer>
		<p>UPDATE: <?php echo $Getmonth; ?>/<?php echo $Getday; ?> <?php echo $Gettime; ?><br>
		Copyright 2013 tamakagi.com All rights reserved.</p>
	</footer>
</div>

<script type="text/javascript">
// 読み込み時に実行
window.onload = function() {      
  // マップ中心の設定
  var latlng = new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>);

  // マップ設定
  var settings = {
    zoom: 17,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  // map生成
  var map = new google.maps.Map(document.getElementById("map-area"), settings);
  
  // マップポイント設定
  var latlng1 = new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>);

  // marker生成
  var mark1 = new google.maps.Marker({
    position: latlng1,
    map: map
  });
}
</script>
<?php

if( !isset($_GET['id']) && !isset($_GET['latitude']) && !isset($_GET['longitude']) ){
echo <<<EOM
<script type="text/javascript">
  // ユーザーの現在の位置情報を取得
  navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

  // 取得
  function successCallback(position) {
    var glocation_a = position.coords.latitude;
    var glocation_b = position.coords.longitude;
    
    location.href = "./top.php?latitude=" + glocation_a +"&longitude="+ glocation_b;
  }

  // 位置情報が取得できない場合
  function errorCallback(error) {
    var err_msg = "";
    // 画像削除
    switch(error.code) {
      case 1:
        err_msg = "位置情報の利用が許可されていません";
        break;
      case 2:
        err_msg = "デバイスの位置が判定できません";
        break;
      case 3:
        err_msg = "タイムアウトしました";
        break;
      default:
        // none
        break;
      }
    alert(err_msg);
  }
</script>
EOM;
}
?>
</body>
</html>
