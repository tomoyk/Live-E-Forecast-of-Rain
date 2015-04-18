<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>地点検索 - Live_E! GPS</title>
  <?php require("./_head.php"); ?>
  <script>
  $(function() {
    // EnterでSubmitを防ぐ
    $(document).on("keypress", "input:not(.allow_submit)", function(event) {
      return event.which !== 13;
    });
    
    $('button.search-point').click(function(){
      result(); // クリック時
    });
    $('#search-word').keyup(function(){
      result(); // 入力時
    });
    function result(){
      var txt_length = $('#search-word').val().length;
      if(txt_length>0){
        // 読込中に表示する画像を追加
        var load = $('<img>').attr('src', 'gif-load.gif').addClass('load-img');
        $('.after-search').after(load);
        // フォーム取得
        var type = $('#search-type').val();
        var word = $('#search-word').val();
        // Ajaxで読み込み
        $("div.after-search").load("./search_api.php?type=" + type + "&word=" + word);
        // 画像の削除
        $("img.load-img").remove();
      }
    }
  });
	
	</script>
</head>
<body>
<div id="wrap">

	<?php require("./_header.php"); ?>

	<div class="pure-g container">
		<div class="pure-u-2-3 main">
			<div class="blank-space">
			<h2>地点検索</h2>
			<form action="" id="search-p" class="pure-form pure-form-stacked">
				<fieldset>
					<legend>地点検索フォーム</legend>
					<label>検索対象</label>
					<select id="search-type" class="pure-input-1 search-point">
						<option value="name">地点名</option>
						<option value="address">住所</option>
					</select>
					<label>検索ワード</label>
					<input type="text" name="in_text" id="search-word" class="pure-input-1 search-point" placeholder="検索する語" required>
				</fieldset>
				<button type="button" class="pure-button pure-input-1 pure-button-primary search-point">検索</button>
			</form>
			<div class="after-search">
			</div>
			</div>
		</div>
		<div class="pure-u-1-3 side">
			<?php require("./_sidebar.php"); ?>
		</div>
	</div>
	<footer>
		<p>Copyright 2013 tamakagi.com All rights reserved.</p>
	</footer>
</div>
</body>
</html>
<?php $close_flag = mysql_close($link); ?>
