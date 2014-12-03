<?
/**
 * DB 조별과제 Main view
 * by 강대연
 * 2014-11-13
 */

// ajax entry point
define("DBPROJ", true);

if (!isset($_POST['AJAXKEY'])) die(-1);

// session start
session_start();

// include setting
include('settings.php');

if ($_POST['AJAXKEY'] !== $_SESSION['AJAXKEY']) die(-1);
$target = '';

if ( isset($_POST['TARGET']) )	$target = $_POST['TARGET'];
else 							$target = 'view/main';
// 권한 체크 구현할 것!
//if ( !isset($_SESSION['id']) )	$target = 'view/login';

$ARGS = array();
if (isset($_POST['ARGS'])) $ARGS = $_POST['ARGS'];
if (!is_array($ARGS)) var_dump($ARGS);
$ARGS = array_merge($ARGS, $_POST);

if (!file_exists($target . '.php')) die(-1);

if (substr($target, 0, 4) == 'view') {
	// menu reload check
	if ( isset($ARGS['menu_reload']) && $ARGS['menu_reload'] == 'true' ) {
		include('view/header.php');
		include($target . '.php');
		include('view/footer.php');
	} else {
		include($target . '.php');
	}
} else
if (substr($target, 0, 4) == 'func') {
	$return = array();
	ob_start();
	include($target . '.php');
	$debug_msg = ob_end_flush();
	
	$return = array(
		'noti-message' => $_SESSION['noti-message'],
		'debug-message' => $debug_msg,
		'orig-return' => $return);
	$_SESSION['noti-message'] = '';
	
	echo json_encode($return);
}