<?
/**
 * DB 조별과제 Main view
 * by 강대연
 * 2014-11-12
 */


/**
 * 앞으로 모든 파일들은 이 index 파일을 통해서 접근된다.
 * 파일 맨 위에 다음 문장을 넣고 적합성 테스트 할 것.
 * if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
 */
define("DBPROJ", true);

// session start
session_start();

// include settings
include('settings.php');

// include classes
	/* class include here */

// routing table
if ( !isset($_SESSION['id']) ) {
	$content_include_file = 'view/login.php';
}
else {
	$current = $_SESSION['user_id'];
	$content_include_file = 'view/main.php';
}

// debug mpde
if (defined('DEBUG') && isset($_GET['page'])) $content_include_file = 'view/' . $_GET['page'];

?>
<!DOCTYPE html>
<!-- original work from [ http://www.cssflow.com ] -->
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="ko"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="ko"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="ko"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="ko"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>DBapp</title>

	<? foreach($css_headers as $header) : ?>
	<link rel="stylesheet" href="css/<?=$header?>.css">
	<? endforeach; ?>
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>

<div id='container' class='container'>

<!-- header -->
<section id="header">
	
</section>

<!-- contents -->
<section id="contents">
<? include($content_include_file); ?>
</section>

<!-- footer -->
<section id="footer">
	
</section>

</div>

<!-- nav -->
<!-- original work from [http://tympanus.net/] -->
<nav id="bt-menu" class="bt-menu">
	<a href="#" class="bt-menu-trigger"><span>Menu</span></a>
	<ul>
		<li><a href="#" class="ajax_load octicon octicon-home">Home</a></li>
		<li><a href="#" class="ajax_load octicon octicon-graph">Graph</a></li>
		<li><a href="#" class="ajax_load octicon octicon-cloud-upload">Upload</a></li>
		<li><a href="#" class="ajax_load octicon octicon-law">Vote</a></li>
		<li><a href="#" class="ajax_load octicon octicon-tools">Setting</a></li>
		<li><a href="#" class="ajax_load octicon octicon-signout">Logout</a></li>
	</ul>
</nav>

<? foreach($js_headers as $header) : ?>
<script type="text/javascript" src="js/<?=$header?>.js"></script>
<? endforeach; ?>

<div id="throbber" style="display:none;"><img src="/image/throbber.gif"/></div>

</body>
</html>