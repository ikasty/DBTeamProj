<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// debug mode
//define('DEBUG');

//////////////////////////////////////////////////////
// 자동 로그아웃 타임
define("AUTO_LOGOUT_TIME", 900);

//////////////////////////////////////////////////////
// DB Settings
$db_setting = array(
	"db_name"	=> "dbproj",
	"db_host"	=> "localhost",
	"db_id"		=> "dbproj",
	"db_pw"		=> "dbproj"
);

//////////////////////////////////////////////////////
// include classes
include('include/functions.php');
include('class/user.php');
	/* include classes here */

// menus
$menu_item = array(
/*	array("menu_type", "view name", "icon type", "icon name", "tooltip name", "optional")	*/	
	array("user", "main", "octicon", "home", "Home"),
	array("user", "", "octicon", "graph", "Graph"),
	array("user", "", "octicon", "cloud-upload", "Upload"),
	array("user", "", "octicon", "law", "Vote"),
	array("admin", "", "octicon", "tools", "Setting"),
	array("user", "login", "octicon", "sign-out", "Logout", array('data-reload'=>true)),
);


//////////////////////////////////////////////////////
// css, js headers
$css_headers = array();
$js_headers = array();

// default
$css_headers[] = 'style';
$js_headers[] = 'main';
$js_headers[] = 'menu';

// pure css
$css_headers[] = 'pure';

// jquery
$js_headers[] = 'jquery.blockUI';
// jquery.ui
$js_headers[] = 'jquery-ui.min';
$css_headers[] = 'jquery-ui.min';

// menu
$css_headers[] = 'menu';
//$js_headers[] = 'menu';

// class helper func
$js_headers[] = 'classie';

// icons
$css_headers[] = 'octicons';

// view
//   login
$css_headers[] = 'login';


// ajax load
$js_headers[] = 'ajax_load';
