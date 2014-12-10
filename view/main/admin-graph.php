<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$db = getDB();
$user_count = $db->getValue("SELECT count(*) FROM 개발자");
$company_count = $db->getValue("SELECT count(*) FROM 회사");
$file_count = $db->getValue("SELECT count(*) FROM 평가자료");
?>
<div class="pure-g main-area">
	<div class="pure-u-1-3">
		<div class="mainform" style="padding-bottom:10px;">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-graph"></span> 전체 통계
			</div>
			<div class="boxgroup">
				<span class="boxinfo" style="background: #3B84D7;">
					<span><span class="mega-octicon octicon-person"></span> <?=$user_count?></span>
				</span>
				<span class="boxinfo" style="background: #4ADBAD;">
					<span><span class="mega-octicon octicon-organization"></span> <?=$company_count?></span>
				</span>
				<span class="boxinfo" style="background: #9E6ACF;">
					<span><span class="mega-octicon octicon-file-text"></span> <?=$file_count?></span>
				</span>
			</div>
		</div>
	</div>
</div>