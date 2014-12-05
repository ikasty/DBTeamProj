<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

/*
$DB = getDB();

$var 은 평가할 자료id
$query = $DB->MakeQuery("SELECT '자료정보' as url FROM '평가자료' WHERE 자료id=%s", $var);
$url = $DB->getResult($query);

$query = $DB->MakeQuery("SELECT '자료분야' as filetype FROM '자료분야' WHERE 자료id=%s", $var);
$filetype = $DB->getResult($query);
*/
?>
<div class="pure-g" style="text-align:center;">
	<div class="evaluate-box pure-u-2-5">
		<div class="mainform evaluate">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-law"></span> 평가하기
			</div>
			<div class="descript">
				오른쪽 평가자료를 평가해 주세요
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
				Portability
				<input type="number" name="Portability" min="0" max="100" placeholder="0~100">
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
				<!-- 평가할 소스코드 불러오기
				$url[url]
				$filetype[filetype] -->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#evaluate").each(function() {
		var item = $(this);
		item
		.on('start', function (event, args) {
			item.addClass("pure-button-disabled");
			args.speed = $('.evaluate input[name=Speed]').val();
			args.src_size = $('.evaluate input[name=Size]').val();
			args.ease_use = $('.evaluate input[name=Ease-of-Use]').val();
			args.reliabiltiy = $('.evaluate input[name=Reliability]').val();
			args.robustness = $('.evaluate input[name=Robustness]').val();
			args.portability = $('.evaluate input[name=Portability]').val();
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
