<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

// ** add code here **

// return
echo json_encode($AJAX);
?>