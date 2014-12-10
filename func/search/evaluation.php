<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

if (sizeof($ARGS["view"]) == 0) die(json_encode(-1));
$db = getDB();

// 변수는 $ARGS에 담겨있음
// var_dump($ARGS);

$where_replace_arr = array(
  'do-eval-id' => "`A`.`평가자id`='{$ARGS['do-eval-id']}'", 
  'get-eval-id' => "`A`.`피평가자id`='{$ARGS['get-eval-id']}'", 
  'get-eval-major' => "`전문분야` LIKE '%{$ARGS['get-eval-major']}%'",
  'eval-start-date' => "`A`.`평가시기`>='{$ARGS['eval-start-date']}'", 
  'eval-end-date' => "`A`.`평가시기`<='{$ARGS['eval-end-date']}'", 
  'eval-period' => "`A`.`평가회차`='{$ARGS['eval-period']}'" 
);

$select_replace_arr = array(
  '자료 ID' => '`A`.`자료id`', 
  '평가자 ID' => '`A`.`평가자id`', 
  '피평가자 ID' => '`A`.`피평가자id`', 
  '피평가자 전문 분야' => "GROUP_CONCAT(`최신전문분야`.`전문분야` ORDER BY `최신전문분야`.`전문분야` SEPARATOR ', ') as `전문분야`", 
  '평가 시기' => '`A`.`평가시기`', 
  '평가 회차' => '`A`.`평가회차`', 
  '평가 점수' => '`A`.`평가점수`'
);

$order_replace_arr = array(
  '자료 ID' => '`A`.`자료id`', 
  '평가자 ID' => '`A`.`평가자id`', 
  '피평가자 ID' => '`A`.`피평가자id`', 
  '피평가자 전문 분야' => "`전문분야`", 
  '평가 시기' => '`A`.`평가시기`', 
  '평가 회차' => '`A`.`평가회차`', 
  '평가 점수' => '`A`.`평가점수`'
);

$select_arr = array();
foreach ($ARGS['view'] as $val) {
  $select_arr[] = $select_replace_arr[$val];
}
$where_arr = array();
foreach ($ARGS as $key=>$val) {
  if( isset($where_replace_arr[$key]) && $val) {
    $where_arr[] = $where_replace_arr[$key];
  } 
}


$query = "select " . implode(', ', $select_arr) . "
from (
  select `평가하기`.`개발자id` as `평가자id`, 
    `평가하기`.`평가날짜` as `평가시기`, 
    `평가하기`.`평가회차` as `평가회차`, 
    `평가자료`.`개발자id` as `피평가자id`, 
    `평가점수`.`평균점수` as `평가점수`,
    `평가자료`.`자료id` as `자료id`
  from `평가하기`
  inner join `평가자료`
  on `평가하기`.`자료id`=`평가자료`.`자료id`
  
  inner join `평가점수`
  on `평가하기`.`평가id`=`평가점수`.`평가id`
) A
inner join `최신전문분야`
on `A`.`피평가자id`=`최신전문분야`.`개발자id`" . 
(count($where_arr)? " WHERE " . implode(' AND ', $where_arr) :" ").
"GROUP BY `A`.`자료id` " .
"ORDER BY " . $order_replace_arr[$ARGS["sort-type"]] .
($ARGS["asc-desc"] === 'true'? " DESC ": " ");

$result = $db->getResult($query);

$return["success"] = "success";
var_dump($query);
ob_start();
?>
<table class="pure-table pure-table-horizontal">
<thead>
  <tr>
    <? foreach ($ARGS['view'] as $val) : ?>
      <th><?= $val ?></th>
    <? endforeach; ?>
  </tr>
</thead>
<tbody>
  <?
  $i = 0; 
  foreach ($result as $tuple) : ?>
  <tr<?=($i % 2) ? ' class="pure-table-odd"' : ""?>>
    <? foreach ($tuple as $val) : ?>
      <th><?= $val ?></th>
    <? endforeach; ?>
  </tr>
  <?
  $i += 1; 
  endforeach; ?>
</tbody>
</thead>
<tbody>
</tbody>
</table>
<?
$return["html"] = ob_get_clean();
?>