<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>

<div class="pure-g">
	<div class="upload-box pure-u-2-3">
		<div class="mainform upload">
			<div class="box-title" style="background: #00bfFf;">
				<span class="mega-octicon octicon-move-up"></span>&nbsp;소스코드 업로드
			</div>
			<div class="descript">
				<form method="post">
					URL :
					<textarea rows="10" cols="70" placeholder="Input Your URL"></textarea><br><br>
					FIle Type :
					논문<input type="radio" name="FileType" value="Paper">&nbsp;
					소스코드<input type="radio" name="FileType" value="SourceCode">&nbsp;
					레포트<input type="radio" name="FileType" value="Report"><br><br>
					Major :
					문과대<input type="radio" name="MajorType" value="Liberal">&nbsp;
					경영대<input type="radio" name="MajorType" value="Management">&nbsp;
					이과대<input type="radio" name="MajorType" value="Science">&nbsp;
					공과대<input type="radio" name="MajorType" value="Engineering">&nbsp;
					음대<input type="radio" name="MajorType" value="Music">&nbsp;
					신과대<input type="radio" name="MajorType" value="Theology">&nbsp;
					법과대<input type="radio" name="MajorType" value="Law">&nbsp;
					교대<input type="radio" name="MajorType" value="Education">&nbsp;
					의대<input type="radio" name="MajorType" value="Medic">&nbsp;
					약대<input type="radio" name="MajorType" value="Pharmacy"><br><br>
					기여도 :<input type="number" name="Contribution" placeholder="0~1" step="0.01">
				</form>
			</div>
			<div>
				<a id="upload" data-func="upload"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-checklist"></span> 제출하기
				</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#upload").each(function() {
		var item = $(this);
		item
		.on('start', function (event, args) {
			item.addClass("pure-button-disabled");
			args.url = $('.upload input[type=textarea]').val();
			args.filetype = $('.upload input[name=FileType]').val();
			args.majortype = $('.upload input[name=MajorType]').val();)
			args.contribution = $('.upload input[name=Contribution]').val();
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