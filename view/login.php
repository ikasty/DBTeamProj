<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>
<div class="login mainform">
	<h1>Server Login</h1>
	<form method="post" action="index.html">
		<p><input type="text" name="login" value="" placeholder="Username"></p>
		<p><input type="password" name="password" value="" placeholder="Password"></p>
		<p class="submit"><input class="button" type="submit" name="commit" value="Login"></p>
	</form>
</div>