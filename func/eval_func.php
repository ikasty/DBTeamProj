<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

if ($ARGS["func_type"] == "모집시작") {
$DB = getDB();

$query = $DB->MakeQuery(
	"INSERT INTO `평가일정` (`평가회차`,`모집시작일`,`평가시작일`,`종료일`)
	VALUES (NULL, NOW(), NULL, NULL)"
	);

$DB->query($query);

addMessage("모집이 시작되었습니다.");
}

if ($ARGS["func_type"] == "평가시작") {

$eval = new evaluation;
$period = $eval->get_period();

$DB = getDB();

$query = $DB->MakeQuery(
	"UPDATE `평가일정` SET `평가시작일` = NOW() WHERE `평가일정`.`평가회차` = %d",$period
	);

$DB->query($query);

$eval->assginGroup($period);
$eval->Mapping($period);
// 평가자들의 평가가 가능하도록 한다.


addMessage("평가가 시작되었습니다.");
}

if ($ARGS["func_type"] == "평가끝") {
$eval = new evaluation;
$period = $eval->get_period();

$DB = getDB();

$query = $DB->MakeQuery(
	"UPDATE `평가일정` SET `종료일` = NOW() WHERE `평가일정`.`평가회차` = %d",$period
	);

$DB->query($query);

addMessage("평가가 종료되었습니다.");
}



?>