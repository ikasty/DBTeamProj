<?
define("DBPROJ", true);

if (!isset($_POST['AJAXKEY'])) die(-1);

// session start
session_start();

//if ($_POST['AJAXKEY'] !== $_SESSION['AJAXKEY']) die(-1):
$target = '';

if ( isset($_POST['TARGET']) )	$target = $_POST['TARGET'];
else 							$target = 'view/main';
if ( !isset($_SESSION['id']) )	$target = 'view/login';

include('./' . $target . '.php');