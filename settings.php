<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$css_headers = array();
$js_headers = array();

// debug mode
//define('DEBUG');

// default
$css_headers[] = 'style';

// menu
$css_headers[] = 'menu';
$js_headers[] = 'menu';
// class helper func
$js_headers[] = 'classie';
$css_headers[] = 'icons';

$css_headers[] = 'octicons';

// login
$css_headers[] = 'login';