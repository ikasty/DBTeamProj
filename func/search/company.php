<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

if (sizeof($ARGS["view"]) == 0) die(json_encode(-1));
$db = getDB();

// query문
$query = "SELECT ";
$query .= implode(',', $ARGS["view"]);
if ($ARGS["company-name"] !== "" || $ARGS["company-major"] !== "") {
	$query .= " WHERE ";
}
$query .= " ORDER BY " $ARGS["sort-type"];
if ($ARGS["asc-desc"] === 'true')
	$query .= " DESC";

$result = $db->getResult($query);

// 변수는 $ARGS에 담겨있음
var_dump($ARGS);

$return["success"] = "success";
ob_start();
?>
<table class="pure-table pure-table-horizontal">
<thead>
	<tr>
<? foreach ($ARGS["view"] as $name) : ?>
		<th><?=$name?></th>
<? endforeach; ?>
		<th>회사명</th>
		<th>부서명</th>
		<th>근무기간</th>
	</tr>
</thead>
<tbody>
</tbody>
</table>
<?
$return["html"] = ob_get_clean();
?>