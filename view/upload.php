<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$db = getDB();
$query = $db->makeQuery(
	"SELECT * FROM `평가자료` a WHERE `업로드시간` = (\n"
    	. "SELECT MAX(`업로드시간`) FROM `평가자료` b WHERE a.`자료id` = b.`자료id` GROUP BY b.`자료id`)"
	. " AND `개발자id`=%s", $current_user->developer_id);

$data = $db->getResult($query);

?>

<div class="pure-g">
	<div class="upload-box pure-u-2-3">
		<div class="mainform upload">
			<div class="box-title" style="background: #00bfFf;">
				<span class="mega-octicon octicon-move-up"></span>&nbsp;소스코드 업로드
			</div>
			<div class="descript">
				<form method="post">
					자료이름 :
					<input type="text" name="fname"><br><br>
					URL :
					<input type="URL" name="URL" placeholder="Input Your URL"><br><br>
					FIle Type :
					논문<input type="radio" name="FileType" value="Paper">&nbsp;
					소스코드<input type="radio" name="FileType" value="SourceCode">&nbsp;
					레포트<input type="radio" name="FileType" value="Report"><br><br>
					기여도 :<input type="number" name="Contribution" placeholder="0~1" step="0.01">
				</form>
			</div>
			<div>
				<a id="upload" data-func="do_upload"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-checklist"></span> 제출하기
				</a>
			</div>
		</div>
	</div>
	<div class="pure-u-1-3">
		<div class="mainform">
			<h4>자료 수정</h4>
			<form class="pure-form">
			<?foreach ($data as $value) :?>
				<label class="pure-checkbox"><input type="checkbox" class="upload-edit" value="<?=$value['자료id']?>"> <?=$value['자료이름']?></label>
			<?endforeach;?>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#upload").each(function() {
		var item = $(this);
		item
		.on('start', function (event, args) {
			item.addClass("pure-button-disabled");
			args.fname = $('.upload input[type=text]').val();
			args.url = $('.upload input[name=URL]').val();
			args.filetype = $('.upload input[name=FileType]').val();
			args.contribution = $('.upload input[name=Contribution]').val();
			change = $('.upload-edit:checked');
			if (typeof change !== "undefined") args.changeid = change.val();
			return true;
		}
		).on('finish', function (event, item, data) {
				if (data.success == 'failed') {
				} else {
				}
				item.removeClass("pure-button-disabled");
				return true;
			}
		);
	});
</script>
<?
?>
