<?
define("DBPROJ");

if (!isset($_POST['AJAXKEY'])) die(-1);
if ($_POST['AJAXKEY'] !== $_SESSION['AJAXKEY']) die(-1):

if ( isset($_POST['TARGET']) )	$target = $_POST['TARGET'];
else 							$target = 'view/main';
if ( !isset($_SESSION['id'] )	$target = 'view/login';

include($target . '.php');