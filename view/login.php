<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// force logout
unset($_SESSION['id']);

?>
<div class="temp_wrapper">
<div class="login mainform pure-skin-dbproj">
	<h1>System Login</h1>
	<form method="post">
		<p><input type="text" name="login" value="" placeholder="Username"></p>
		<p><input type="password" name="password" value="" placeholder="Password"></p>
		<p class="submit">
			<a data-func="do_login" class="pure-button submit ajax_load" type="button" name="commit">Login</a>
		</p>
	</form>
	<script type="text/javascript">
	// class명이 login인 객체 > form 객체 > a객체 중 class명이 submit인 객체
	$(".login form a.submit")
	// 클릭 이벤트 시작시
	.on('start', function (event, args, option) {
			// 서버에 전달할 데이터를 args에 넣음
			args.userid = $('.login input[type=text]').val();
			args.password = $('.login input[type=password]').val();

			if (args.userid == '' || args.password == '') {
				// option.success = false로 하면 버튼 클릭이 중지됨. 기본값은 true
				option.success = false;

				// 실패한 것처럼 finish 수행
				$(this).trigger('finish', [$(this), {'success':'failed'}]);

				// 혹시 모르니 false 리턴
				return false;
			}

			// 패스워드 암호화
			args.password = Base64.encode(args.password);
			return true;
		}
	// 클릭 이벤트 종료시 (= 서버에서 데이터를 정상적으로 받아온 경우)
	).on('finish', function (event, item, data) {
			// item == 클릭한 버튼 객체, data == 서버에서 받아온 데이터
			if (data.success == 'failed') {
				$(item).parents(".login").parent().effect("shake", {distance: 4, times: 7, duration: 30});
				$('.login input[type=password]').val('');
			} else {
				view_change_start();
				load_view('main', function(data) {
					view_change_finish();
					menu_init();
				}, {menu_reload:'true'});
			}
			return true;
		}
	);
	</script>
</div>
</div>