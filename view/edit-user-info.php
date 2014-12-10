<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// 여기서 view에 필요한 작업을 처리한 뒤, 아래에 출력한다.
$name = "test";

$DB = getDB();
$company_list = $DB->getResult(
  "SELECT `이름`
  FROM `회사`"
);

// $current_user = User::getUser($current_user->user_id);
if (is_array($current_user->major))
  $major = implode(', ', $current_user->major);
else
  $major = '';
// var_dump($current_user);

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

  .delete-button {
    width: 20px;
    height: 20px;
    border-radius: 20px;
    background-color: #f15f5f;
    text-align: center;
    display: inline-block;
    cursor: pointer;
    font-size: 13px;
    color: white;
  }
  .invisible {
    display: none;
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
        <label for="cur-pw">현재 비밀번호</label>
        <input id="cur-pw" type="password">
      </div>
      <div class="pure-control-group">
        <label for="pw">새 비밀번호</label>
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
      <?if (!$current_user->is_admin()) : ?>
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
      <?endif;?>
    </div>
    <?
    if (!$current_user->is_admin()) :
    $i = 0;
    foreach ($current_user->company as $user_company) :
    ?>
      <div class="company-input-part">
        <hr>
        <div class="pure-control-group">
          <label>회사명</label>
          <select name="company-name[]">
            <option value="">-회사를 선택해 주세요-</option>
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
          <div class="delete-button">×</div>
        </div>
        <div class="pure-control-group">
          <label>시작일</label>
          <input name="company-start-day[]" type="date" value='<?=$user_company['start_day']?>'
          placeholder="ex) YYYY-MM-DD">
        </div>
        <div class="pure-control-group">
          <label>종료일</label>
          <input name="company-end-day[]" type="date" value='<?=$user_company['end_day']?>' 
          placeholder="ex) YYYY-MM-DD">
        </div>
      </div>
    <?
      $i++;
      endforeach;
    ?>
    <a id="add-company" class="button-small pure-button">
      회사 추가
    </a>
    <p class="description">
      ※가장 오래된 경력이 가장 위로 오도록 작성해 주시기 바랍니다.<br>
      ※프리랜서로 활동한 기간동안 회사명은 프리랜서로 선택해 주시기 바랍니다.<br>
      ※현재 프리랜서로 활동 중이거나 취직한 경우, 마지막 종료일은 비워주시기 바랍니다.<br>
    </p>
    <?endif;?>
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
  $(".delete-button").on('click', function () {
    $(this).parents(".company-input-part").remove();
  });
  $(".delete-button:first").addClass('invisible');


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

    $(".delete-button:last").on('click', function () {
      $(this).parents(".company-input-part").remove();
    });
    $(".delete-button:last").removeClass('invisible');
  });



  $("#do-edit-user-info").on('start', function (event, args, option) {
    //버튼 클래스 변경
    $("#do-edit-user-info").addClass("pure-button-disabled");

    //회원가입 정보 전송
    args.user_id = $('#id').val();
    args.user_cur_pw = $('#cur-pw').val();
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
      if ( $("select[name='company-name[]']").length != temp.length) {
        break;
      }
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
    // 버튼 클래스 변경
    item.removeClass("pure-button-disabled");
    
    // 페이지 리로드
    if (data.success == 'failed') {
    } 
    else {
      view_change_start();
      load_view('main', function(data) {
        view_change_finish();
      }, {});
    }
    return true;
  });
  </script>
</div>
