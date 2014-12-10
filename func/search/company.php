<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

if (sizeof($ARGS["view"]) == 0) die(json_encode(-1));
$db = getDB();

// query문
// SELECT 회사이름, 평균점수, 전문분야 FROM 회사성적 RIGHT JOIN 회사전문분야 ON 회사성적.회사이름 = 회사전문분야.회사이름

$header = array();
$query = "SELECT ";

$query_select = array();
if (in_array("회사이름", $ARGS["view"])) {
	$query_select[] = "회사성적.회사이름 AS 회사이름";
	$header[] = "회사이름";
}
if (in_array("전문분야", $ARGS["view"])) {
	$query_select[] = "전문분야";
	$header[] = "전문분야";
}
if (in_array("평균점수", $ARGS["view"])) {
	$query_select[] = "평균점수";
	$header[] = "평균점수";
}

$query .= implode(',', $query_select);

$query .= " FROM 회사성적 RIGHT JOIN 회사전문분야 ON 회사성적.회사이름 = 회사전문분야.회사이름";

// where절
$where_clause = array();
if ($ARGS["company-name"] !== "" && in_array("회사이름", $ARGS["view"]))
	$where_clause[] = "회사성적.회사이름 LIKE '%" . $ARGS["company-name"] . "%' ";
if ($ARGS["company-major"] !== "" && in_array("전문분야", $ARGS["view"]))
	$where_clause[] = "전문분야 LIKE '%" . $ARGS["company-major"] . "%' ";
if (sizeof($where_clause) != 0) {
	$query .= " WHERE ";
	$query .= implode(' AND ', $where_clause);
}

// order by
$query .= " ORDER BY " . $ARGS["sort-type"];
if ($ARGS["asc-desc"] === 'true')
	$query .= " DESC";

$result = $db->getResult($query);

$return["success"] = "success";
ob_start();
?>
<table class="pure-table pure-table-horizontal">
<thead>
	<tr>
	<? foreach ($header as $name) : ?>
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