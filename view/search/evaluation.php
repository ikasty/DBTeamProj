<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

?>
<div class="mainform pure-g" style="min-height: 300px; text-align: left;">
  <form class="selector pure-u-1-4 pure-form pure-form-stacked">
    <fieldset>
      <legend>검색 옵션</legend>
  
      <label for="do-eval-id">평가자 ID</label>
      <input id="do-eval-id" type="text">
    
      <label for="get-evel-id">피평가자 ID</label>
      <input id="get-evel-id" type="text">

      <label for="get-evel-major">피평가자 전문 분야</label>
      <input id="get-evel-major" type="text">

      <label for="evel-start-date">평가 시기</label>
      <input id="evel-start-date" type="text">~
      <input id="evel-end-date" type="text">

      <label for="evel-period">평가 회차</label>
      <input id="evel-period" type="text">
    
      <label>검색 결과 선택</label>
      <label for="do-eval-id-view" class="pure-checkbox">
        <input id="do-eval-id-view" class="view-array" type="checkbox" value="평가자_ID" checked>
        평가자 ID 보이기
      </label>
      <label for="get-eval-id-view" class="pure-checkbox">
        <input id="get-eval-id-view" class="view-array" type="checkbox" value="피평가자_ID" checked>
        피평가자 ID 보이기
      </label>
      <label for="get-eval-major" class="pure-checkbox">
        <input id="get-eval-major" class="view-array" type="checkbox" value="피평가자_전문_분야" checked>
        피평가자 전문 분야 보이기
      </label>
      <label for="evel_date" class="pure-checkbox">
        <input id="eval_date" class="view-array" type="checkbox" value="평가_시기" checked>
        평가 시기 보이기
      </label>
      <label for="eval_period" class="pure-checkbox">
        <input id="eval_period" class="view-array" type="checkbox" value="평가_회차" checked>
        평가 회차 보이기
      </label>

      <label>정렬 방식</label>
      <select id="sort-type">
        <option>평가자 ID</option>
        <option>피평가자 ID</option>
        <option>피평가자 전문 분야</option>
        <option>평가 시기</option>
        <option>평가 회차</option>
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
    args["do-eval-id"] = $("#do-eval-id").val();
    args["get-eval-id"] = $("#get-eval-id").val();
    args["get-eval-major"] = $("#get-eval-major").val();
    args["eval-start-date"] = $("#eval-start-date").val();
    args["eval-end-date"] = $("#eval-end-id").val();
    args["eval-period"] = $("#eval-period").val();
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