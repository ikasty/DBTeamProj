<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$db = getDB();
$user_count = $db->getValue("SELECT count(*) FROM 개발자");
$company_count = $db->getValue("SELECT count(*) FROM 회사");
$file_count = $db->getValue("SELECT count(*) FROM 평가자료");
$top_rank = $db->getResult("SELECT 유저.이름, 평가점수.개발자id, AVG(평가점수.평균점수) FROM 평가점수 LEFT JOIN 유저 ON 유저.id = 평가점수.개발자id
	GROUP BY 유저.id ORDER BY AVG(평가점수.평균점수) DESC LIMIT 0, 5");
?>
<div class="pure-g main-area">
	<div class="pure-u-1-2">
		<div class="mainform" style="min-height:300px;">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-graph"></span> 전체 통계
			</div>
			<div class="boxgroup" style="margin-top: 40px;">
				<span class="boxinfo" style="background: #3B84D7;">
					<span><span class="mega-octicon octicon-person"></span> <?=$user_count?></span>
				</span>
				<span class="boxinfo" style="background: #4ADBAD;">
					<span><span class="mega-octicon octicon-organization"></span> <?=$company_count?></span>
				</span>
				<span class="boxinfo" style="background: #9E6ACF;">
					<span><span class="mega-octicon octicon-file-text"></span> <?=$file_count?></span>
				</span>
			</div>
		</div>
	</div>
	<div class="pure-u-1-2">
		<div class="mainform" style="min-height:300px;">
			<div class="box-title" style="background: #8E5690;">
				<span class="mega-octicon octicon-gift"></span> 상위 개발자들
			</div>
			<table class="pure-table pure-table-horizontal" style="margin: 10px auto;">
				<thead>
					<tr>
						<th>이름</th>
						<th>id</th>
						<th>평균점수</th>
					</tr>
				</thead>
				<tbody>
				<? $i = 0; foreach ($top_rank as $rows) : $i++; ?>
					<tr<?=($i % 2) ? ' class="pure-table-odd"' : ""?>>
					<? foreach ($rows as $value) : ?>
						<td><?=$value?></td>
					<? endforeach; ?>
					</tr>
				<? endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>