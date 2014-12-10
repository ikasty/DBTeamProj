<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$DB = getDB();

$eval = new evaluation;
$period = $eval->get_period();

if($ARGS['file_id'] == NULL) $return['success'] = "failed";

$query = $DB->MakeQuery("INSERT INTO `평가하기`(`자료id`,`개발자id`,`평가날짜`,`평가회차`) VALUES(%s,%f,%s,%s);",$ARGS['file_id'],$current_user->developer_id,NOW(),$period);
$DB->query($query);
//var_dump($query);

$query = $DB->MakeQuery("SELECT `평가id` From `평가하기` where `개발자id`=%s AND `평가회차`=%d", $current_user->developer_id, $period);
$group = $DB->getRow($query);

$query = $DB->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$group["평가id"],'속도' ,$ARGS['speed']);
$query = $DB->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$group["평가id"],'크기' ,$ARGS['src_size']);
$query = $DB->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$group["평가id"],'사용 편의성' ,$ARGS['ease_use']);
$query = $DB->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$group["평가id"],'신뢰성' ,$ARGS['reliability']);
$query = $DB->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$group["평가id"],'견고성' ,$ARGS['robustness']);
$query = $DB->MakeQuery("INSERT INTO `평가지표`(`평가id`, `지표이름`,`점수`) VALUES(%d,%s,%d)",$group["평가id"],'범용성' ,$ARGS['generality']);

$return['success'] = "success";
?>	