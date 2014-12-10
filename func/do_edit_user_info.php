<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$DB = getDB();
//폼 유효성을 관리하는 변수
$validate = true;

$pw = $DB->getColumn(
  "SELECT `비밀번호`
  FROM `유저`
  WHERE `id`='{$ARGS['user_id']}';");
$pw = $pw[0];
if ( $ARGS['user_cur_pw'] != $pw ) {
  addMessage("현재 비밀번호가 불일치합니다.");
  $result['success'] = 'failed';
  $validate = false;
}

if ( $ARGS['user_pw'] != $ARGS['user_pw_check'] ) {
  addMessage("비밀번호와 비밀번호 확인이 불일치합니다.");
  $result['success'] = 'failed';
  $validate = false;
}



if ($validate) {
  $set_query = '';
  if (isset($ARGS['user_name'])) {
    $set_query .= "`이름`='{$ARGS['user_name']}',";
  }
  if (isset($ARGS['user_pw'])) {
    $set_query .= "`비밀번호`='{$ARGS['user_pw']}',";
  }
  if ( $set_query ) {
    $set_query = rtrim($set_query, ",");
    $query = 
      "UPDATE `유저`
      SET $set_query
      WHERE `id`='{$ARGS['user_id']}'";
    $DB->query($query);
  }


  $set_query = '';
  if (isset($ARGS['user_university'])) {
    $set_query .= "`대학교`='{$ARGS['user_university']}',";
  }
  if (isset($ARGS['user_hometown'])) {
    $set_query .= "`고향`='{$ARGS['user_hometown']}',";
  }
  if ( $set_query ) {
    $set_query = rtrim($set_query, ",");
    $query = 
      "UPDATE `개발자`
      SET $set_query
      WHERE `id`='{$ARGS['user_id']}'";
    $DB->query($query);
  }

  if (isset($ARGS['user_speciality'])) {
    // major 배열화
    $raw_major_list = explode(',', $ARGS['user_speciality']);
    $major_list = array();
    foreach ($raw_major_list as $raw_major) {
      $major = preg_replace('/\s+/', '', $raw_major);
      if ($major) {
        $major_list[] = $major;
      }
    }

    $DB->query(
      "DELETE FROM `전문분야`
      WHERE `id`='{$ARGS['user_id']}'"
    );
    foreach($major_list as $major) {
      $query = $DB->MakeQuery("INSERT INTO `전문분야`(`id`, `전문분야`) VALUES(%s, %s)", 
        $ARGS['user_id'],
        $major
      );
      $DB->query($query);
    }
  }

  if (isset($ARGS['company_list'])) {
    $DB->query(
      "DELETE FROM `근무`
      WHERE `개발자id`='{$ARGS['user_id']}'"
    );
    foreach($ARGS['company_list'] as $company) {
      $query = $DB->MakeQuery("INSERT INTO `근무`(`회사이름`, `개발자id`, `입사일`, `퇴사일`) VALUES(%s, %s, %s, %s)", 
        $company['name'],
        $ARGS['user_id'],
        $company['start_day'],
        $company['end_day']
      );
      $DB->query($query);
    }
  }
  $return['success'] = 'successed';
}
?>