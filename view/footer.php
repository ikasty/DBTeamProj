<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// ajax key generate
if (!isset($_SESSION['AJAXKEY']))
	$_SESSION['AJAXKEY'] = md5(microtime().rand());
$ajaxkey = $_SESSION['AJAXKEY'];

?>
</section>

<!-- footer -->
<section id="footer">

<!-- nav -->
<!-- original work from [http://tympanus.net/] -->
<nav id="bt-menu" class="bt-menu">
<? printMenuContents(); ?>
</nav>

</section>

<script type="text/javascript">var ajaxkey = "<?=$ajaxkey?>";</script>