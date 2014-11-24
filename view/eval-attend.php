<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>
<div class="notice mainform">
	<? if ( isset($current_eval) && $current_eval->is_attendable() ) : ?>
	<?=$current_eval->getTime()?>회 평가 신청을 받고 있습니다. 아래에서 신청해주세요!
	<? else: ?>
	신청할 수 있는 평가가 없습니다. 다음 번에 신청해주세요!
	<? endif; ?>
</div>
<? if ( isset($current_eval) && $current_eval->is_attendable() ) : ?>
<div class="pure-g" style="width=70%;">
	<div class="pure-u-1-2">
		<div class="mainform get-eval">
			<div class="box-title">피평가자로 참여하기</div>
			<a id="get-eval" data-func="get-eval"
			class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">참여하기</a>
		</div>
	</div>
	<div class="pure-u-1-2">
		<div class="mainform do-eval">
			<div class="box-title">평가자로 참가하기</div>
			<a id="do-eval" data-func="do-eval"
			class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">참가하기</a>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#get-eval, #do-eval").each(function() {
		var item = $(this);
		item
		.on('start', function (event, args) {
				item.addClass("pure-button-disabled");
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
<? endif; ?>