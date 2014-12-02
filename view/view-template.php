<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// 여기서 view에 필요한 작업을 처리한 뒤, 아래에 출력한다.
$name = "test";

?>
<div class="pure-g" style="text-align:center;">
	<p>이름은 <?=$name?>입니다.</p>
	<!--
	링크 규칙: 반드시 ajax_load 클래스를 넣어야 함.
	data-link가 있다면 페이지 전환, data-func가 있다면 함수 수행(둘 중 하나만 넣어야 함)
	속성:
		data-link: 이동할 페이지를 지정한다
		data-reload: optional. 왼쪽 메뉴를 다시 불러온다.
		data-args: optional. 넘겨줄 데이터를 콤마를 사용해서 넣는다
	-->
	<a class="ajax_load" data-link="error-page" data-reload="true" data-args="testdata:test, name:<?=$name?>">페이지 이동 테스트</a>
	<p>이 링크는 view/error-page.php를 불러오는 링크입니다. 왼쪽 메뉴를 다시 불러오며, testdata와 name이라는 변수를 전달합니다.</p>

	<!--
	data-func는 javascript로 동작을 지정해줘야 한다
	data-func 속성:
		data-func: 수행할 함수를 지정한다.
	-->
	<a class="ajax_load" data-func="error-func" id="error-func">함수 테스트</a>
	<p>이 링크는 func/error-func.php를 수행한 뒤 결과를 받아옵니다.</p>

	<script type="text/javascript">
	// id가 error-func인 객체
	$("#error-func")
	// 클릭 이벤트 시작시
	.on('start', function (event, args, option) {
			// 서버에 전달할 데이터를 args에 넣음
			args.namevalue = <?=$name?>;

			if (args.namevalue == '') {
				// option.success = false로 하면 버튼 클릭이 중지됨. 기본값은 true
				option.success = false;

				// 혹시 모르니 false 리턴
				return false;
			}

			return true;
		}
	// 클릭 이벤트 종료시 (= 서버에서 데이터를 정상적으로 받아온 경우)
	).on('finish', function (event, item, data) {
			// item == 클릭한 버튼 객체, data == 서버에서 받아온 데이터
			if (data.success == 'failed') {
				alert("Failed!");
			} else {
				alert("Success!");
				console.log(data);
			}
			return true;
		}
	);
	</script>
</div>
