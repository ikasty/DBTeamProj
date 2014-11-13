<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$return = array(
	"message" => "try login as id = " . $ARGS['userid'] . ", password = " . $ARGS['password']
);
if ($ARGS['userid'] != 'test' || $ARGS['password'] != 'asdf') $return['success'] = "failed";
else $return['success'] = "success";
echo json_encode($return);
?>