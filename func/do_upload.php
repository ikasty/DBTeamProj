<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

//$temp_user = User::getMaterial($ARGS['userid']);
//파일 업로드 할때 무슨 값을 이용해 지금 개발자 정보를 불러올지 정해야 함.


/*
먼저, 평가자료 id를 현재 월.일.시.분.초 로 하는 새로운 Material을 만들어
해당 객체의 file_list[]에 추가하고 그 Material(평가자료) 를 불러
$file_catorigy =  $ARGS['filetype']; 
$file_major = $ARGS['majortype'];
$contribution = $ARGS['contribution'];
$url = $ARGS['url'];
*/
if ($temp_user->login($ARGS['password'])) {
	$return['success'] = "success";
} else {
	$return['success'] = "failed";
	addMessage("업로드 실패.");
}

?>