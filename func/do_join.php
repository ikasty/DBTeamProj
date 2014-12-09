<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$DB = getDB();
//폼 유효성을 관리하는 변수
$validate = true;

if ($ARGS['user_pw'] == "") {
  addMessage("비밀번호를 입력해 주세요");
  $return['success'] = 'failed';
  $validate = false;
}
if ($ARGS['user_pw'] != $ARGS['user_pw_check']) {
  addMessage("비밀번호와 비밀번호 확인이 불일치합니다.");
  $return['success'] = 'failed';
  $validate = false;
}
if (!$ARGS['flag_check_user_id_duple']) {
  addMessage("아이디 중복 확인을 해주세요");
  $return['success'] = 'failed';
  $validate = false;
}
if ($validate) {
  // major 배열화
  $raw_major_list = explode(',', $ARGS['user_speciality']);
  $major_list = array();
  foreach ($raw_major_list as $raw_major) {
    $major = preg_replace('/\s+/', '', $raw_major);
    if ($major) {
      $major_list[] = $major;
    }
  }

  $query = $DB->MakeQuery("INSERT INTO `유저`(`id`, `비밀번호`, `이름`) VALUES(%s, %s, %s)", 
    $ARGS['user_id'],
    $ARGS['user_pw'],
    $ARGS['user_name']
  );
  $DB->query($query);

  $query = $DB->MakeQuery("INSERT INTO `개발자`(`id`, `대학교`, `고향`, `유저id`) VALUES(%s, %s, %s, %s)", 
    $ARGS['user_id'],
    $ARGS['user_university'],
    $ARGS['user_hometown'],
    $ARGS['user_id']
  );
  $DB->query($query);

  foreach($major_list as $major) {
    $query = $DB->MakeQuery("INSERT INTO `전문분야`(`id`, `전문분야`) VALUES(%s, %s)", 
      $ARGS['user_id'],
      $major
    );
    $DB->query($query);
  }

  foreach($ARGS['company_list'] as $company) {
    $query = $DB->MakeQuery("INSERT INTO `근무`(`회사이름`, `개발자id`, `입사일`, `퇴사일`) VALUES(%s, %s, %s, %s)", 
      $company['name'],
      $ARGS['user_id'],
      $company['start_day'],
      $company['end_day']
    );
    $DB->query($query);
  }

  $return['success'] = 'successed';
}
?>