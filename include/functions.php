<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

function makeLink($class, $text, $link = array()) {
	$return = '<a class="' . $class . '" ';
	if (isset($link['data-link'])) {
		$return .= 'data-link="' . $link['data-link'] . '"';
	} elseif (isset($link['data-func'])) {
		$return .= 'data-func="' . $link['data-func'] . '" ';
		$return .= 'data-func-end="' . $link['data-func-end'] . '" ';
		$return .= 'data-func-arg="' . $link['data-func-arg'] . '"';
	}
	$return .= '>' . $text . '</a>';
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

	foreach($menu_item as $menu) :
		$classname = $menu[1] . " " . $menu[1] . "-" . $menu[2];
		$link = makeLink($classname, $menu[3], array('data-link'=>$menu[0]));
?>
	<li><?=$link?></li>
<?
	endforeach;
}