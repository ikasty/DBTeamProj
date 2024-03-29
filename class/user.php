<?php
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

//TODO: 클래스를 굳이 나누긴 했는데, 관리자 정보를 db에 따로 저장하지 않으니깐 그냥 하나의 클래스로 합쳐야할듯 (by 대연)
class User
{
	public $user_type = "user";

	public $user_id = "";
	private $password = "";
	public $user_name = "";

	public $developer_id = "";
	public $university = "";
	public $hometown = "";

	// major는 일반 배열 형태로 이루어져 있음
	public $major = "";

	/*company는 array(
		array(
			name => !@#$,
			start_day => YYYY-MM-DD,
			end_day => YYYY-MM-DD
		), 
		array (...
		),
		...
	)의 형태로 구성됨 */
	public $company = "";
	// 유저 정보에 부서 정보는 더 이상 포함되지 않음 
	// public $department_id = "";

	public $file_list = array();

	//유저 아이디를 통하여 디비에서 정보를 불러와 신생 객체를 채움
	protected function __construct($user_id)
	{
		$DB = getDB();
		
		if($user_id !== "") {
			$query = $DB->MakeQuery("SELECT * From `유저` where `id`=%s", $user_id);
			$user_info = $DB->getRow($query);

			$this->user_id = $user_info["id"];
			$this->password = ($user_info["비밀번호"]);
			$this->user_name = $user_info["이름"];

			$query = $DB->MakeQuery("SELECT * From `개발자` where `id`=%s", $user_id);
			$developer_info = $DB->getRow($query);
			if (!$developer_info) {
				$this->user_type = "admin";
				return ;
			}
			
			$this->developer_id = $developer_info["id"];
			$this->university = $developer_info["대학교"];
			$this->hometown = $developer_info["고향"];

			$query = $DB->MakeQuery(
				"SELECT `전문분야` 
				From `전문분야` 
				where `id`=%s AND `수정시간`=(
					SELECT MAX(`수정시간`)
					FROM `전문분야`
					WHERE `id`=%s
				)" ,$user_id, $user_id
			);
			$major_info = $DB->getColumn($query);
			$this->major = $major_info;

			$query = $DB->MakeQuery(
				"SELECT `회사이름` as `name`, `입사일` as `start_day`, `퇴사일` as `end_day` 
				From `근무` 
				where `개발자id`=%s ORDER BY `입사일`", $this->developer_id
			);
			$work_on_info = $DB->getResult($query);
			$this->company = $work_on_info;
			
			// 유저 정보에 부서 정보는 더 이상 포함되지 않음
			/*$query = $DB->MakeQuery("SELECT * From `부서` where `회사이름`=%s", $this->company);
			$department_info = $DB->getRow($query);
			$this->company = $department_info["부서id"];*/

			//다중속성
			$query = $DB->MakeQuery("SELECT `평가자료` From `평가자료` where `개발자id`=%s", $this->developer_id);
			$file_list = $DB->getColumn($query);
			
		}
	}

	// 이제 user를 구할 때는 $user = User::getUser($id); 처럼 한다
	public static function getUser($user_id)
	{
		// User 생성자에서 DB참조하여 정보를 채움
		$temp = new User($user_id);
		return $temp;		
	}

	public function is_logged_in() {
		return $this->user_id !== "";
	}

	public function login($password)
	{
		if($this->password == $password)
		{
			global $current_user;
			$current_user = $this;

			$_SESSION["id"] = serialize($this);
			$_SESSION["login_time"] = time();
			
			return true;
		}
		else
		{
			return false;
		}
	}

	public function logout()
	{
		global $current_user;
		// 가짜 유저를 넣음
		$current_user = User::getUser("");

		unset($_SESSION["id"]);
		unset($_SESSION["login_time"]);
	}

	//로그인 타임 체크
	function __wakeup() {
		if (isset($_SESSION["login_time"]) && (time() - $_SESSION["login_time"]) > AUTO_LOGOUT_TIME) {
			$this->logout();
		}
		else
			$_SESSION["login_time"] = time();
	}

