<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

$user_count = 10; // 회원수 구하기

?>
<div class="mainform">
	<p>안녕하세요, <?=$current_user->user_name?>님!</p>
<?// if ($current_user->is_admin()) : ?>
	<p>현재 <?=$user_count?>명의 개발자가 등록되어 있습니다.</p>
	<? if (isset($current_eval)) : ?>
	<p><?=$current_eval->getTime()?>회차 평가가 <?=($current_eval->isON() ? "진행중입니다" : "종료되었습니다")?>.</p>
	<? else : ?>
	<p>진행중인 평가가 없습니다.</p>
	<? endif; ?>
<?// else : ?>
	<p>현재 <?=$current_user->company_name?>에서 근무중이십니다. 작업하신 프로젝트를 관리해보세요!</p>
<?// endif; ?>
</div>


