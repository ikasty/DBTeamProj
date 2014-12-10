<?
header('Content-Type: application/json');

if (!defined("DBPROJ")) die(json_encode(-1));

$temp_user = User::getUser($ARGS['user_id']);

if ($temp_user->user_id) {
  addMessage('중복된 아이디입니다.');
  $return['success'] = 'failed';
}
else {
  addMessage('사용 가능한 아이디입니다.');
  $return['success'] = 'successed';
}

// $return['success'] = 'successed';
?>