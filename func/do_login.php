<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$return = array(
	"message" => "try login as id = " . $ARGS['userid'] . ", password = " . $ARGS['password']
);

if ($ARGS['userid'] != 'test' || $ARGS['password'] != 'dGVzdA==') $return['success'] = "failed";
else {
	$_SESSION['id'] = $ARGS['userid'];
	$return['success'] = "success";
}
echo json_encode($return);
?>