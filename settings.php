<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// debug mode
//define('DEBUG');

//////////////////////////////////////////////////////
// include classes
include('include/functions.php');
	/* include classes here */

// menus
$menu_item = array(
/*	array("view name", "icon type", "icon name", "tooltip name")	*/	
	array("main", "octicon", "home", "Home"),
	array("", "octicon", "graph", "Graph"),
	array("", "octicon", "cloud-upload", "Upload"),
	array("", "octicon", "law", "Vote"),
	array("", "octicon", "tools", "Setting"),
	array("", "octicon", "sign-out", "Logout"),
);


//////////////////////////////////////////////////////
// css, js headers
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
