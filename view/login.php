<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>
<div class="login mainform">
	<h1>System Login</h1>
	<form method="post">
		<p><input type="text" name="login" value="" placeholder="Username"></p>
		<p><input type="password" name="password" value="" placeholder="Password"></p>
		<p class="submit">
			<input data-func="do_login" data-func-arg="login_args" data-func-end="login_finish"
			class="button submit ajax_load" type="button" name="commit" value="Login">
		</p>
	</form>
</div>