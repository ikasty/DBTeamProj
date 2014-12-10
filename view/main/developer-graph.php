<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

///////////////////////////////
/*$dummy_stat_data = array(
	1 => array(
		'count' => 1,
		'date-start' => "2013-12-01",
		'date-end' => "2013-12-02",
		'eval-average' => 88
	),
	2 => array(
		'count' => 2,
		'date-start' => "2014-01-05",
		'date-end' => "2014-01-10",
		'eval-average' => 85
	),
	4 => array(
		'count' => 4,
		'date-start' => "2014-08-01",
		'date-end' => "2014-08-10",
		'eval-average' => 81
	),
	7 => array(
		'count' => 7,
		'date-start' => "2014-12-01",
		'date-end' => "2014-12-05",
		'eval-average' => 87
	)
);*/
/*$dummy_work_data = array(
	array(
		'date-start' => "2014-03-01",
		'date-end' => "",
		'company' => "연세대",
		"dept" => "컴퓨터과학과"),
	array(
		'date-start' => "2008-03-02",
		'date-end' => "2011-03-02",
		'company' => "망한회사",
		'dept' => "망한부서"),
	array(
		'date-start' => "2003-06-15",
		'date-end' => "2007-12-30",
		'company' => "프리랜서",
		'dept' => "")
);*/

$dummy_work_data = array();
foreach ($current_user->company as $company) {
	$dummy_work_data[] = array(
		'date-start' => $company['start_day'],
		'date-end' => $company['end_day'],
		'company' => $company['name']
		// 'dept' => ""
	);
}

//최근 평가 5차례간 나의 점수
$db = getDB();
$dummy_stat_data = $db->getResult(
	"SELECT `평가회차` as `count`, avg(`평균점수`) as `eval-average`
	FROM `평가점수`
	WHERE `평가회차`=(
		SELECT `평가회차`
		FROM `평가일정`
		ORDER BY `모집시작일`
		LIMIT 5
	) AND
	`개발자id`='$current_user->user_id'
	GROUP BY `평가회차`"
);



///////////////////////////////

///////////////////////////////
// stat data
$data = $dummy_stat_data; // 실제 데이터 불러오는 코드 넣을 것
$label = array_column($data, 'count');
array_walk($label, create_function('&$value', ' $value .= "회차"; ')); // 1회차, 2회차, 3회차...

$stat_all = array("labels" => $label, "datasets" => array(
	array(
		"label" => "평균 데이터",
		"fillColor" => "rgba(151,187,205,0.5)",
		"strokeColor" => "rgba(151,187,205,0.8)",
//		"highlightFill" => "rgba(151,187,205,0.75)",
//		"highlightStroke" => "rgba(151,187,205,1)",
		"pointColor" => "rgba(151,187,205,1)",
		"pointStrokeColor" => "#fff",
		"pointHighlightFill" => "#fff",
		"pointHighlightStroke" => "rgba(151,187,205,1)",
		"data" => array()
	)
));
foreach ($data as $count => $value) {
	$stat_all["datasets"][0]["data"][] = $value["eval-average"];
}

///////////////////////////////
// work data
$work_data = $dummy_work_data; // 실제 데이터 불러오는 코드 넣을 것
foreach ($work_data as &$value) {
	$value['date-start'] = str_replace('-', '/', substr($value['date-start'], 0, 7));
	if ($value['date-end'] !== '')
		$value['date-end'] = str_replace('-', '/', substr($value['date-end'], 0, 7));
}

?>
<div class="pure-g graph-area">
	<div class="pure-u-3-5">
		<div class="mainform">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-graph"></span> 내 평가 통계
			</div>
			<div style="margin:15px; display:inline-block;">
				<p>최근 평가 5회간 점수</p>
				<canvas id="eval-stat-all" width="500" height="200"></canvas>
			</div>
		</div>
	</div>
	<div class="pure-u-2-5">
		<div class="mainform">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-briefcase"></span> 내 근무 이력
			</div>
			<div style="padding:20px;">
				<table class="pure-table pure-table-horizontal" style="margin:0 auto; width:100%">
				<thead>
					<tr>
						<th>회사명</th>
						<th>근무기간</th>
					</tr>
				</thead>
				<tbody>
				<? $count = 1; ?>
				<? foreach ($work_data as $company) : ?>
				<? $class = (($count++) % 2 == 0 ? ' class="pure-table-odd"' : "" ) ?>
					<tr<?=$class?>>
						<td><?=$company['company'];?></td>
						<td><?=$company['date-start'];?> ~ <?=($company['date-end'] === "") ? ("현재") : ($company['date-end'])?></td>
					</tr>
				<? endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			var eval_stat_all_ctx = $("#eval-stat-all").get(0).getContext("2d");
			var eval_stat_all_data = <?=json_encode($stat_all, JSON_NUMERIC_CHECK)?>;
			var eval_stat_all_chart = new Chart(eval_stat_all_ctx).Bar(eval_stat_all_data, {
				scaleBeginAtZero : true,
				bezierCurve: false,
				scaleOverride: true,
				scaleSteps: 5,
				scaleStepWidth: 20,
				scaleStartValue: 0
			});
			console.log(eval_stat_all_data);
		});
	</script>
</div>