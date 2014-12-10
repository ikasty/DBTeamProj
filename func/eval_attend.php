<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$db = getDB();

$result = false;
if ($ARGS["jointype"] === "get-eval") {

	foreach ($ARGS["join_data"] as $data_value) {
		$query = $db->MakeQuery(
			"INSERT INTO `피평가자 신청` (`평가회차`, `평가그룹`, `개발자id`, `자료id`) VALUES (%d, %d, %s, %d)",
			$current_eval->get_period(),
			0,
			$current_user->developer_id,
			$data_value);
		$result = $db->query($query);
	}

} else if ($ARGS["jointype"] === "do-eval") {
	$result = $db->query("INSERT INTO `평가자 선정` (`평가회차`, `개발자id`) VALUES (" . $current_eval->get_period() . ", '" . $current_user->developer_id . "')");
	var_dump($result);
}

if ($result !== false) {
	$return['success'] = "success";
} else {
	$return['success'] = "failed";
	addMessage("이미 신청하셨습니다.");
}

?>