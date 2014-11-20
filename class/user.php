<?php
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

//TODO: 클래스를 굳이 나누긴 했는데, 관리자 정보를 db에 따로 저장하지 않으니깐 그냥 하나의 클래스로 합쳐야할듯 (by 대연)
class User
{
	
	public $user_id = "";
	private $password = "";
	public $user_name = "";
	//public $sex = "";
	//public $address = "";
	//public $address_ = "";
	//public $phone = "";
	//public $email = "";
	//public $birth = "";
	private $privilege = -1; //default = 0(developer) <--> 1(admin)
	private $auth = ""; 

	protected function __construct($user_id)
	{
		$DB = getDB();
		
		if($user_id !== "") {
			$query = $DB->MakeQuery("SELECT * From 유저 where id=%s", $user_id);
			$user_info = $DB->getRow($query);

			$this->user_id = $user_info["id"];
			$this->password = ($user_info["비밀번호"]);
			$this->name = $user_info["이름"];
			$this->privilege = 0;	//TODO: 이거 db에서 가져올 수 있도록 수정할 것 by 대연
		}
	}

	// 이제 user를 구할 때는 $user = User::getUser($id); 처럼 한다
	public static function getUser($user_id)
	{
		$temp = new User($user_id);
		if ($user_id === "") return $temp;

		if ($temp->privilege == 0)
		{
			return new Developer($user_id);
		}
		else if ($temp->privilege == 1)
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
}

class Developer extends User 
{
	public $developer_id = "";
	public $major = "";
	public $university = "";
	public $hometown = "";

	function __construct($user_id)
	{
		$DB = getDB();

		parent::__construct($user_id);
		
		if($user_id !== "") {

			$query = $DB->MakeQuery("SELECT * From 개발자 where 유저id=%s", $user_id);
			$developer_info = $DB->getRow($query);

			$this->developer_id = $developer_info["id"];
			//$this->major = $developer_info["major"];
			$this->university = $developer_info["대학교"];
			$this->hometown = $developer_info["고향"];
		}
	}
}

class Administrator extends User
{
	function __construct($user_id)
	{
		parent::__construct($user_id);
		
		if($user_id !== "" && $this->privilege == 1)
		{
			// 딱히 할 일이 없음
		}
	}
}
?>