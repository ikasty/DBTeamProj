<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$temp_user = User::getUser($ARGS['userid']);

if ($temp_user->login($ARGS['password'])) {
	$return['success'] = "success";
} else {
	$return['success'] = "failed";
	addMessage("잘못된 아이디 또는 비밀번호를 입력하셨습니다.");
}

?>