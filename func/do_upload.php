<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$DB = getDB();
//$time = date("Y-m-d H:i:s");
$time = NOW();

$query = $DB->MakeQuery("INSERT INTO `평가자료`(`개발자id`,`업로드시간`,`기여도`,`자료정보`,`자료이름`) VALUES(%s,%s,%f,%s,%s);",$current_user->developer_id,$time,$ARGS['contribution'],$ARGS['url'],$ARGS['fname']);
//var_dump($query);
$DB->query($query);


$query = $DB->MakeQuery("SELECT * From `평가자료` where `개발자id`=%s AND `업로드시간`=%s", $current_user->developer_id, $time);
$file_info = $DB->getRow($query);
$file_id = $file_info["자료id"];

$query = $DB->MakeQuery("INSERT INTO `자료분야`(`자료id`, `자료분야`) VALUES(%s,%s)",$file_id,$ARGS['file_type']);

$return['success'] = "success";
?>	