<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

?>
<div class="mainform pure-g" style="min-height: 300px; text-align: left;">
	<form class="selector pure-u-1-4 pure-form pure-form-stacked">
		<fieldset>
			<legend>검색 옵션</legend>
	
			<label for="period">평가회차</label>
			<input id="period" type="text">

			<label>검색 결과 선택</label>
			<label for="evaluation-period-view" class="pure-checkbox">
				<input id="evaluation-period-view" class="view-array" type="checkbox" value="평가회차" checked>
				평가회차 보이기
			</label>
			<label for="evaluator-group-view" class="pure-checkbox">
				<input id="evaluator-group-view" class="view-array" type="checkbox" value="평가자 그룹" checked>
				평가자 그룹 보이기
			</label>
			<label for="evaluator-name-view" class="pure-checkbox">
				<input id="evaluator-name-view" class="view-array" type="checkbox" value="평가자 목록" checked>
				평가자 리스트
			</label>
			<label for="evaluater-group-view" class="pure-checkbox">
				<input id="evaluater-group-view" class="view-array" type="checkbox" value="피평가자 그룹" checked>
				피평가자 그룹 보이기
			</label>
			<label for="evaluater-name-view" class="pure-checkbox">
				<input id="evaluater-name-view" class="view-array" type="checkbox" value="피평가자 목록" checked>
				피평가자 리스트
			</label>

			<label>정렬 방식</label>
			<select id="sort-type">
				<option>평가회차id</option>
				<!--option>평가자 그룹</option>
				<option>피평가자 그룹</option-->
			</select>
			<label for="asc-desc" class="pure-checkbox">
				<input id="group-asc-desc" type="checkbox">
				내림차순 정렬
			</label>

			<a id="search-btn" class="ajax_load pure-button pure-button-primary" data-func="search/group">검색하기</a>
		</fieldset>
	</form>
	<div id="result" class="pure-u-3-4">
		<p style="margin:100px auto 0; width: 300px;">검색결과가 없습니다</p>
	</div>
	<script type="text/javascript">
	var item = $("#search-btn");
	item
	.on('start', function (event, args) {
		args["period"] = $("#period").val();
		args["view"] = [];
			// args["view"] 에 체크된 체크박스 value 넣기
			$(".view-array:checked").each(function(){args["view"].push($(this).val())})
		args["sort-type"] = $("#sort-type").val();
		args["asc-desc"] = $("#group-asc-desc").is(":checked");
		return true;
	})
	.on('finish', function (event, item, data) {
		if (data.success == 'success') {
			$("#result").html(data.html);
		}
	});
	</script>
</div>