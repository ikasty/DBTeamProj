<?
header('Content-Type: application/json');
if (!defined("DBPROJ")) die(json_encode(-1));

$DB = getDB();

if ($ARGS['user_pw'] != $ARGS['user_pw_check']) {
  addMessage("비밀번호와 비밀번호 확인이 불일치합니다.");
  die(json_encode(-1));
}

$set_query = '';
if (isset($ARGS['user_name'])) {
  $set_query += "`이름`=`{$ARGS['user_name']}`,";
}
if (isset($ARGS['user_pw'])) {
  $set_query += "`비밀번호`=`{$ARGS['user_pw']}`,";
}
if ( $set_query ) {
  $set_query = rtrim($query, ",");
  $query = 
    "UPDATE `유저`
     SET ".$set_queery.
    "WHERE `id`=`{$ARGS['user_id']}`";
  $DB->query($query);
}


$set_query = '';
if (isset($ARGS['user_university'])) {
  $set_query += "`대학교`=`{$ARGS['user_university']}`,";
}
if (isset($ARGS['pw'])) {
  $set_query += "`고향`=`{$ARGS['user_hometown']}`,";
}
if ( $set_query ) {
  $set_query = rtrim($query, ",");
  $query = 
    "UPDATE `개발자`
     SET ".$set_queery.
    "WHERE `id`=`{$ARGS['user_id']}`";
  $DB->query($query);
}

if (isset($ARGS['user_speciality'])) {
  // major 배열화
  $major_list = explode(',', preg_replace('/\s+/', '', $ARGS['user_speciality']));

  $DB->query(
    "DELETE FROM `전문분야`
    WHERE `id`=`{$ARGS['user_id']}`"
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
    WHERE `개발자id`=`{$ARGS['user_id']}`"
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
?>