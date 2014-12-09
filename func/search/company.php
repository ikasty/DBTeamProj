<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

// 변수는 $ARGS에 담겨있음
var_dump($ARGS);

$return["success"] = "success";
ob_start();
?>
<table class="pure-table pure-table-horizontal">
<thead>
	<tr>
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