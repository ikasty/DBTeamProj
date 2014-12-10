<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$db = getDB();

// 평가 회차 구하기 //
$cur_timestamp = date('Y-m-d H:i:s');
$query = 
  "SELECT `평가회차` 
  FROM `평가일정` 
  WHERE `모집시작일` <= '$cur_timestamp' AND ISNULL(`종료일`)";
$row = $db->getRow($query);
$period = $row['평가회차'];

$query = "
	SELECT `자료id` as `id`, `자료이름` as `name`, `자료정보` as `url`
	FROM `평가자료`
	WHERE `자료id` IN (
		SELECT `자료id`
		FROM `피평가자 신청`
		WHERE `평가회차`=$period AND `평가그룹` IN (
			SELECT `그룹id`
			FROM `피평가자 그룹`
			WHERE `평가회차id`=$period AND `평가자그룹` IN (
				SELECT `평가그룹`
				FROM `평가자 선정`
				WHERE `개발자id`='$current_user->user_id'
			)
		)
	) AND `자료id` NOT IN (
		SELECT `자료id`
		FROM `평가하기`
		WHERE `평가회차` = $period AND `개발자id`='$current_user->user_id'
	)";

$material_list = $db->getResult($query);

?>
<div class="pure-g">
	<div class="src-code-box pure-u-1">
		<div class="box-title" style="background: #519251;">
			<span class="mega-octicon octicon-law"></span> 평가하기
		</div>
		<div class="mainform evaluate">
			<form id="values" method="POST" class="pure-form pure-form-stacked">
				<fieldset class="src-code-box pure-u-2-5">
					<label for="datalist">평가할 자료 선택</label>
					<div id="datalist">
						<? foreach ($material_list as $material) : ?>
							<label>
								<input type="radio" name="material-id" value="<?= $material['id'] ?>">
								<?= $material['name'] ?>(<?= $material['url'] ?>)
							</label>
						<? endforeach ?>
					</div>
				</fieldset>
				<fieldset class="src-code-box pure-u-2-5 pure-g" >
					<div class="pure-u-1-3">
						<label for="speed">Speed</label>
						<input id="speed" type="number" name="speed" min="0" max="100" placeholder="0~100">
					</div>

					<div class="pure-u-1-3">
						<label for="size">Size</label>
						<input id="size" type="number" name="size" min="0" max="100" placeholder="0~100">
					</div>

					<div class="pure-u-1-3">
						<label for="ease-of-use">Ease of Use</label>
						<input id="ease-of-use" type="number" name="ease-of-use" min="0" max="100" placeholder="0~100">
					</div>

					<div class="pure-u-1-3">
						<label for="reliablity">Reliability</label>
						<input id="reliablity" type="number" name="reliability" min="0" max="100" placeholder="0~100">
					</div>

					<div class="pure-u-1-3">
						<label>Robustness</label>
						<input id="robustness" type="number" name="robustness" min="0" max="100" placeholder="0~100">
					</div>

					<div class="pure-u-1-3">
						<label>Generality</label>
						<input id="generality" type="number" name="generality" min="0" max="100" placeholder="0~100">
					</div>
					<div>
						<a id="do-evaluate" data-func="do_evaluate"
						class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
							<span class="octicon octicon-checklist"></span> 평가하기
						</a>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#do-evaluate").each(function() {
		var item = $(this);
		item
		.on('start', function (event, args) {
			item.addClass("pure-button-disabled");
			//뷰 이동
			args.file_id = $('.evaluate input[name|=material-id]:checked').val();
			args.speed = $('.evaluate input[name|=speed]').val();
			args.src_size = $('.evaluate input[name|=size]').val();
			args.ease_use = $('.evaluate input[name|=ease-of-use]').val();
			args.reliability = $('.evaluate input[name|=reliability]').val();
			args.robustness = $('.evaluate input[name|=robustness]').val();
			args.generality = $('.evaluate input[name|=generality]').val();
			return true;
		}
		).on('finish', function (event, item, data) {
			item.removeClass("pure-button-disabled");

			if (data.success == 'failed') {
			} 
			else {
				view_change_start();
				load_view('evaluate', function(data) {
					view_change_finish();
				});
			}
			return true;
		});
	});
</script>
<?
?>
