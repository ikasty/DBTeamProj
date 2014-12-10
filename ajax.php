<?
/**
 * DB 조별과제 Main view
 * by 강대연
 * 2014-11-13
 */

// ajax entry point
define("DBPROJ", true);

if (!isset($_POST['AJAXKEY'])) die(json_encode(-1));

// session start
session_start();

// 비쥬얼을 위해 일부러 시간 끌기
sleep(1);

// include setting
include('settings.php');

if ($_POST['AJAXKEY'] !== $_SESSION['AJAXKEY']) die(json_encode(-1));
$target = '';

if ( isset($_POST['TARGET']) )	$target = $_POST['TARGET'];
else 							$target = 'view/main';

$ARGS = array();
if (isset($_POST['ARGS'])) $ARGS = $_POST['ARGS'];
if (!is_array($ARGS)) var_dump($ARGS);
$ARGS = array_merge($ARGS, $_POST);

if (!file_exists($target . '.php')) die(json_encode(-1));

if (substr($target, 0, 4) == 'view') {
	// 권한 체크
	if ( !$current_user->is_logged_in() && $target != "view/join" ) {
		$target = 'view/login';
		$ARGS['menu_reload'] = 'true';
	}

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

	// 권한 체크는 나중에 flag로 할 것
	/*
	if ( !$current_user->is_logged_in() ) {
		$return['noti-message'] = "로그아웃 되었습니다";
		$return['orig-return'] = -1;
		$return['debug-message'] = $ARGS;
		die(json_encode($return));
	}*/

	ob_start();
	include($target . '.php');
	$debug_msg = ob_get_clean();
	
	$return = array(
		'noti-message' => $_SESSION['noti-message'],
		'debug-message' => $debug_msg,
		'orig-return' => $return);
	$_SESSION['noti-message'] = '';

	echo json_encode($return);
}