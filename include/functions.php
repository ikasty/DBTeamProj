<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

function makeLink($class, $text, $link = array(), $attr = '') {
	$return = '<a class="ajax_load ' . $class . '" ';
	foreach($link as $key=>$value)
		$return .= $key . '="' . $value . '" ';
	$return .= $attr . '>' . $text . '</a>';
	return $return;
}

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

	if (!isset($_SESSION['id'])) return ;
	else $menu_type = 'user';
?>
	<a class="bt-menu-trigger"><span>Menu</span></a>
	<ul>

<?
	foreach($menu_item as $menu) :
		if ($menu_type != $menu[0]) continue;
		$classname = $menu[2] . " " . $menu[2] . "-" . $menu[3];
		$option = array('data-link'=>$menu[1]);
		if (isset($menu[5]) && is_array($menu[5])) $option = array_merge($option, $menu[5]);
		$link = makeLink($classname, $menu[4], $option);
?>
		<li><?=$link?></li>
<?
	endforeach;
?>
	</ul>
<?
}