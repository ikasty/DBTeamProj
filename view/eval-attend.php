<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>
<div class="mainform">
	<? if ( isset($current_eval) && $current_eval->is_attendable() ) : ?>
	<span class="octicon octicon-info"></span> <?=$current_eval->getTime()?>회 평가 신청을 받고 있습니다. 아래에서 신청해주세요!
	<? else: ?>
	<span class="octicon octicon-alert"></span> 신청할 수 있는 평가가 없습니다. 다음 번에 신청해주세요!
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
				<a id="get-eval" data-func="eval_attend"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-checklist"></span> 참여하기
				</a>
				<span class="checker" style="position:absolute; margin-left: 16px;"> </span>
			</div>
		</div>
	</div>
	<div class="eval-attend-box pure-u-2-5">
		<div class="mainform do-eval">
			<div class="box-title" style="background: #2c4985;">
				<span class="mega-octicon octicon-law"></span> 평가하기
			</div>
			<div class="descript">
				다른 개발자들의 작업물을 감상하시고, 평가하세요!
			</div>
			<div>
				<a id="do-eval" data-func="eval_attend"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-law"></span> 참가하기
				</a>
				<span class="checker" style="position:absolute; margin-left: 16px;"> </span>
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
				args.jointype = item.attr('id');
				item.parent().children(".checker").html('<img src="/image/throbber_small.gif">');
				item.addClass("pure-button-disabled");
				return true;
			}
		).on('finish', function (event, item, data) {console.log(data, item.parent().children(".checker"));
				if (data.success == 'failed') {
					item.parent().children(".checker").html('<span class="mega-octicon octicon-alert" style="color:red;"></span>');
					item.removeClass("pure-button-disabled");
				} else {
					item.parent().children(".checker").html('<span class="mega-octicon octicon-check" style="color:green;"></span>');
				}
				return true;
			}
		);
	});
</script>
<? endif; ?>