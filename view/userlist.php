<?
//if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
$DB=getDB();

$query = $DB->MakeQuery(
	"SELECT dev.id as id, dev.`대학교` as univ, dev.`고향` as hometown, dev.`유저id` as userid, workon.`회사이름` as company, ifnull(data.datanum,0) as datanum, GROUP_CONCAT(`전문분야` SEPARATOR ', ') as speciality
	FROM `개발자` as dev
		LEFT JOIN
		(
			SELECT `개발자id`, count(*) as datanum
			FROM `평가자료`
			GROUP BY `개발자id`
		) as data
		ON dev.id = data.`개발자id`,
		`근무` as workon,
		`전문분야` as special
	WHERE dev.id = workon.`개발자id`
		AND workon.`입사일`<= NOW()
		AND workon.`퇴사일`> NOW()
		AND dev.id = special.id
	GROUP BY special.id
	ORDER BY datanum DESC;");

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
							<td>현재 근무회사</td>
							<td>제출 자료 수</td>
							<td>전문 분야</td>
						</tr>
						<? foreach($developers as $result) :?>
						<tr>
							<td><?=$result["id"]?></td>
							<td><?=$result["univ"]?></td>
							<td><?=$result["hometown"]?></td>
							<td><?=$result["userid"]?></td>
							<td><?=$result["company"]?></td>
							<td><?=$result["datanum"]?></td>
							<td><?=$result["speciality"]?></td>
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
