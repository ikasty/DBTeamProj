<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

if (sizeof($ARGS["view"]) == 0) die(json_encode(-1));
$db = getDB();

// query문
// SELECT 회사이름, 평균점수, 전문분야 FROM 회사성적 RIGHT JOIN 회사전문분야 ON 회사성적.회사이름 = 회사전문분야.회사이름

$query = "SELECT ";

$query_select = array();	
$query .= implode(',', $ARGS["view"]);
$query = str_replace("회사이름", "회사성적.회사이름 AS 회사이름", $query);

$query .= " FROM 회사성적 RIGHT JOIN 회사전문분야 ON 회사성적.회사이름 = 회사전문분야.회사이름";

// where절
$where_clause = array();
if ($ARGS["company-name"] !== "")
	$where_clause[] = "회사이름 LIKE '%" . $ARGS["company-name"] . "%'' ";
if ($ARGS["company-major"] !== "")
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
var_dump($query, $result);

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
<? foreach ($result as $rows) : ?>
	<tr>
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