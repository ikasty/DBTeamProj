<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$DB = getDB();

$eval = new evaluation;
$period = $eval->get_period();

$query = $DB->MakeQuery("SELECT `평가그룹` FROM `평가자 선정` WHERE `평가회차`=%d AND `개발자id` = %s",$period,$current_user->developer_id);
$tmp = $DB->getRow($query);
$my_group = $tmp["평가그룹"];

$query = $DB->MakeQuery("SELECT `그룹id` FROM `피평가자 그룹` WHERE `평가자그룹`=%d AND `평가회차id` = %d",$my_group ,$period);
$tmp = $DB->getResult($query);
$count = count($tmp); //담당한 그룹 id 수 

for($i=0; $i<$count; $i++)
{
	$eval_list[$i]=$tmp[$i]["그룹id"];
}

for($i=0; $i<$count; $i++) //담당하는 그 룹 수 만큼
{
	$query = $DB->MakeQuery("SELECT `자료id` FROM `피평가자 신청` WHERE `평가그룹`=%d AND `평가회차` = %d",$eval_list[$i]=$tmp[$i]["그룹id"],$period);
	$file_list[$i] = $DB->getResult($query);
	$file_no[$i] = count($file_list[$i]);
	
}
?>
<div class="pure-g" style="text-align:center;">
	<div class="evaluate-box pure-u-2-5">
		<div class="mainform evaluate">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-law"></span> 평가하기
			</div>
			<div class="descript">
				먼저, 오른쪽 평가자료를 평가해 주세요
			</div>
			<form id="values" method="POST">
				Speed
				<input type="number" name="Speed" min="0" max="100" placeholder="0~100">
				<br><br>
				Size
				<input type="number" name="Size" min="0" max="100" placeholder="0~100">
				<br><br>
				Ease of Use
				<input type="number" name="Ease-of-Use" min="0" max="100" placeholder="0~100">
				<br><br>
				Reliability
				<input type="number" name="Reliability" min="0" max="100" placeholder="0~100">
				<br><br>
				Robustness
				<input type="number" name="Robustness 구성" min="0" max="100" placeholder="0~100">
				<br><br>
				Generality
				<input type="number" name="Generality" min="0" max="100" placeholder="0~100">
				<br><br>
			</form>
			<div>
				<a id="do-evaluate" data-func="do-evaluate"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-checklist"></span> 평가하기
				</a>
			</div>
		</div>
	</div>
	<div class="src-code-box pure-u-2-5">
		<div class="mainform src-code">
			<div class="box-title" style="background: #2c4985;">
				<span class="mega-octicon octicon-file-pdf"></span> 소스코드
			</div>
			<div class="descript">
				평가할 개발자의 소스코드 URL 입니다.
			</div>
			<div>
				<form method="get">
  					<input list="select" name="select">
  					<datalist id="select">
  						<? for($i=0; $i<$count; $i++) {
  							for($j=0; $j<$file_no[$i]; $j++) { ?>
  							 <option value="<?= $file_list[$i][$j]["자료id"] ?>">
  						<? } }?>
  					</datalist><br><br>
  					<a id="select_file" data-func="select_file"
					class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-checklist"></span> 선택하기
					</a>
  				</form> 			
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
//select_file 버튼 func 추가

	$("#evaluate").each(function() {
		var item = $(this);
		item
		.on('start', function (event, args) {
			item.addClass("pure-button-disabled");
			args.speed = $('.evaluate input[name=Speed]').val();
			args.src_size = $('.evaluate input[name=Size]').val();
			args.ease_use = $('.evaluate input[name=Ease-of-Use]').val();
			args.reliability = $('.evaluate input[name=Reliability]').val();
			args.robustness = $('.evaluate input[name=Robustness]').val();
			args.generality = $('.evaluate input[name=Generality]').val();
			return true;
		}
		).on('finish', function (event, item, data) {
				if (data.success == 'failed') {
				} else {
				}
				item.removeClass("pure-button-disabled");
				return true;
			}
		);
	});
</script>
<?
?>
