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
	
	function assginGroup($period)
	{
		$DB = getDB();
		//var_dump("assignGroup", $period);
		//개발자id 로 GROUP BY 해서 개발자id LIST 를 받고 피평가자 신청에서 각 개발자마다 그룹 id를 1부터 부여
		$query = $DB->MakeQuery("SELECT `개발자id` FROM `피평가자 신청` WHERE `평가회차`=%s GROUP BY `개발자id`",$period);
		$evaluater = $DB->getResult($query);
		
		$count =0;
		foreach($evaluater as $result)
		{	
			$count++;
			$query = $DB->MakeQuery(
			"UPDATE `피평가자 신청` SET `평가그룹` = %d WHERE `개발자id` = %s",$count, $result["개발자id"]);
			$DB->query($query);			
		}
		//여기까지 피평가자 그루핑
		
		$query = "SELECT `개발자id` FROM `평가자료` GROUP BY `개발자id` ORDER BY `업로드시간` DESC";
		$evaluator = $DB->getResult($query);
		//업로드 순으로 개발자 뽑기
		$number =0;
		foreach($evaluator as $result)
		{
			//var_dump($result["개발자id"]);
			$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$result["개발자id"]);
			//var_dump($query);
			$info = $DB->getRow($query);
			//var_dump($info);
			//var_dump($info["고향"],$info["대학교"]);
			if(($home != $info["고향"]) && ($univ != $info["대학교"])) {
				$number++;
				$home = $info["고향"];
				$univ = $info["대학교"];
				$query = $DB->MakeQuery("INSERT INTO `평가자 선정`(`평가회차`,`평가그룹`,`개발자id`) VALUES(%d,%d,%s)",$period,$number,$result["개발자id"]);
				$DB->query($query);				
			}
			if($number == $count) break;
		}
		//평가자 그루핑
	}

	function Mapping($period)
	{
		$DB = getDB();
		//var_dump("Mapping", $period);
		$query = $DB->MakeQuery("SELECT * FROM `피평가자 신청` WHERE `평가회차`=%s GROUP BY `개발자id` ", $period);
		$evaluater = $DB->getResult($query);
		$count= count($evaluater);
		
		//이번 평가회차에 신청한 피평가자 리스트
		//var_dump($evaluater);
		//var_dump("=====");	
		$query = $DB->MakeQuery("SELECT * FROM `평가자 선정` WHERE `평가회차`=%s GROUP BY `개발자id`",$period);
		$evaluator = $DB->getResult($query);
		//var_dump($evaluator);
		//학연 지연이 다르면 매핑
		$current = 0;
		$curr=0;
		while($count >= $current)
		{	
			$er_id = $evaluater[$current]["개발자id"];
			$er_group = $evaluater[$current]["평가그룹"];
			$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$er_id); //피평가자의 고향, 대학교
			$ter = $DB->getRow($query);

			$or_id = $evaluater[$curr]["개발자id"];
			$or_group = $evaluater[$curr]["평가그룹"];
			$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$er_id); //평가자의 고향, 대학교
			$tor = $DB->getRow($query);

			if(($ter["고향"] != $tor["고향"]) && ($ter["대학교"] != $tor["대학교"]))
			{
				$query = $DB->MakeQuery("INSERT INTO `피평가자 그룹`(`평가회차`,`그룹id`,`평가자그룹`) VALUES(%d,%d,%d)",$period,$er_group,$or_group);
				$DB->query($query);	
				$current++;
			}else {
			$curr++;
			}
			if($count >= $current) $curr=0;
		}
		/*count = 피평가자 수,  current = 현재 피평가자 번호, curr = 현재 평가자 번호
		피평가자0번 부터 평가자와 비교하고 만약 학연,지연이 겹치면 평가자 번호 ++ , 만족하면 피평가자 번호 ++
		그리고 돌때마다, 현재 피평가자 번호 < 피평가자 수 면 전부 다 매핑이 안됬으므로 while 반복
		*/
	}

}
?>