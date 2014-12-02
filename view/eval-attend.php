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
<? if ( isset($current_eval) && $current_eval->is_attendable() || true ) : ?>
<div class="pure-g" style="text-align:center;">
	<div class="eval-attend-box pure-u-2-5">
		<div class="mainform get-eval">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-checklist"></span> 평가받기
			</div>
			<div class="descript">
				자신의 자료를 최대 5개까지 등록하여 평가받을 수 있습니다.
			</div>
			<div>
				<a id="get-eval" data-func="get-eval"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-checklist"></span> 참여하기
				</a>
			</div>
		</div>
	</div>
	<div class="eval-attend-box pure-u-2-5">
		<div class="mainform do-eval">
			<div class="box-title" style="background: #2c4985;">
				<span class="mega-octicon octicon-law"></span> 평가하기
			</div>
			<div class="descript">
				다른 개발자들의 작업물을 감상하시고, 평가하고, 소통하세요!
			</div>
			<div>
				<a id="do-eval" data-func="do-eval"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-law"></span> 참가하기
				</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// id가 get-eval 또는 do-eval인 개체
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