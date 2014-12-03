<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>

<div class="pure-g">
	<div class="upload-box pure-u-1-1">
		<div class="mainform upload">
			<div class="box-title" style="background: #00bfFf;">
				<span class="mega-octicon octicon-move-up"></span>&nbsp;소스코드 업로드
			</div>
			<div class="descript">
				<form method="post">
					<textarea rows="10" cols="70" placeholder="Input Source Code"></textarea>
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
			args.srccode = $('.upload textarea').val();
			return true;
		}
		).on('finish', function (event, item, data) {
				if (data.success == 'failed') {
					$('.upload textarea').val('123');
				} else {
				}
				item.removeClass("pure-button-disabled");
				/*view_change_start();
				load_view('', function(data) {
					view_change_finish();
					menu_init();
				}, {menu_reload:'true'}); */
				return true;
			}
		);
	});
</script>


<?
?>
