<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$temp_user = User::getUser($ARGS['file_list[]']);

if ($temp_user->upload($ARGS['file_list[]'])) {
	$return['success'] = "success";
} else {
	$return['success'] = "failed";
}

?>