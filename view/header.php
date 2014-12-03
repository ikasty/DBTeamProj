<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
$noti_message = $_SESSION["noti-message"];
$_SESSION["noti-message"] = "";
?>
<!-- header -->
<section id="header">
<? if (isset($noti_message) && $noti_message !== "") : ?>
	<div style="display:none;"><div class="mainform notice">
		<?=str_replace("\n", "<br>", $noti_message);?>
		<span id="notice-close-btn" class="octicon octicon-x"></span>
	</div></div>
<? endif; ?>
</section>

<!-- contents -->
<section id="contents">