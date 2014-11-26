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

	$current_menu_type[] = 'all';
	if (!isset($_SESSION['id'])) return ;
	else $current_menu_type[] = 'user';

	$i = 0;
	foreach($menu_item as $menu) :
		$menu_type = $menu[0];
		if ( !in_array($menu_type, $current_menu_type) ) continue;
		$i++;
?>
	.bt-menu ul li:nth-child(<?=$i?>) {transform: translate3d(-100%,<?=(300 - 100 * $i)?>%,0);}
<?
	endforeach;
}

function printMenuContents() {
	global $menu_item;

	$current_menu_type[] = 'all';
	if (!isset($_SESSION['id'])) return ;
	else $current_menu_type[] = 'user';
?>
	<a class="bt-menu-trigger"><span>Menu</span></a>
	<ul>

<?
	foreach($menu_item as $menu) :
		list($menu_type, $view_name, $icon_type, $icon_name, $tooltip_name, $optional) = $menu;

		if ( !in_array($menu_type, $current_menu_type) ) continue;
		$classname = $icon_type . " " . $icon_type . "-" . $icon_name;
		$option = array('data-link'=>$view_name);
		if (isset($optional) && is_array($optional)) $option = array_merge($option, $optional);
		$link = makeLink($classname, $tooltip_name, $option);
?>
		<li><?=$link?></li>
<?
	endforeach;
?>
	</ul>
<?
}