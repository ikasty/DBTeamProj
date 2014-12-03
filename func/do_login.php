<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$return = array();
$temp_user = User::getUser($ARGS['userid']);

if ($temp_user->login($ARGS['password'])) {
	$return['success'] = "success";
	addMessage("로그인에 성공하였습니다!");
} else {
	$return['success'] = "failed";
}

/*
for test purpose,

INSERT INTO `dbproj`.`유저` ( `id` , `비밀번호` , `이름` )
VALUES ( 'test', 'dGVzdA==', '테스트' );
*/
echo json_encode($return);
?>