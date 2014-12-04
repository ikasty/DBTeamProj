<?
//if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
$DB=getDB();

$query = $DB->MakeQuery(
	"SELECT `회사이름` as company, count(`개발자id`) as devnum
	FROM `근무`
	GROUP BY `회사이름`
	ORDER BY company;");

$companys = $DB->getResult($query);


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
					<span class="mega-octicon octicon-move-up"></span>&nbsp;회사 목록
				</div>
				<div class="descript">
					<table border="1" align="center">
						<tr>
							<td>회사명</td>
							<td>소속 개발자 수 </td>
						</tr>
						<? foreach($companys as $result) :?>
						<tr>
							<td><?=$result["company"]?></td>
							<td><?=$result["devnum"]?></td>
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
