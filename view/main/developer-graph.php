<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

///////////////////////////////
$dummy_data = array(
	1 => array(
		'count' => 1,
		'date-start' => "2014-12-01",
		'date-end' => "2014-12-02",
		'evaluate' => array(
			array(
				'title' => "1번자료",
				'upload-date' => "2014-11-28",
				'speed' => 80,
				'size' => 75,
				'ease of use' => 90,
				'reliability' => 60,
				'portability' => 70
			),
			array(
				'title' => "2번자료",
				'upload-date' => "2014-11-29",
				'speed' => 70,
				'size' => 55,
				'ease of use' => 40,
				'reliability' => 100,
				'portability' => 95
			)
		)
	)
);
///////////////////////////////

$data = $dummy_data; // 실제 데이터 불러오는 코드 넣을 것
$label = array_keys($data);
array_walk($label, create_function('&$value', ' $value .= "회차"; ')); // 1회차, 2회차, 3회차...

$result = array("labels" => $label, "datasets" => array(
	array(
		"label" => "평균 데이터",
		"fillColor" => "rgba(151,187,205,0.5)",
		"strokeColor" => "rgba(151,187,205,0.8)",
		"highlightFill" => "rgba(151,187,205,0.75)",
		"highlightStroke" => "rgba(151,187,205,1)",
		"data" => array()
	)
));
foreach ($data as $count => $value) {
	$count = 0; $sum = 0;
	foreach($value["evaluate"] as $dataset) {
		//dataset의 speed, size, etc.. 등을 고려하여 합과 개수를 구함
	}
	$result["datasets"][0]["data"][] = ($count != 0) ? ($sum / $count) : 0;
}

?>
<div class="pure-g graph-area">
	<div class="pure-u-2-3">
		<div class="mainform">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-graph"></span> 내 평가 통계
			</div>
			<div style="margin:10px; display:inline-block;">
				<p>최근 6회간 평균 평가점수</p>
				<canvas id="eval-stat-all" width="700" height="200"></canvas>
			</div>
		</div>
	</div>
	<div class="pure-u-1-3">
		<div class="mainform">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-briefcase"></span> 근무 이력
			</div>	
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			var eval_stat_all_ctx = $("#eval-stat-all").get(0).getContext("2d");
			var eval_stat_all_data = <?=json_encode($result)?>;
			var eval_stat_all_chart = new Chart(eval_stat_all_ctx).Bar(eval_stat_all_data);
		});
	</script>
</div>