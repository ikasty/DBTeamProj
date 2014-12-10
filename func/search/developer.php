<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

if (sizeof($ARGS["view"]) == 0) die(json_encode(-1));
$db = getDB();

// query문
// SELECT 개발자.id AS 개발자id, 유저.이름 AS 개발자이름, 근무.회사이름 AS 회사이름, 근무.입사일 AS 입사일, 근무.퇴사일 AS 퇴사일, 최신전문분야.전문분야 AS 전문분야
// FROM 개발자
// LEFT JOIN 유저 ON 유저.id=개발자.id
// LEFT JOIN 근무 ON 근무.개발자id=개발자.id
// LEFT JOIN 최신전문분야 ON 최신전문분야.개발자id=개발자.id

$header = array();
$query = "SELECT ";

$query_select = array();
if (in_array("개발자 id", $ARGS["view"])) {
	$query_select[] = "개발자.id AS 개발자id";
	$header[] = "개발자 id";
}
if (in_array("개발자 이름", $ARGS["view"])) {
	$query_select[] = "유저.이름 AS 개발자이름";
	$header[] = "개발자 이름";
}
if (in_array("회사이름", $ARGS["view"])) {
	$query_select[] = "근무.회사이름 AS 회사이름";
	$header[] = "회사이름";
}
if (in_array("평균점수", $ARGS["view"])) {
	$query_select[] = "IF(AVG(평가점수.평균점수) IS NULL, '0.0', AVG(평가점수.평균점수)) AS 평균점수";
	$header[] = "평균점수";
}
if (in_array("입사일", $ARGS["view"])) {
	$query_select[] = "근무.입사일 AS 입사일";
	$header[] = "입사일";
}
if (in_array("퇴사일", $ARGS["view"])) {
	$query_select[] = "IF( (근무.퇴사일 IS NULL), '근무중', 근무.퇴사일 ) AS 퇴사일";
	$header[] = "퇴사일";
}
if (in_array("전문분야", $ARGS["view"])) {
	$query_select[] = "최신전문분야.전문분야 AS 전문분야";
	$header[] = "전문분야";
}

$query .= implode(',', $query_select);

$query .= " FROM 개발자";
$query .= " LEFT JOIN 유저 ON 유저.id=개발자.id";
$query .= " LEFT JOIN 근무 ON 근무.개발자id=개발자.id";
$query .= " LEFT JOIN 최신전문분야 ON 최신전문분야.개발자id=개발자.id";
$query .= " LEFT JOIN 평가점수 ON 평가점수.개발자id=개발자.id";

// where절
$where_clause = array();
if ($ARGS["developer-id"] !== "" && in_array("개발자 id", $ARGS["view"]))
	$where_clause[] = "개발자.id LIKE '%" . $ARGS["developer-id"] . "%' ";
if ($ARGS["developer-name"] !== "" && in_array("개발자 이름", $ARGS["view"]))
	$where_clause[] = "유저.이름 LIKE '%" . $ARGS["developer-name"] . "%' ";
if ($ARGS["company-name"] !== "" && in_array("회사이름", $ARGS["view"]))
	$where_clause[] = "근무.회사이름 LIKE '%" . $ARGS["company-name"] . "%' ";
if ($ARGS["developer-major"] !== "" && in_array("전문분야", $ARGS["view"]))
	$where_clause[] = "최신전문분야.전문분야 LIKE '%" . $ARGS["developer-major"] . "%' ";

$start_date	= $ARGS["change-start"] === "" 	? "'0000-00-00'" : "'" . $ARGS["change-start"] . "'";
$end_date 	= $ARGS["change-end"] === "" 	? "NOW()" : "'" . $ARGS["change-end"] . "'";

if (in_array("입사일", $ARGS["view"]))
	$where_clause[] = "(근무.입사일 BETWEEN " . $start_date . " AND " . $end_date . ")";
if (in_array("퇴사일", $ARGS["view"]))
	$where_clause[] = "( IF(근무.퇴사일 IS NULL, NOW(), 근무.퇴사일) BETWEEN " . $start_date . " AND " . $end_date . ")";

if (sizeof($where_clause) != 0) {
	$query .= " WHERE ";
	$query .= implode(' AND ', $where_clause);
}

// group by
$query .= " GROUP BY 개발자.id";

// order by
$order_by = $ARGS["sort-type"];
$order_by = str_replace("개발자 id", "개발자id", $order_by);
$order_by = str_replace("개발자 이름", "개발자이름", $order_by);
$query .= " ORDER BY " . $order_by;
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