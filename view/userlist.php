<?
//if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
$DB=getDB();

$query = $DB->MakeQuery(
	"SELECT id, `대학교` as univ, `고향` as hometown, `유저id` as userid
	FROM `개발자`
	ORDER BY id;");

$developers = $DB->getResult($query);


?>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>DBapp</title>

	<script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
</head>
<body>

	<div class="pure-g">
		<div class="upload-box pure-u-1-1">
			<div class="mainform upload">
				<div class="box-title" style="background: #00bfFf;">
					<span class="mega-octicon octicon-move-up"></span>&nbsp;개발자 목록
				</div>
				<div class="descript">
					<table border="1" align="center">
						<tr>
							<td>id</td>
							<td>대학교</td>
							<td>고향</td>
							<td>유저id</td>
						</tr>
						<? foreach($developers as $result) :?>
						<tr>
							<td><?=$result["id"]?></td>
							<td><?=$result["univ"]?></td>
							<td><?=$result["hometown"]?></td>
							<td><?=$result["userid"]?></td>
						</tr>
						<? endforeach; ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?
?>
