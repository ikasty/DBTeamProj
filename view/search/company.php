<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

?>
<div class="mainform pure-g" style="min-height: 300px; text-align: left;">
	<form class="selector pure-u-1-4 pure-form pure-form-stacked">
		<fieldset>
			<legend>검색 옵션</legend>
	
			<label for="company-name">회사이름</label>
			<input id="company-name" type="text">
		
			<label for="company-major">전문분야</label>
			<input id="company-major" type="text">
		
			<label>검색 결과 선택</label>
			<label for="company-name-view" class="pure-checkbox">
				<input id="company-name-view" class="view-array" type="checkbox" value="회사이름" checked>
				회사이름 보이기
			</label>
			<label for="company-major-view" class="pure-checkbox">
				<input id="company-major-view" class="view-array" type="checkbox" value="전문분야" checked>
				전문분야 보이기
			</label>
			<label for="company-eval-view" class="pure-checkbox">
				<input id="company-eval-view" class="view-array" type="checkbox" value="회사평가" checked>
				회사평가 보이기
			</label>

			<label>정렬 방식</label>
			<select id="sort-type">
				<option>회사이름</option>
				<option>전문분야</option>
				<option>회사평가</option>
			</select>
			<label for="asc-desc" class="pure-checkbox">
				<input id="company-asc-desc" type="checkbox">
				내림차순 정렬
			</label>

			<a id="search-btn" class="ajax_load pure-button pure-button-primary" data-func="search/company">검색하기</a>
		</fieldset>
	</form>
	<div id="result" class="pure-u-3-4">
		<p style="margin:100px auto 0; width: 300px;">검색결과가 없습니다</p>
	</div>
	<script type="text/javascript">
	var item = $("#search-btn");
	item
	.on('start', function (event, args) {
		args["company-name"] = $("#company-name").val();
		args["company-major"] = $("#company-major").val();
		args["view"] = [];
			// args["view"] 에 체크된 체크박스 value 넣기
			$(".view-array:checked").each(function(){args["view"].push($(this).val())})
		args["sort-type"] = $("#sort-type").val();
		args["asc-desc"] = $("#company-asc-desc").is(":checked");
		return true;
	})
	.on('finish', function (event, item, data) {
		if (data.success == 'success') {
			$("#result").html(data.html);
		}
	});
	</script>
</div>