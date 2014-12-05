<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// 여기서 view에 필요한 작업을 처리한 뒤, 아래에 출력한다.
$name = "test";

$DB = getDB();
$company_list = $DB->getResult(
  "SELECT `이름`
  FROM `회사`"
);

$major = implode(', ', $current_user->company);


var_dump($current_user->company);
?>
<style>
  .mainform {
  }
  form {
    max-width: 500px;
    margin: 0px auto;
  }
  #add-company {
    margin-left: 300px;
  }

  p.description {
    font-size: 12px;
    margin-left: 150px;
  }

  .button-small {
    font-size: 80%;
  }
</style>

<!-- <div class="pure-g" style="text-align:center;"> -->
<div class="mainform">
  <form class="pure-form pure-form-aligned">
    <div>
      <p>회원 정보 수정</p>
      <div class="pure-control-group">
        <label for="id">아이디</label>
        <input id="id" value=<?=$current_user->user_id?> readonly>
      </div>
      <div class="pure-control-group">
        <label for="pw">비밀번호</label>
        <input id="pw" type="password">
      </div>
      <div class="pure-control-group">
        <label for="pw-check">비밀번호 확인</label>
        <input id="pw-check" type="password">
      </div>
      <div class="pure-control-group">
        <label for="name">이름</label>
        <input id="name" value='<?=$current_user->user_name?>' placeholder="ex) 홍길동">
      </div>
      <div class="pure-control-group">
        <label for="hometown">고향</label>
        <input id="hometown" value='<?=$current_user->hometown?>' placeholder="ex) 서울시">
      </div>
      <div class="pure-control-group">
        <label for="university">대학교</label>
        <input id="university" value='<?=$current_user->university?>' placeholder="ex) 연세대학교">
      </div>
      <div class="pure-control-group">
        <label for="speciality">전문 분야</label>
        <input id="speciality" value='<?=$major?>' placeholder="ex) JSP, JS, PHP, ...">
      </div>
      <p class="description">
        ※전문 분야의 구분은 ,(컴마)로 해주시기 바랍니다.<br>
      </p>
    </div>
    <?
    foreach ($current_user->company as $user_company) {
    ?>
      <div class="company-input-part">
        <hr>
        <div class="pure-control-group">
          <label>회사명</label>
          <select name="company-name[]">
            <option>-회사를 선택해 주세요-</option>
            <?
            foreach ($company_list as $company) {
            ?>
              <option value='<?=$company['이름']?>' 
              <? if ($user_company['name'] == $company['이름']) { ?>
              selected
              <? } ?>
              >
                <?=$company['이름']?>
              </option>
            <?
            }
            ?>
          </select>
        </div>
        <div class="pure-control-group">
          <label>시작일</label>
          <input name="company-start-day[]" type="date" value='<?=$user_company['start_day']?>'
          placeholder="YYYY-MM-DD">
        </div>
        <div class="pure-control-group">
          <label>종료일</label>
          <input name="company-end-day[]" type="date" value='<?=$user_company['end_day']?>' 
          placeholder="YYYY-MM-DD">
        </div>
      </div>
    <?
    }
    ?>
    <a id="add-company" class="button-small pure-button">
      회사 추가
    </a>
    <p class="description">
      ※가장 오래된 경력이 가장 위로 오도록 작성해 주시기 바랍니다.<br>
      ※프리랜서로 활동한 기간동안 회사명은 프리랜서로 선택해 주시기 바랍니다.<br>
      ※현재 프리랜서로 활동 중이거나 취직한 경우, 마지막 종료일은 비워주시기 바랍니다.<br>
    </p>
    <fieldset>
      <div class="pure-controls">
        <a id="do-edit-user-info" class="pure-button pure-button-primary ajax_load"
          data-func="do_edit_user_info">
          회원 정보 수정
        </a>
      </div>
    </fieldset>
  </form>

  <script type="text/javascript">
  $("#add-company").on('click', function () {
    $('.company-input-part:last').after(
      $('.company-input-part:last').clone()
    );
    //datepicker를 위해 company 관련 날짜 인풋의 아이디를 수동으로 갱신해 준다.
    $("select[name='company-name[]']:last")
      .val('');
    $("input[name='company-start-day[]']:last")
      .val('');
    $("input[name='company-end-day[]']:last")
      .val('');
  });

  $("#do-edit-user-info").on('start', function (event, args, option) {
    //버튼 클래스 변경
    $("#do-edit-user-info").addClass("pure-button-disabled");

    //회원가입 정보 전송
    args.user_id = $('#id').val();
    if ( $('#pw').val() || $('#pw-check').val() ) {
      args.user_pw = $('#pw').val();
      args.user_pw_check = $('#pw-check').val();
    }
    if ( $('#name').val() != '<?=$current_user->user_name?>' ) {
      args.user_name = $('#name').val();
    }
    if ( $('#hometown').val() != '<?=$current_user->hometown?>' ) {
      args.user_hometown = $('#hometown').val();
    }
    if ( $('#university').val() != '<?=$current_user->university?>' ) {
      args.user_university = $('#university').val();
    }
    if ( $('#speciality').val() != '<?=$major?>' ) {
      args.user_speciality = $('#speciality').val();
    }

    var temp = <?=json_encode($current_user->company)?>;

    for (i = 0; i < $("select[name='company-name[]']").length; i++) {
      for (j = 0; j < temp.length; j++) {
        if ( temp[j].name == $($("select[name='company-name[]']")[i]).val() &&
          temp[j].start_day == $($("input[name='company-start-day[]']")[i]).val() &&
          temp[j].end_day == $($("input[name='company-end-day[]']")[i]).val() ) {
          break;
        }
      }
      if ( j == temp.length ) {
        break;
      }
    }
    if ( i != $("select[name='company-name[]']").length ) {
      args.company_list = [];
      for (i = 0; i < $("select[name='company-name[]']").length; i++) {
        args.company_list.push({
          name: $($("select[name='company-name[]']")[i]).val(),
          start_day: $($("input[name='company-start-day[]']")[i]).val(),
          end_day: $($("input[name='company-end-day[]']")[i]).val()
        });
      }
    }
    return true;
  }).on('finish', function (event, item, data) {
    //버튼 클래스 변경
    item.removeClass("pure-button-disabled");

    return true;
  });
  </script>
</div>
