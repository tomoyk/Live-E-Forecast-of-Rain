<?php
// ini_set( "display_errors", "On");

// $xml =  simplexml_load_file('./live-e.xml');
$xml =  simplexml_load_file('http://live-e.naist.jp/data/getLatestDataAll/');
// var_dump($xml);

$now_date = date("Y-m-d H:i:s", time());
// echo $now_date;
// echo "<table>";

// DB接接続（読み込み）
require("template_login.php");
if (!$link) die('接続失敗です。'.mysql_error());
// DBテーブル選択
$db_selected = mysql_select_db('tomoyk_live-e', $link);
if (!$db_selected) die('データベース選択失敗です。'.mysql_error());
// ***文字コード設定
mysql_set_charset('utf8');

for($i=0;$i < count($xml);$i++) {
  // 変数の初期化
  $sensor["CO2"]=$sensor["DayRainFall"]=$sensor["Humidity"]=$sensor["MaxWindSpeed"]=0;
  $sensor["Pressure"]=$sensor["RainFall"]=$sensor["Temperature"]=$sensor["WindDir"]=$sensor["WindSpeed"]=0;
  // 地点情報の取得
  $id[$i] = $xml->sensorGroup[$i]->attributes()->id;
  $address[$i] = $xml->sensorGroup[$i]->attributes()->address;
  $latitude[$i] = $xml->sensorGroup[$i]->attributes()->latitude;
  $location[$i] = $xml->sensorGroup[$i]->attributes()->location;
  $longitude[$i] = $xml->sensorGroup[$i]->attributes()->longitude;
  /* センサー情報デバッグ(テーブル)
  echo <<< EOM
  <tr>
    <td>{$id[$i]}</td>
    <td>{$address[$i]}</td>
    <td>{$latitude[$i]}</td>
    <td>{$location[$i]}</td>
    <td>{$longitude[$i]}</td>
  </tr>
  EOM;
  */
  // 各センサー値を取得
  for($j=0;$j<count($xml->sensorGroup[$i]);$j++){
    $sensor_type = $xml->sensorGroup[$i]->sensor[$j]->attributes()->sensorType;
    $sensor_value = $xml->sensorGroup[$i]->sensor[$j]->value[0];
    if($sensor_value==""){
      $sensor["$sensor_type"] = 0;
    }else{
      $sensor["$sensor_type"] = $sensor_value;
    }
    /* エラー回避
    if(array_key_exists('sensor',$xml)) echo "err\n";
    */
    /* センサー(タイプ，値)デバッグ
    echo "{$i}_{$j}_{$sensor_type}_{$sensor_value}\n";
    */
  }
  // ***クエリの実行
  $sql = "SELECT * FROM sensorlist WHERE point_id LIKE '%{$id[$i]}%'";
  $result = mysql_query($sql);
  if (!$result) echo('クエリー1が失敗しました。'.mysql_error());
  // ***クエリの結果
  $sqldb = mysql_fetch_assoc($result);
  
  // ***クエリの実行
  $sql2 = "INSERT INTO test2 (CO2,DayRainFall,Humidity,MaxWindSpeed,Pressure,RainFall,Temperature,WindDir,WindSpeed,Gettime,id) VALUES ($sensor[CO2],$sensor[DayRainFall],$sensor[Humidity],$sensor[MaxWindSpeed],$sensor[Pressure],$sensor[RainFall],$sensor[Temperature],$sensor[WindDir],$sensor[WindSpeed],'$now_date',$sqldb[id])";
  echo $sql2."\n";
  $result2 = mysql_query($sql2);
  if (!$result2) echo('クエリー2が失敗しました。'.mysql_error());
  // ***クエリの結果
  $sqldb2 = mysql_fetch_assoc($result2);
}

// echo "</table>";
// DB接続の切断
$close_flag = mysql_close($link);
?>
