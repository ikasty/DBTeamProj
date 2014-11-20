<?php
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

	private function __constructor($user_id)
	{
		global $DB;
		
		if($user_id !== "") {
			$query = $DB->MakeQuery("SELECT * From user where user_id=%s", $user_id);
			$user_info = $DB->getRow($query);

			$this->user_id = $user_info["user_id"];
			$this->password = ($user_info["password"]);
			$this->name = $user_info["name"];
			$this->privilege = intval($user_info["privilege"]);
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

	function __constructor($user_id)
	{
		global $DB;

		parent::__constructor($user_id);
		
		if($user_id !== "") {

			$query = $DB->MakeQuery("SELECT * From developer where user_id=%s", $user_id);
			$developer_info = $DB->getRow($query);

			$this->developer_id = $developer_info["developer_id"];
			$this->major = $developer_info["major"];
			$this->university = $developer_info["university"];
			$this->hometown = $developer_info["hometown"];
		}
	}
}

class Administrator extends User
{
	private $admin_id = 0;

	function __constructor($user_id)
	{
		global $DB;

		parent::__constructor($user_id);
		
		if($user_id !== "" && $this->privilege == 1)
		{
			$query = $DB->MakeQuery("SELECT * From admin where user_id=%s", $user_id);
			$admin_info = $DB->getRow($query);

			$this->admin_id = intval($admin_info["admin_id"]);
		}
	}
}


 
?>