<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$eval = new evaluation;

$case = $eval->current_state();
var_dump($case);
?>
<div class="temp_wrapper">
<? if($case=="start") {?>
<div class="start mainform pure-skin-dbproj">
	<h1>모집 시작</h1>
	<form method="post">
		<p class="submit">
			<a data-func="eval_func" class="pure-button submit ajax_load" type="button" name="commit">모집 시작!</a>
		</p>
	</form>
	<script type="text/javascript">
	// class명이 start인 객체 > form 객체 > a객체 중 class명이 submit인 객체
	$(".start form a.submit")
	// 클릭 이벤트 시작시
	.on('start', function (event, args, option) {
			// 서버에 전달할 데이터를 args에 넣음
			args.func_type = "모집시작";
			return true;
		}
	// 클릭 이벤트 종료시 (= 서버에서 데이터를 정상적으로 받아온 경우)
	).on('finish', function (event, item, data) {
			view_change_start();
			load_view('main', function(data) {
				view_change_finish();
				//menu_init();
			});
			
			return true;
		}
	);
	</script>
</div>
<? } if($case == "recruiting") {?>
<div class="recruit mainform pure-skin-dbproj">
	<h1>평가 시작</h1>
	<form method="post">
		<p class="submit">
			<a data-func="eval_func" class="pure-button submit ajax_load" type="button" name="commit">평가 시작!</a>
		</p>
	</form>
	<script type="text/javascript">
	// class명이 start인 객체 > form 객체 > a객체 중 class명이 submit인 객체
	$(".recruit form a.submit")
	// 클릭 이벤트 시작시
	.on('start', function (event, args, option) {
			// 서버에 전달할 데이터를 args에 넣음
			args.func_type = "평가시작";
			return true;
		}
	// 클릭 이벤트 종료시 (= 서버에서 데이터를 정상적으로 받아온 경우)
	).on('finish', function (event, item, data) {
			view_change_start();
			load_view('main', function(data) {
				view_change_finish();
				//menu_init();
			});
			
			return true;
		}
	);
	</script>
</div>
<? } if($case == "evaling") {?>
<div class="eval mainform pure-skin-dbproj">
	<h1>평가 끝</h1>
	<form method="post">
		<p class="submit">
			<a data-func="eval_func" class="pure-button submit ajax_load" type="button" name="commit">평가 끝!</a>
		</p>
	</form>
	<script type="text/javascript">
	// class명이 start인 객체 > form 객체 > a객체 중 class명이 submit인 객체
	$(".eval form a.submit")
	// 클릭 이벤트 시작시
	.on('start', function (event, args, option) {
			// 서버에 전달할 데이터를 args에 넣음
			args.func_type = "평가끝";
			return true;
		}
	// 클릭 이벤트 종료시 (= 서버에서 데이터를 정상적으로 받아온 경우)
	).on('finish', function (event, item, data) {
			view_change_start();
			load_view('main', function(data) {
				view_change_finish();
				//menu_init();
			});
			
			return true;
		}
	);
	</script>
</div>
<? } ?>
</div>