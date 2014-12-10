<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// 여기서 view에 필요한 작업을 처리한 뒤, 아래에 출력한다.
$name = "test";

$DB = getDB();
$company_list = $DB->getResult(
	"SELECT `이름`
	FROM `회사`"
);
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
			<p>회원 가입</p>
			<div class="pure-control-group">
				<label for="id">아이디</label>
				<input id="id">
				<a id="check-user-id-duple" class="pure-button pure-button-primary ajax_load"
					data-func="check_user_id_duple" place>
					아이디 중복 확인
				</a>
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
				<input id="name" placeholder="ex) 홍길동">
			</div>
			<div class="pure-control-group">
				<label for="hometown">고향</label>
				<input id="hometown" placeholder="ex) 서울시">
			</div>
			<div class="pure-control-group">
				<label for="university">대학교</label>
				<input id="university" placeholder="ex) 연세대학교">
			</div>
			<div class="pure-control-group">
				<label for="speciality">전문 분야</label>
				<input id="speciality" placeholder="ex) JSP, JS, PHP, ...">
			</div>
			<p class="description">
				※전문 분야의 구분은 ,(컴마)로 해주시기 바랍니다.<br>
			</p>
		</div>
		<div class="company-input-part">
			<hr>
			<div class="pure-control-group">
				<label>회사명</label>
				<select name="company-name[]">
					<option value="">-회사를 선택해 주세요-</option>
					<?
					foreach ($company_list as $company) {
					?>
						<option value=<?=$company['이름']?>><?=$company['이름']?></option>
					<?
					}
					?>
				</select>
				<div class="delete-button">×</div>
			</div>
			<div class="pure-control-group">
				<label>시작일</label>
				<input id="company-start-day0" name="company-start-day[]" type="date" placeholder="YYYY-MM-DD">
			</div>
			<div class="pure-control-group">
				<label>종료일</label>
				<input id="company-end-day0" name="company-end-day[]" type="date" placeholder="YYYY-MM-DD">
			</div>
		</div>
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
				<a id="do-join" class="pure-button pure-button-primary ajax_load"
					data-func="do_join">
					회원 가입
				</a>
			</div>
		</fieldset>
	</form>


	<!-- <a class="ajax_load" data-link="error-page" data-reload="true" data-args="testdata:test, name:<?=$name?>">페이지 이동 테스트</a>
	<p>이 링크는 view/error-page.php를 불러오는 링크입니다. 왼쪽 메뉴를 다시 불러오며, testdata와 name이라는 변수를 전달합니다.</p>
	<a class="ajax_load" data-func="error-func" id="error-func">함수 테스트</a>
	<p>이 링크는 func/error-func.php를 수행한 뒤 결과를 받아옵니다.</p> -->

	<script type="text/javascript">
	var flagCheckUserIdDuple = 0;
	var newCompanyId = 1;

	// $("input[name='company_start_day[]']:last").datepicker();
	// $("input[name='company_end_day[]']:last").datepicker();


	$("#check-user-id-duple").on('start', function (event, args, option) {
		//버튼 클래스 변경
		$('#do-join').addClass('pure-button-disabled');
		$("#check-user-id-duple").addClass("pure-button-disabled");

		//확인할 아이디 전송
		args.user_id = $('#id').val();
		
		return true;
	}).on('finish', function (event, item, data) {
		//버튼 클래스 변경
		$('#do-join').removeClass('pure-button-disabled');
		item.removeClass("pure-button-disabled");
		
		if (data.success == 'failed') {
			flagCheckUserIdDuple = 0;
		}
		else {
			flagCheckUserIdDuple = 1;
		}
		return true;
	});

	$("#id").on('change', function () {
		flagCheckUserIdDuple = 0;
	});

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
			// .datepicker();
		$("input[name='company-start-day[]']:last")
			.attr('id', 'company-start-day'+newCompanyId)
			.val('');
			// .datepicker();
		$("input[name='company-end-day[]']:last")
			.attr('id', 'company-end-day'+newCompanyId)
			.val('');
			// .datepicker();
		newCompanyId += 1;

		$(".delete-button:last").on('click', function () {
		  $(this).parents(".company-input-part").remove();
		});
		$(".delete-button:last").removeClass('invisible');
	});

	$("#do-join").on('start', function (event, args, option) {
		//버튼 클래스 변경
		$('#check-user-id-duple').addClass("pure-button-disabled");
		$("#do-join").addClass("pure-button-disabled");

		//회원가입 정보 전송
		args.user_id = $('#id').val();
		args.user_pw = $('#pw').val();
		args.user_pw_check = $('#pw-check').val();
		args.user_name = $('#name').val();
		args.user_hometown = $('#hometown').val();
		args.user_university = $('#university').val();
		args.user_speciality = $('#speciality').val();
		args.company_list = [];
		for (i = 0; i < $("select[name='company-name[]']").length; i++) {
			args.company_list.push({
				name: $($("select[name='company-name[]']")[i]).val(),
				start_day: $($("input[name='company-start-day[]']")[i]).val(),
				end_day: $($("input[name='company-end-day[]']")[i]).val(),
			});
		}
		args.flag_check_user_id_duple = flagCheckUserIdDuple;
		
		return true;
	}).on('finish', function (event, item, data) {
		//버튼 클래스 변경
		$('#check-user-id-duple').removeClass("pure-button-disabled");
		item.removeClass("pure-button-disabled");

		if (data.success == 'failed') {
		} 
		else {
			view_change_start();
			load_view('login', function(data) {
				view_change_finish();
			}, {});
		}

		return true;
	});
	</script>
</div>
