<?
//if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
$DB=getDB();

$query = $DB->MakeQuery(
	"SELECT workon.`회사이름` as company, com_devnum.devnum2 as devnum, count(*) as datanum
	FROM `근무` workon, `평가자료` data,
		(
			SELECT `회사이름`, count(`개발자id`) as devnum2
			FROM `근무`
			WHERE NOW() between `입사일` and `퇴사일`
			GROUP BY `회사이름`
		) com_devnum
	WHERE data.`업로드시간` between workon.`입사일` and workon.`퇴사일`
		AND workon.`개발자id` = data.`개발자id`
		AND com_devnum.`회사이름` = workon.`회사이름`
	GROUP BY workon.`회사이름`
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
							<td>소속 평가자료 수</td>
						</tr>
						<? foreach($companys as $result) :?>
						<tr>
							<td><?=$result["company"]?></td>
							<td><?=$result["devnum"]?></td>
							<td><?=$result["datanum"]?></td>
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
