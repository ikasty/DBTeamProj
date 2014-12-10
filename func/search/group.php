<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

if (sizeof($ARGS["view"]) == 0) die(json_encode(-1));
$db = getDB();


$query = "SELECT ";
$query_select = array();	
if (in_array("평가회차", $ARGS["view"]))
	$query_select[] = "평가회차id";
if (in_array("피평가자 그룹", $ARGS["view"]))
	$query_select[] = "그룹id";
if (in_array("피평가자 목록", $ARGS["view"]))
	$query_select[] = "`피평가자 신청`.개발자id as `피평가자 id`";
if (in_array("평가자 그룹", $ARGS["view"]))
	$query_select[] = "평가자그룹";
if (in_array("평가자 목록", $ARGS["view"]))
	$query_select[] = "`평가자 선정`.개발자id";


$query .= implode(',',$query_select);

$query .= " FROM `피평가자 그룹` RIGHT JOIN `평가자 선정` ON `피평가자 그룹`.평가자그룹 = `평가자 선정`.평가그룹 RIGHT JOIN `피평가자 신청` ON `피평가자 그룹`.그룹id = `피평가자 신청`.평가그룹";



// where절
$where_clause = array();
if ($ARGS["period"] !== "") {
	$where_clause[] = "평가회차id = " . $ARGS["period"];
	$where_clause[] .= "`피평가자 신청`.평가회차 = " . $ARGS["period"];
	$where_clause[] .= "`평가자 선정`.평가회차 =" . $ARGS["period"];
}
if (sizeof($where_clause) != 0) {
	$query .= " WHERE ";
	$query .= implode(' AND ', $where_clause);
}

// order by
$query .= " ORDER BY " . $ARGS["sort-type"];
if ($ARGS["asc-desc"] === 'true')
	$query .= " DESC";

$result = $db->getResult($query);

var_dump($query);

$return["success"] = "success";
ob_start();
?>
<table class="pure-table pure-table-horizontal">
<thead>
	<tr>
	<? foreach ($ARGS["view"] as $name) : ?>
		<th><?=$name?></th>
	<? endforeach; ?>
	</tr>
</thead>
<tbody>
<? $i = 0; foreach ($result as $rows) : $i++; ?>
	<tr<?=($i % 2) ? ' class="pure-table-odd"' : ""?>>
	<? foreach ($rows as $value) : ?>
		<td><?=$value?></td>
	<? endforeach; ?>
	</tr>
<? endforeach; ?>
</tbody>
</table>
<?
$return["html"] = ob_get_clean();
?>