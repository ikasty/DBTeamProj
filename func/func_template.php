<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

// ** add code here **

// addMessage를 사용해서 알림영역에 메시지를 쓸 수 있음.
// 주의: func에서만 사용 가능함
addMessage("정상 작동합니다.");

// 결과물은 $return에 넣을 것

$return = "결과물";

?>