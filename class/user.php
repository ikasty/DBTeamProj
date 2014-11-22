<?php
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

//TODO: 클래스를 굳이 나누긴 했는데, 관리자 정보를 db에 따로 저장하지 않으니깐 그냥 하나의 클래스로 합쳐야할듯 (by 대연)
class User
{
	
	public $user_id = "";
	private $password = "";
	public $user_name = "";

	public $developer_id = "";
	public $university = "";
	public $hometown = "";

	public $major = "";

	public $company = "";
	public $department_id = "";

	protected function __construct($user_id)
	{
		$DB = getDB();
		
		if($user_id !== "") {
			$query = $DB->MakeQuery("SELECT * From 유저 where id=%s", $user_id);
			$user_info = $DB->getRow($query);

			$this->user_id = $user_info["id"];
			$this->password = ($user_info["비밀번호"]);
			$this->name = $user_info["이름"];

			$query = $DB->MakeQuery("SELECT * From 개발자 where 유저id=%s", $user_id);
			$developer_info = $DB->getRow($query);

			$this->developer_id = $developer_info["id"];
			$this->university = $developer_info["대학교"];
			$this->hometown = $developer_info["고향"];

			$query = $DB->MakeQuery("SELECT * From 전문분야 where id=%s", $user_id);
			$major_info = $DB->getRow($query);

			$this->major = $major_info["전문분야"];

			$query = $DB->MakeQuery("SELECT * From 근무 where id=%s", $developer_id);
			$work_on_info = $DB->getRow($query);

			$this->company = $major_info["회사이름"];

			$query = $DB->MakeQuery("SELECT * From 부서 where 회사이름=%s", $company);
			$department_info = $DB->getRow($query);

			$this->company = $department_info["부서id"];
		}
	}

	// 이제 user를 구할 때는 $user = User::getUser($id); 처럼 한다
	public static function getUser($user_id)
	{
		$temp = new User($user_id);
		if ($user_id === "") return $temp;

		$query = $DB->MakeQuery("SELECT * From 개발자 where id=%s", $user_id);
		$developer_info = $DB->getRow($query);


		if ($developer_info["id"] != "")
		{
			return new Developer($user_id);
		}
		else
		{
			return new Administrator($user_id);
		}
	}

	public function login($password)
	{
		// 처음부터 md5로 변환된 패스워드가 넘어옴
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
		$current_user = getUser("");

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
		return get_class($this);
	}

	public static function ismail( $str ) 
	{
		if( eregi("([a-z0-9\_\-\.]+)@([a-z0-9\_\-\.]+)", $str) ) return true;
		else return false; 
	}

	function is_admin($user_id)
	{
		global $DB;
		$temp = new User($user_id);
		if ($user_id === "") return flase;
		
		$query = $DB->MakeQuery("SELECT * From 개발자 where id=%s", $user_id);
		$developer_info = $DB->getRow($query);


		if ($developer_info["id"] != "") //개발자 ID 로 관리자 체크
		{
			return flase;
		}
		else
		{
			return true;
		}
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
			'university'=>md5($_POST["대학교"]),
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

	function Demand_Evaluate($file_id)
	{
		global $DB;

		$query = $DB->MakeQuery("SELECT * From 평가자료 where 개발자id=%s", $this->developer_id);
		$Evaluate_info = $DB->getRow($query);

		if(strpos($Evaluate_info["자료id"],$file_id) == true)
		{
			//신청 기간인 경우 해당 파일 평가등록 수행
		}
		else
		{
			//개발자가 해당 파일을 갖고 있지 않음
		}

	}

	function Evalate()
	{

	}

	function File_Upload()
	{

	}

	function Serach()
	{

	}

	function mapping()
	{

	}

	function admin_search()
	{

	}

	function admin_update()
	{

	}

	function StartEvaluate()
	{

	}

}
?>