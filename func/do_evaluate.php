<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

/*
$DB = getDB();

$F_id; 평가파일 id
$P_id; 평가자 id
$time = NOW(); 평가시간

$query = $DB->MakeQuery("INSERT INTO 평가(평가id, 자료id, 평가시간, 평가자id, 속도, 크기, 편의성, 신뢰성, 견고성,범용성) VALUES('',%s,%s,%s,%s,%s,%s,%s,%s,%s)"
	,$F_id,$time,$P_id,$ARGS['speed'],$ARGS['src_size'],$ARGS['ease_use'],$ARGS['reliability'],$ARGS['robustness'],$ARGS['generality']);
*/

$return['success'] = "success";
?>	