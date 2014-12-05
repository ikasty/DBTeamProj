<?
/*

	2014-2 YONSEI University Computer Science Dept.
	Database Class - qwer1234!@ group project

	first written : 2014.11.22
	last written : 2014.11.23
	owner : einsfer@github
	last modifier : einfer

	description :  1. Define evaluation class
				   2. Define function about evaluation
				   2-1 : Now connecting developer is evaluator? or recipient?
				   2-2 : insert evaluation data into database table.

*/
class evaluation{
	private $id;					// eval id @평가
	private $dataId;				// data id @평가하기 from @평가자료
	private $developerId;			// developer id @개발자
	private $evalDate;				// evaldate @평가하기
	private $indicator;				// eval indicator @평가지표
	private $point;					// eval point @평가지표
	private $period;				// period 평가회차 @평가자 그룹, @피평가자 그룹

//	private $evalGroup;				// eval Group

	global $current_user;
	function __construct()
	{
		$developerId = $current_user->user_id;
	}

/*	function setEvalId()
	{

		$DB = getDB();

		$query = $DB->select(
		"평가",						// table
		array("max(평가id)"))		// field
		
		$id = $DB->getValue($query) + 1;

	}
*/

	function indicateUser($developerId)
	{

		$DB = getDB();

		// 현재 진행중인 회차의 평가 일정의 회차를 확인한다.
		$query = $DB->MakeQuery(
			"SELECT `평가회차`
			FROM `평가일정`
			WHERE now()>=`시작일`
				AND now()<=`종료일`")
		$period = $DB->getResult($query);

		// 현재 접속중인 개발자가 현재 회차의 평가자 / 피평가자 그룹의 목록에 해당하는지 확인한다.
		$query = $DB->MakeQuery(
			"SELECT ifnull ( 1 , 0 )
			FROM `평가자 선정`
			WHERE `평가회차`=%s
				AND `개발자id` = %s",
			$period, $developerId);
		$result1 = $DB->getResult($query);

		$query = $DB->MakeQuery(
			"SELECT ifnull ( 2 , 0 )
			FROM `피평가자 선정`
			WHERE `평가회차`=%s
				AND `개발자id` = %s",
			$period, $developerId);
		$result2 = $DB->getResult($query);

		// 평가/피평가에 참여하는 여부를 검사한다
		$result = $result1 + $result2;

		switch ($result) {
			case 1:
				return "평가자";
				break;
			case 2:
				return "피평가자";
				break;
			case 3:
				return "평가자 & 피평가자";
				break;
			default:		// $result == 0;
				return "평가에 참여하지 않는다";
				break;
		}
	}

	function insertEvaluation($id, $dataId, $developerId, $indicator, $point)
	{

		$DB = $getDB();

		// 평가하기, 평가지표 에 입력 할 평가id
		// 만약 입력된 id가 null 이라면 새로운 평가id를 부여
		if(is_null($id))
		{
			$query = $DB->MakeQuery(
				"SELECT max(`평가id`)
				FROM `평가`");
			$result = $DB->getResult($query);

			$id = $result + 1;

			$query =$DB->MakeQuery(
				"INSERT INTO `평가`
				SET `평가id`=%d", $id
			);
		}

		// 평가하기에 data 입력
		$query = $DB->MakeQuery(
			"INSERT INTO `평가하기`
			(`평가id`, `자료id`, `개발자id`, `평가날짜`)
			VALUES(%d,%d,%d,now())
			",$id,$dataId,$developerId);

		$result = $DB->getResult($query);

		// 평가지표에 data 입력
		$query = $DB->MakeQuery(
			"INSERT INTO `평가지표`
			(`평가id`, `지표이름`, `점수`)
			VALUES(%d,%s,%d)
			",$id,$indicator,$point);

		$result = $DB->getResult($query);

	}

}


?>