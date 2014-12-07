<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

?>
<div class="pure-g"><div class="pure-u-1-1">
<div class="mainform">
	<p>안녕하세요, <?=$current_user->user_name?>님!
<? if ($current_user->is_admin()) : ?>
	<? if (isset($current_eval)) : ?>
	<?=$current_eval->getTime()?>회차 평가가 <?=($current_eval->isON() ? "진행중입니다" : "종료되었습니다")?>.
	<? else : ?>
	진행중인 평가가 없습니다.
	<? endif; ?>
<? else : 
  $company_last_index = count($current_user->company)-1;
  $company_name = $current_user->company[$company_last_index]['name'];
  ?>
	현재 <?=$company_name?>에서 근무중이십니다. 작업하신 프로젝트를 관리해보세요!
<? endif; ?>
	</p>
</div>
</div></div>
<?
//if ($current_user->is_admin())
//	include("main/admin-graph.php");
//else
	include("main/developer-graph.php");
?>