	public function usertype() {
		return $this->user_type;
	}

	public function is_admin()	{
		return $this->usertype() == "admin";
	}

	public static function ismail( $str ) 
	{
		if( eregi("([a-z0-9\_\-\.]+)@([a-z0-9\_\-\.]+)", $str) ) return true;
		else return false; 
	}

	function update()
	{
		global $DB;
		//유저, 개발자, 전문분야, 근무, 부서 table값 전부 업데이트
		$DB->Update('유저',
		array('user_id'=>$_POST["id"],
			'password'=>md5($_POST["비밀번호"]),
			'user_name'=>$_POST["이름"]),
		array("%s", "%s", "%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->user_id = $_POST["id"];
		$this->password = $_POST["비밀번호"];
		$this->user_name = $_POST["이름"];

		$DB->Update('개발자',
		array('developer_id'=>$_POST["id"],
			'university'=>$_POST["대학교"],
			'hometown'=>$_POST["고향"]),
		array("%s", "%s", "%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->developer_id = $_POST["id"];
		$this->university = $_POST["비밀번호"];
		$this->hometown = $_POST["이름"];

		$DB->Update('전문분야',
		array('major'=>$_POST["전문분야"]),
		array("%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->major = $_POST["전문분야"];

		$DB->Update('근무',
		array('company'=>$_POST["회사이름"]),
		array("%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->company = $_POST["회사이름"];

		$DB->Update('부서',
		array('department_id'=>$_POST["부서id"]),
		array("%s"),
		array('id'=>$this->id),
		array("%d"));

		$this->department_id = $_POST["부서id"];
		
		$_SESSION["session_user"] = serialize($this);
	}

	static function check_count() // 현재시간이 평가회차 시간에 유효한지
	{
		$year = data("Y");
		$month = data("M");
		$day = data("D");
		$start_data = "2014-08-15"; 
		$end_data = "2014-08-30";//예시

		if($year > substr($start_data,0,4) && $year < substr($end_date,0,4) ) {
			if($month > substr($start_data,5,2) && $month < substr($end_data,5,2)) {
				if($day > substr($start_data,8,2) && $day < substr($end_data,8,2)) {
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}


	function Demand_Evaluate($file_id)
	{
		global $DB;

		if(strpos($this->file_list,$file_id) == true && check_count() == true)
		{
			//해당 파일 신청
		}
		else
		{
			return false;
			//시간 혹은 파일 오류
		}

	}
	//평가라고 하기 부족함 ** 삭제요망 **
	/*
	function Evalate($file_id)
	{
		global $DB;

		$query = $DB->MakeQuery("SELECT * From 평가자 선정 where 개발자id=%s", $this->developer_id);
		$group_info = $DB->getRow($query);

		$Count = $group_info["평가회차"];
		$Egroup_id = $group_info["평가그룹"];

		$query = $DB->MakeQuery("SELECT 그룹id From 피평가자 그룹 where 평가회차id=%s AND 평가자그룹=%s", $Count, $Egroup_id);
		$Dgroup_id = $DB->getRow($query); //피평가자 그룹 id 

		$query = $DB->MakeQuery("SELECT 개발자id From 피평가자 신청 where 평가회차id=%s AND 평가그룹=%s", $Count, $Dgroup_id);
		$D_list[] = $DB->getColumn($query); //매핑된 피평가자 그룹의 개발자 목록

		$i=0;
		while(i < count($D_list)) {
			$query = $DB->MakeQuery("SELECT 자료id From 평가자료 where 개발자id=%s", $D_list[$i++]);
			$DFile_list[] = $DB->getColumn($query);

			if(strpos($DFile_list,$file_id) == true) {
				//평가 
			}
			else {
				return false;
			}
		}
	}
*/
	function StartEvaluate()
	{

	}

}

if (isset($_SESSION["id"])){
	$current_user = unserialize($_SESSION["id"]);
}
else
	$current_user = User::getUser("");
?>