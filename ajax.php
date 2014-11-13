<?
/**
 * DB 조별과제 Main view
 * by 강대연
 * 2014-11-13
 */

// ajax entry point
define("DBPROJ", true);

if (!isset($_POST['AJAXKEY'])) die(-1);

// include setting
include('settings.php');

// session start
session_start();

if ($_POST['AJAXKEY'] !== $_SESSION['AJAXKEY']) die(-1);
$target = '';

if ( isset($_POST['TARGET']) )	$target = $_POST['TARGET'];
else 							$target = 'view/main';
if ( !isset($_SESSION['id']) )	$target = 'view/login';

if (!file_exists($target . '.php')) die(-1);
include($target . '.php');