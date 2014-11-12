<?
/**
 * DB 조별과제 Main view
 * by 강대연
 * 2014-11-12
 */


/**
 * 앞으로 view를 제외한 모든 파일들은 이 index 파일을 통해서 접근된다.
 * 파일 맨 위에 다음 문장을 넣고 적합성 테스트 할 것.
 * if (!defined("DBPROJ")) die(-1);
 */
define("DBPROJ");

// session start
session_start();

// routing table
if ( !isset($_SESSION['id']) ) {
	include('view/login.php');
}
else {
	$current = $_SESSION['id'];
	include('view/main.php');
}

// include classes


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
	<link rel="stylesheet" href="css/style.css">
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<? execute_view(); ?>
</body>
</html>