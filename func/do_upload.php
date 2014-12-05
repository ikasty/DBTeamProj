<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$DB = getDB();

$dvel_ip = $current_user->develope_id;
$time = NOW();

//$query = $DB->MakeQuery("INSERT INTO 평가자료(자료id, 개발자id,업로드시간,기여도,자료정보) VALUES('',%s,%s,%s,%s)",$dvel_ip,NOW(),$ARGS['contribution'],$ARGS['url']);

$query = $DB->MakeQuery("INSERT INTO 평가자료(자료id, 개발자id,업로드시간,기여도) VALUES('',%s,%s,%s)",$dvel_ip,$time,$ARGS['contribution']);

$query = $DB->MakeQuery("SELECT * From 평가자료 where 개발자id=%s AND 업로드시간=%s", $dvel_ip, $time);
$file_info = $DB->getRow($query);
$file_id = $file_info["자료id"];

$query = $DB->MakeQuery("INSERT INTO 자료분야(자료id, 자료분야) VALUES(%s,%s)",$file_id,$ARGS['file_type']);

$return['success'] = "success";
?>	