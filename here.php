<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>現在地 - Live_E! GPS</title>
<?php require("./_head.php"); ?>
	<script type="text/javascript">
		// 読込中に表示する画像を追加
		$(function() {
			var load = $('<img>').attr('src', 'gif-load.gif').addClass('load-img');
			$('.gps').after(load);
		});
		
		// ユーザーの現在の位置情報を取得
		navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

		// 取得
		function successCallback(position) {
			var glocation_a = position.coords.latitude;
			var glocation_b = glocation_a + position.coords.longitude;
			
			// Ajaxで読み込み
			$(function(){
				$("div.gps").load("./here_api.php?latitude=" + position.coords.latitude + "&longitude=" + position.coords.longitude);
				$("img.load-img").remove();
			});
			
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
		document.getElementById("geo").innerHTML = err_msg;
					// Ajaxで読み込み
		$(function(){
			$("img.load-img").remove();
		});
			// none
		}
	</script>
</head>
<body>
<div id="wrap">
	<?php require("./_header.php"); ?>
	<div class="pure-g container">
			<div class="blank-space">
			<h2>現在地</h2>
				<div class="gps"></div>
			</div>
	</div>
	<footer>
		<p>Copyright 2013 tamakagi.com All rights reserved.</p>
	</footer>
</div>
</body>
</html>
