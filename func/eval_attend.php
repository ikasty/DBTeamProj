<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

var_dump($ARGS);

$db = getDB();
var_dump($db);

$result = false;
if ($ARGS["jointype"] === "get-eval") {
	$result = $db->query("INSERT INTO `피평가자 신청` (`평가회차`, `개발자id`) VALUES (" . $current_eval->id . ", " . $current_user->developer_id . ")");
} else if ($ARGS["jointype"] === "do-eval") {
	$result = $db->query("INSERT INTO `평가자 선정` (`평가회차`, `개발자id`) VALUES (" . $current_eval->id . ", " . $current_user->developer_id . ")");
}

$return['success'] = ($result !== false) ? "success" : "failed";

?>