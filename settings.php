<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$css_headers = array();
$js_headers = array();

// debug mode
//define('DEBUG');

// login
$css_headers[] = 'login';