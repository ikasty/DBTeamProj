<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
$noti_message = $_SESSION["noti-message"];
$_SESSION["noti-message"] = "";
?>

<!-- header -->
<section id="header">
	<!-- notice -->
	<div class="notice"><div class="mainform" style="background:transparent;">
		<span id="notice-message">
		<?
			if (isset($noti_message) && $noti_message !== "") {
				echo str_replace("\n", "<br>", $noti_message);
			}
		?>
		</span>
		<span id="notice-close-btn" class="octicon octicon-x"></span>
	</div></div>
</section>

<!-- contents -->
<section id="contents">