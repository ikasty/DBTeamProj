<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>
<div class="temp_wrapper">
<div class="login mainform">
	<h1>System Login</h1>
	<form method="post">
		<p><input type="text" name="login" value="" placeholder="Username"></p>
		<p><input type="password" name="password" value="" placeholder="Password"></p>
		<p class="submit">
			<a data-func="do_login" data-func-arg="login_args" data-func-end="login_finish"
			class="pure-button submit ajax_load" type="button" name="commit">Login</a>
		</p>
	</form>
	<script type="text/javascript">
	$(".login form a.submit")
	.on('args',
		function (event, args) {
			args.userid = $('.login input[type=text]').val();
			args.password = Base64.encode($('.login input[type=password]').val());
			return true;
		}
	).on('finish',
		function (event, item, data) {console.log(item, data);
			if (data.success == 'failed') {
				$(item).parents(".login").parent().effect("shake", {distance: 4, times: 3, duration: 10});
				$('.login input[type=password]').val('');
			} else {

			}
		}
	);
	</script>
</div>
</div>