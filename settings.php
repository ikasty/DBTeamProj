<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// debug mode
//define('DEBUG');

//////////////////////////////////////////////////////
// 자동 로그아웃 타임
define("AUTO_LOGOUT_TIME", 900);

//////////////////////////////////////////////////////
// DB Settings
include('dbconnect.php');

//////////////////////////////////////////////////////
// include classes
include('class/db.php');

include('include/functions.php');
include('class/user.php');
include('class/evaluation.php');
	/* include classes here */

// menus
$menu_item = array(
/*	array("menu_type", "view name", "icon type", "icon name", "tooltip name", "optional")	*/	
	array("all", "main", "octicon", "home", "Home"),
	array("all", "edit-user-info", "octicon", "pencil", "Edit"),
	array("user", "eval-attend", "fa", "sign-in", "Attend evaluate"),

	//array("user", "", "octicon", "graph", "Graph"),
	array("user", "upload", "octicon", "cloud-upload", "Upload"),
	array("user", "evaluate", "octicon", "law", "Evaluate"),
	array("admin", "eval_manage", "octicon", "tools", "Eval_manage"),
	array("all", "search", "octicon", "search", "Search"),
	//array("admin", "", "octicon", "tools", "Setting"),
	array("all", "login", "octicon", "sign-out", "Logout", array('data-reload'=>'true')),
	//array("all", "userlist", "octicon", "home", "Userlist"),
	//array("all", "companylist", "octicon", "home", "Companylist"),
);


//////////////////////////////////////////////////////
// css, js headers
$css_headers = array();
$js_headers = array();

// main font
$css_headers[] = 'jejugothic';

// default
$css_headers[] = 'style';
//$js_headers[] = 'main';
$js_headers[] = 'menu';
$css_headers[] = 'theme';

// pure css
$css_headers[] = 'pure';

// jquery
$js_headers[] = 'jquery.blockUI';
// jquery.ui
$js_headers[] = 'jquery-ui.min';
$css_headers[] = 'jquery-ui.min';

// Charts
$js_headers[] = 'Chart.min';

// menu
$css_headers[] = 'menu';
//$js_headers[] = 'menu';

// class helper func
$js_headers[] = 'classie';

// icons
$css_headers[] = 'octicons';
$css_headers[] = 'font-awesome.min';

// view
//	mainpage
$css_headers[] = 'mainpage';
//   login
$css_headers[] = 'login';
//   eval
$css_headers[] = 'eval';
//	upload
$css_headers[] = 'upload';
//	evaluate
$css_headers[] = 'evaluate';


// ajax load
$js_headers[] = 'ajax_load';
