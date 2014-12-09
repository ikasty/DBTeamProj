<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

?>
<div class="mainform pure-g" style="min-height: 300px; text-align: left;">
	<form class="selector pure-u-1-4 pure-form pure-form-stacked">
		<fieldset>
			<legend>검색 옵션</legend>
	
			<label for="developer-id">개발자 id</label>
			<input id="developer-id" type="text">

			<label for="developer-name">개발자 이름</label>
			<input id="developer-name" type="text">

			<label for="company-name">회사 이름</label>
			<input id="company-name" type="text">
		
			<label for="developer-major">전문분야</label>
			<input id="developer-major" type="text">

			<label>인사 변동기간</label>
			<div class="pure-form">
				<input id="change-start" type="date" style="width:40%; display: inline-block;"> ~ 
				<input id="change-end" type="date" style="width:40%; display: inline-block;">
			</div>
		
			<legend>검색 결과 선택</legend>
			<div class="pure-g" style="margin: 0;">
				<div class="pure-u-1-2" style="padding: 0;">
					<label for="developer-id-view" class="pure-checkbox">
						<input id="developer-id-view" class="view-array" type="checkbox" value="개발자 id" checked>
						개발자 id
					</label>
					<label for="join-date-view" class="pure-checkbox">
						<input id="join-date-view" class="view-array" type="checkbox" value="입사일" checked>
						입사일
					</label>
					<label for="company-name-view" class="pure-checkbox">
						<input id="company-name-view" class="view-array" type="checkbox" value="회사이름" checked>
						회사이름
					</label>
					<label for="eval-view" class="pure-checkbox">
						<input id="eval-view" class="view-array" type="checkbox" value="평균점수" checked>
						평균점수
					</label>
				</div>
				<div class="pure-u-1-2" style="padding: 0;">
					<label for="developer-name-view" class="pure-checkbox">
						<input id="developer-name-view" class="view-array" type="checkbox" value="개발자 이름" checked>
						이름
					</label>
					<label for="part-date-view" class="pure-checkbox">
						<input id="part-date-view" class="view-array" type="checkbox" value="퇴사일" checked>
						퇴사일
					</label>
					<label for="developer-major-view" class="pure-checkbox">
						<input id="developer-major-view" class="view-array" type="checkbox" value="전문분야" checked>
						전문분야
					</label>
				</div>
			</div>

			<label>정렬 방식</label>
			<select id="sort-type">
				<option>개발자 id</option>
				<option>개발자 이름</option>
				<option>입사일</option>
				<option>퇴사일</option>
				<option>회사이름</option>
				<option>전문분야</option>
				<option>평균점수</option>
			</select>
			<label for="asc-desc" class="pure-checkbox">
				<input id="company-asc-desc" type="checkbox">
				내림차순 정렬
			</label>

			<a id="search-btn" class="ajax_load pure-button pure-button-primary" data-func="search/developer">검색하기</a>
		</fieldset>
	</form>
	<div id="result" class="pure-u-3-4">
		<p style="margin:100px auto 0; width: 300px;">검색결과가 없습니다</p>
	</div>
	<script type="text/javascript">
	var item = $("#search-btn");
	item
	.on('start', function (event, args) {
		args["developer-id"] = $("#developer-id").val();
		args["developer-name"] = $("#developer-name").val();
		args["company-name"] = $("#company-name").val();
		args["developer-major"] = $("#developer-major").val();
		args["change-start"] = $("#change-start").val();
		args["change-end"] = $("#change-end").val();
		
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