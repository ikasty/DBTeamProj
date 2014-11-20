<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// debug mode
//define('DEBUG');

// 자동 로그아웃 타임
define("AUTO_LOGOUT_TIME", 900);

// DB Settings
$db_setting = array(
	"db_name"	=> "dbproj",
	"db_host"	=> "localhost",
	"db_id"		=> "dbproj",
	"db_pw"		=> "dbproj"
);

$css_headers = array();
$js_headers = array();

// default
$css_headers[] = 'style';

// jquery
$js_headers[] = 'jquery-2.1.1.min';
$js_headers[] = 'jquery.blockUI';

// menu
$css_headers[] = 'menu';
$js_headers[] = 'menu';

// class helper func
$js_headers[] = 'classie';

// icons
$css_headers[] = 'icons';
$css_headers[] = 'octicons';

// view
//   login
$css_headers[] = 'login';


// ajax load
$js_headers[] = 'ajax_load';