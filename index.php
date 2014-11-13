<?
/**
 * DB 조별과제 Main view
 * by 강대연
 * 2014-11-13
 */

// get entry point
define("DBPROJ", true);
/**
 * 앞으로 모든 파일들은 이 index 파일을 통해서 접근된다.
 * 파일 맨 위에 다음 문장을 넣고 적합성 테스트 할 것.
 * if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
 */

// session start
session_start();

// routing table
if ( !isset($_SESSION['id']) ) {
	$menu_type = false;
	$content_include_file = 'view/login.php';
}
else {
	$menu_type = 'main';
	$content_include_file = 'view/main.php';
}

// include settings
include('settings.php');

// debug mode
if (defined('DEBUG') && isset($_GET['page'])) $content_include_file = 'view/' . $_GET['page'] . '.php';

// ajax key generate
if (!isset($_SESSION['AJAXKEY']))
	$_SESSION['AJAXKEY'] = md5(microtime().rand());
$ajaxkey = $_SESSION['AJAXKEY'];

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
	<style type="text/css">
<? printMenuHeader(); ?>
	</style>
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript">
		var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
	</script>
</head>
<body>

<div id='container' class='container'>

<? include('view/header.php'); ?>
<? include($content_include_file); ?>
<? include('view/footer.php'); ?>

</div>

<? foreach($js_headers as $header) : ?>
<script type="text/javascript" src="js/<?=$header?>.js"></script>
<? endforeach; ?>
<script type="text/javascript">var ajaxkey = "<?=$ajaxkey?>";</script>
<div id="throbber" style="display:none;"><img src="/image/throbber.gif"/></div>

</body>
</html>