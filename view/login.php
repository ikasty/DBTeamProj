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
	$(".login form a.submit")
	.on('start', function (event, args) {
			args.userid = $('.login input[type=text]').val();
			args.password = Base64.encode($('.login input[type=password]').val());
			return true;
		}
	).on('finish', function (event, item, data) {
			if (data.success == 'failed') {
				$(item).parents(".login").parent().effect("shake", {distance: 4, times: 3, duration: 10});
				$('.login input[type=password]').val('');
			} else {
				view_change_start();
				load_view('main', function(data) {
					view_change_finish();
					menu_init();
				}, 'true');
			}
			return true;
		}
	);
	</script>
</div>
</div>