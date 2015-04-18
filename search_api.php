				<table class="pure-table search_table">
					<thead>
						<tr>
							<th>ID</th>
							<th>地点</th>
							<th>住所</th>
						</tr>
					</thead>
					<tbody>
<?php
$search_type = $_REQUEST["type"];
$search_word = $_REQUEST["word"];
require("./template_login.php");

// 条件分岐
if($search_type=="name") {
	$field = "name";
} else if($search_type=="address") {
	$field = "address";
} else {
	// none
}

// 検索にHITしたデータ数の取得
$query_a = mysql_query("SELECT COUNT(*) FROM sensorlist WHERE $field LIKE '%{$search_word}%'");
$sql_a = mysql_fetch_assoc($query_a);
	$search_num = $sql_a["COUNT(*)"];

// ループで出力
for($num=0; $num < $search_num; $num++) {
$query_b = mysql_query("SELECT * FROM sensorlist WHERE $field LIKE '%{$search_word}%' limit $num,1");
$sql_b = mysql_fetch_assoc($query_b);
	$id = $sql_b['id'];
	$name = $sql_b['name'];
	$address = $sql_b['address'];

echo <<<EOF
					<tr>
						<td>{$id}</td>
						<td><a href="./top.php?id={$id}">{$name}</a></td>
						<td>{$address}</td>
					</tr>\n
EOF;
}

?>
					</tbody>
				</table>
<?php $close_flag = mysql_close($link); ?>
