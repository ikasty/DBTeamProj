<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$db = getDB();

if($ARGS['file_id'] == NULL){
  $return['success'] = "failed";
}

date_default_timezone_set('Asia/Seoul');
// 평가 회차 구하기 //
$cur_timestamp = date('Y-m-d H:i:s');
$query = 
  "SELECT `평가회차` 
  FROM `평가일정` 
  WHERE `모집시작일` <= '$cur_timestamp' AND ISNULL(`종료일`)";
$row = $db->getRow($query);
$period = $row['평가회차'];

// 평가ID 생성
$query = 
  "SELECT `평가id` 
  FROM `평가` 
  ORDER BY `평가id` DESC 
  LIMIT 1";

$row = $db->getRow($query);
$material_id = $row['평가id'] + 1;

$query = 
  "INSERT INTO `평가`(`평가id`)
  VALUES($material_id)";
$db->query($query);

// 평가하기 테이블에 항목 추가 
$query = $db->MakeQuery(
  "INSERT INTO `평가하기`(`평가id`, `자료id`, `개발자id`, `평가날짜`, `평가회차`) 
  VALUES(%d, %d, %s, CURDATE(), %s);",
  $material_id,
  $ARGS['file_id'],
  $current_user->developer_id,
  $period
);
$db->query($query);
var_dump($query);

// 평가지표 테이블에 항목 추가
$query = $db->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$material_id,'속도' ,$ARGS['speed']);
$db->query($query);
$query = $db->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$material_id,'크기' ,$ARGS['src_size']);
$db->query($query);
$query = $db->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$material_id,'사용 편의성' ,$ARGS['ease_use']);
$db->query($query);
$query = $db->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$material_id,'신뢰성' ,$ARGS['reliability']);
$db->query($query);
$query = $db->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$material_id,'견고성' ,$ARGS['robustness']);
$db->query($query);
$query = $db->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$material_id,'범용성' ,$ARGS['generality']);
$db->query($query);

$return['success'] = "success";
?>	