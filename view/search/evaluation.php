<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

?>
<div class="mainform pure-g" style="min-height: 300px; text-align: left;">
  <form class="selector pure-u-1-4 pure-form pure-form-stacked">
    <fieldset>
      <legend>검색 옵션</legend>
  
      <label for="do-eval-id">평가자 ID</label>
      <input id="do-eval-id" type="text">
    
      <label for="get-eval-id">피평가자 ID</label>
      <input id="get-eval-id" type="text">

      <label for="get-eval-major">피평가자 전문 분야</label>
      <input id="get-eval-major" type="text">

      <label>평가 시기</label>
      <div class="pure-form">
        <input id="eval-start-date" type="date" style="width:40%; display: inline-block;">~
        <input id="eval-end-date" type="date" style="width:40%; display: inline-block;">
      </div>

      <label for="eval-period">평가 회차</label>
      <input id="eval-period" type="number">
    
      <label>검색 결과 선택</label>
      <label for="material-id-view" class="pure-checkbox">
        <input id="material-id-view" class="view-array" type="checkbox" value="자료 ID" checked>
        평가 자료 ID 보이기
      </label>
      <label for="do-eval-id-view" class="pure-checkbox">
        <input id="do-eval-id-view" class="view-array" type="checkbox" value="평가자 ID" checked>
        평가자 ID 보이기
      </label>
      <label for="get-eval-id-view" class="pure-checkbox">
        <input id="get-eval-id-view" class="view-array" type="checkbox" value="피평가자 ID" checked>
        피평가자 ID 보이기
      </label>
      <label for="get-eval-major-view" class="pure-checkbox">
        <input id="get-eval-major-view" class="view-array" type="checkbox" value="피평가자 전문 분야" checked>
        피평가자 전문 분야 보이기
      </label>
      <label for="eval-date-view" class="pure-checkbox">
        <input id="eval-date-view" class="view-array" type="checkbox" value="평가 시기" checked>
        평가 시기 보이기
      </label>
      <label for="eval-period-view" class="pure-checkbox">
        <input id="eval-period-view" class="view-array" type="checkbox" value="평가 회차" checked>
        평가 회차 보이기
      </label>
      <label for="eval-point-view" class="pure-checkbox">
        <input id="eval-point-view" class="view-array" type="checkbox" value="평가 점수" checked>
        평가 점수 보이기
      </label>

      <label>정렬 방식</label>
      <select id="sort-type">
        <option>자료 ID</option>
        <option>평가자 ID</option>
        <option>피평가자 ID</option>
        <option>피평가자 전문 분야</option>
        <option>평가 시기</option>
        <option>평가 회차</option>
        <option>평가 점수</option>
      </select>
      <label for="asc-desc" class="pure-checkbox">
        <input id="company-asc-desc" type="checkbox">
        내림차순 정렬
      </label>

      <a id="search-btn" class="ajax_load pure-button pure-button-primary" data-func="search/evaluation">검색하기</a>
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
    args["eval-end-date"] = $("#eval-end-date").val();
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