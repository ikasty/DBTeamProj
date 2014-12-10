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
		$query = $DB->MakeQuery("SELECT `개발자id` FROM `피평가자 신청` WHERE `평가회차`=%s GROUP BY `개발자id`",$period);
		$evaluater = $DB->getResult($query);
		$count = count($evaluater); // 신청한 피 평가자 수
		$number=1; // 피평가자 그룹 번호 

		for($i=0 ; $i<$count ; $i++)
		{
			$query = $DB->MakeQuery("INSERT INTO `피평가자 그룹`(`평가회차id`,`그룹id`,`평가자그룹`) VALUES(%d,%d,0)",$period,$i+1);
			var_dump($query);
			$DB->query($query);	
		}

		for($i=0 ; $i<$count ; $i++)
		{
			$query = $DB->MakeQuery("SELECT * FROM `피평가자 신청` WHERE `평가회차`=%d AND `개발자id` = %s GROUP BY `개발자id`",$period,$evaluater[$i]["개발자id"]);
			$check = $DB->getRow($query);
			if($check["평가그룹"] != 0)
			{
				continue;
			} 

			$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluater[$i]["개발자id"]);
			$er_profile = $DB->getRow($query); //이전 개발자의 프로필 
			for($j=$i ; $j<$count ; $j++)
			{
				$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluater[$j]["개발자id"]);
				$curr_profile = $DB->getRow($query); //현재 개발자의 프로필
				//var_dump("현재 개발자",$query);
				if( ($er_profile["고향"]==$curr_profile["고향"]) && ($er_profile["대학교"]==$curr_profile["대학교"]) ) // 현재 피평가자 가 이전 profile 과 일치하면 같은 그룹에 배치
				{
					$query = $DB->MakeQuery(
					"UPDATE `피평가자 신청` SET `평가그룹` = %d WHERE `개발자id` = %s",$number,$evaluater[$j]["개발자id"] );
					$DB->query($query);	
				}
			}
			$number++;
		}
		//여기까지 피평가자 그루핑
		//$number-1 이 결국 최종 그룹 수

		$query = $DB->MakeQuery("SELECT `개발자id` FROM `평가자 선정` WHERE `평가회차`=%s",$period);
		$evaluator = $DB->getResult($query);
		$count2 = count($evaluator); // 신청한 평가자 수
		$number2=1; // 평가자 그룹 번호 

		for($i=0 ; $i<$count2 ; $i++)
		{
			$query = $DB->MakeQuery("INSERT INTO `평가자 그룹`(`평가회차id`,`그룹id`) VALUES(%d,%d)",$period,$i+1);
			$DB->query($query);	
		}

		for($i=0 ; $i<$count2 ; $i++)
		{
			$query = $DB->MakeQuery("SELECT * FROM `평가자 선정` WHERE `평가회차`=%d AND `개발자id` = %s GROUP BY `개발자id`",$period,$evaluator[$i]["개발자id"]);
			$check = $DB->getRow($query);
			if($check["평가그룹"] != 0)
			{
				continue;
			} 

			$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluator[$i]["개발자id"]);
			$or_profile = $DB->getRow($query); //이전 개발자의 프로필 

			for($j=$i ; $j<$count2 ; $j++)
			{
				$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluator[$j]["개발자id"]);
				$curr_profile = $DB->getRow($query); //현재 개발자의 프로필
			
				if( ($or_profile["고향"]==$curr_profile["고향"]) && ($or_profile["대학교"]==$curr_profile["대학교"]) ) // 현재 피평가자 가 이전 profile 과 일치하면 같은 그룹에 배치
				{
					$query = $DB->MakeQuery(
					"UPDATE `평가자 선정` SET `평가그룹` = %d WHERE `개발자id` = %s",$number2,$evaluator[$j]["개발자id"] );
					$DB->query($query);	
				}
			}
			$number2++;
		}
	}

	function Mapping($period)
	{
		$DB = getDB();
		$query = $DB->MakeQuery("SELECT * FROM `피평가자 신청` WHERE `평가회차`=%s ORDER BY `평가그룹` ASC", $period);
		$evaluater = $DB->getResult($query);
		$no1 = count($evaluater);


		$query = $DB->MakeQuery("SELECT * FROM `평가자 선정` WHERE `평가회차` = %s ORDER BY `평가그룹` ASC",$period);
		$evaluator = $DB->getResult($query);
		$no2 = count($evaluator);

		$curr1 = 0;
		$curr2 = 0;
		$loop_cnt = 0;
		while($no1 > $curr1) //curr1 피평가자 인덱스가 끝까지 도착할때까지 반복
		{
			$er_id = $evaluater[$curr1]["개발자id"];
			$er_group = $evaluater[$curr1]["평가그룹"];
			$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$er_id); //피평가자의 고향, 대학교
			$ter = $DB->getRow($query); 

			$or_id = $evaluator[$curr2]["개발자id"];
			$or_group = $evaluator[$curr2]["평가그룹"];
			$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$or_id); //피평가자의 고향, 대학교
			$tor = $DB->getRow($query);

			if(($ter["고향"] != $tor["고향"]) && ($ter["대학교"] != $tor["대학교"]))
			{
				$query = $DB->MakeQuery("INSERT INTO `피평가자 그룹`(`평가회차id`,`그룹id`,`평가자그룹`) VALUES(%d,%d,%d)",$period,$er_group,$or_group);
				$DB->query($query);	
				$curr1++;

				$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluater[$curr1]["개발자id"]); //피평가자의 고향, 대학교
				$check = $DB->getRow($query);
				while($check["평가그룹"] == $er_group) //다음 피평가자와 지금 피평가자 그룹이 같음. 계쏙 스킵
				{
					$curr1++;
					$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluater[$curr1]["개발자id"]); //피평가자의 고향, 대학교
					$check = $DB->getRow($query);
				}
			} //매핑 성공 삽입 후에 다음 피평가자 이동
			else
			{
				$curr2++; 
				
				$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluator[$curr2]["개발자id"]); //평가자의 고향, 대학교
				$check = $DB->getRow($query);
				while($check["평가그룹" == $or_group]) //다음 평가자와 그룹이 같음 계속 스킵
				{
					$curr2++;
					$query = $DB->MakeQuery("SELECT * FROM `개발자` WHERE id = %s",$evaluator[$curr2]["개발자id"]); //평가자의 고향, 대학교
					$check = $DB->getRow($query);
					if($no2 == $curr2) break;
				}

			} //매핑실패 다음 평가자 이동 
			if($no2 == $curr2) $curr2 = 0; //평가자 리스트 끝에 도달 하면 평가자 위치 다시 0으로
			if($loop_cnt++ >100) break; // 100번 돌면 무한루프로 간주하고  탈출 : 이경우는 피평가자 그룹은 많은데 평가자 그룹수가 적어지는 경우 발생한다
		}
	}

}
?>