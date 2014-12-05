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

	function __construct()
	{
		global $current_user;
		$developerId = $current_user->user_id;
	}

	function get_period()
	{
		$DB = getDB();

		$query = "SELECT `평가회차` as period
			FROM `평가일정`
			WHERE now()>=`모집시작일`
				AND isnull(`종료일`)";
		$this->period = $DB->getValue($query);

		return $this->period;
	}

	function current_state()
	{
		$period = $this->get_period();

		$DB = getDB();
		$query = $DB->MakeQuery(
			"SELECT `평가회차` as period, `모집시작일` as reqdate, `평가시작일` as evalbegin, `종료일` as enddate
			FROM `평가일정`
			WHERE `평가회차`=%d",$period);

		$result = $DB->getRow($query);

		var_dump($period);
		var_dump($result);

		if(is_null($period)||is_null($result["reqdate"]))
			$case = "start";
		else if(is_null($result["evalbegin"]))
			$case = "recruiting";
		else if(is_null($result["enddate"]))
			$case = "evaling";
		else
			$case = "end";

		return $case;
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
				AND now()<=`종료일`");
		$this->period = $DB->getResult($query);

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

	function assginGroup()
	{
		$DB = getDB();
		//모집시작일 < 현재시각 이고, 평가시작일=NULL인 회차 구해서 그 tuple의 평가시작일을 현재시간으로 수정
		$query = $DB->MakeQuery("SELECT `평가회차` FROM `평가일정` WHERE (`일모집시작`<=%s) AND (`평가시작일` == NULL)",$time);
		$date = $DB->getResult($query);

		$DB->Update('평가일정',
		array('rate_date'=>$_POST['평가시작일']),
		array("%s"),
		array('평가회차'=>$date),
		array("%d"));
		$this->rate_date = NOW();

		//개발자id 로 GROUP BY 해서 개발자id LIST 를 받고 피평가자 신청에서 각 개발자마다 그룹 id를 1부터 부여
		$query = $DB->MakeQuery("SELECT `개발자id` FROM `피평가자 신청` WHERE `평가회차`=%s GROUP BY `개발자id`",$date);
		$evaluater = $DB->getResult($query);
		
		$count =1;
		foreach($evaluater as $result)
		{	
			$DB->Update('피평가자 신청',
				array('group'=>$_POST['평가그룹']),
				array("%s"),
				array('개발자id'=>$result),
				array("%d"));
			$this->group=$count;
			$count++;
		}
		//여기까지 피평가자 그루핑

		$query = $DB->MakeQuery("SELECT `개발자id` FROM `평가자료` ORDER BY `업로드시간` DESC");
		$evaluator = $DB->getResult($query);
		//업로드 순으로 개발자 뽑기
		$number =1;
		foreach($evaluator as $result)
		{
			if(($home != $result->hometown) && ($univ != $result->university)) {

				$home = $result->hometown;
				$univ = $result->university;
				$query = $DB->MakeQuery("INSERT INTO `평가자 그룹`(`평가회차`,`평가그룹`,`개발자id`) VALUES(%d,%d,%s)",$date,$number,$result);
				$number++;
			}
			if($number == $count) break;
		}
		//평가자 그루핑
	}

	function Mapping()
	{
		$DB = getDB();

		$time = NOW();
		$query = $DB->MakeQuery("SELECT `평가회차` FROM `평가일정` WHERE (`평가시작일`<=%s) AND (`종료일` == NULL)",$time);
		$date = $DB->getResult($query);
		//현재 평가회차

		$query = $DB->MakeQuery("SELECT * FROM `피평가자 신청` WHERE `평가회차`=%s GROUP BY `평가그룹` ", $date);
		$evaluater = $DB->getResult($query);
		//이번 평가회차에 신청한 피평가자 리스트

		$query = $DB->MakeQuery("SELECT * FROM `평가자 선정` WHERE `평가회차`=%s GROUP BY `평가그룹`",$date);
		$evaluator = $DB->getResult($query);

		//학연 지연이 다르면 매핑
		foreach($evaluator as $tor["개발자id"]) {
			foreach($evaluater as $ter["개발자id"]) {
				$tmp = USER::getUser($tor["개발자id"]); //평가자
				$tmp2 = USER::getUser($ter["개발자id"]); //피평가자

				if((tmp->university != tmp2->university) && (tmp->hometown != tmp2->hometown)) {

					$query = $DB->MakeQuery("SELECT `평가그룹` FROM `피평가자 신청` WHERE `개발자id`=%s GROUP BY `개발자id`",$ter["개발자id"]);
					$group = $DB->getResult($query);

					$query = $DB->MakeQuery("INSERT INTO `피평가자 그룹`(`평가회차`,`그룹id`,`평가자그룹`) VALUES(%d,%s,%s);",$date,$ter["평가그룹"],$tor["평가그룹"]);
				}
			}
		}

	}

}
?>