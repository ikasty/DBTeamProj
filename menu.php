<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);


function printMenuHeader() {
	global $menu_item;

	$i = 0;
	foreach($menu_item as $menu) :
		$i++;
?>
.bt-menu ul li:nth-child(<?=$i?>) {transform: translate3d(-100%,<?=300 - 100 * $i?>%,0);}
<?
	endforeach;
}

function printMenuContents() {
	global $menu_item;

	foreach($menu_item as $menu) :
		$datalink = $menu[0];
		$icontype = $menu[1];
		$classname = $icontype . " " . $icontype . "-" . $menu[2];
		$tooltip = $menu[3];
?>
	<li><a data-link="<?=$datalink?>" class="ajax_load <?=$classname?>"><?=$tooltip?></a></li>
<?
	endforeach;
}