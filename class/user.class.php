

<?php
class user
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
	private $privilege = 0; //default = 0(developer) <--> 1(admin)
	private $auth = ""; 

	function __constructor($user_id)
	{
		global $DB;
		
		if($user_id !== "") {
			$query = $DB->MakeQuery("SELECT * From user where user_id=%s", $user_id);
			$user_info = $DB->getRow($query);
			$this->user_id = $user_info["user_id"];
			$this->password = ($user_info["password"]);
			$this->name = $user_info["name"];
			$this->privilege = intval($user_info["privilege"]);

		//권한 구하기 - 어디에 사용하는지 모르겠음
		$query = $DB->MakeQuery("SELECT value FROM user_var WHERE user_id=%d AND user_var.key='auth'", $this->id);
			$this->auth = $DB->getColumn($query);
		} else {
			$this->auth = array("no_user");
		}
	}

}


class developer extends user 
{
	public $developer_id = "";
	public $major = "";
	public $university = "";
	public $hometown = "";

	function __constructor($user_id)
	{
		global $DB;
		
		if($user_id !== "") {

			$query = $DB->MakeQuery("SELECT * From developer where user_id=%s", $user_id);
			$developer_info = $DB->getRow($query);

			$this->developer_id = $developer_info["developer_id"];
			$this->major = $developer_info["major"];
			$this->university = $developer_info["university"];
			$this->hometown = $developer_info["hometown"];
		}

	function login($user_id, $password)
	{
		global $DB, $core, $current_user;
		$query = $DB->MakeQuery("SELECT * From user where user_id=%s", $user_id);
		$user_info = $DB->getRow($query);

		if($user_info["password"] == md5($password))
		{
			
			$this->user_id = $user_info["user_id"];
			$this->name = $user_info["name"];

			$query = $DB->MakeQuery("SELECT * From developer where user_id=%s", $user_id);
			$developer_info = $DB->getRow($query);

			$this->developer_id = $developer_info["developer_id"];
			$this->major = $developer_info["major"];
			$this->university = $developer_info["university"];
			$this->hometown = $developer_info["hometown"];
			$_SESSION["session_user"] = serialize($this);
			$_SESSION["login_time"] = time();
			
			//권한 구하기
			$query = $DB->MakeQuery("SELECT value FROM user_var WHERE user_id=%d AND user_var.key='auth'", $this->id);
			$this->auth = $DB->getColumn($query);
			return true;
		}
		else
			return false;
	}

	//로그인 타임 체크
	function __wakeup() {
		if (isset($_SESSION["login_time"]) && (time() - $_SESSION["login_time"]) > 900) {
			$this->logout();
		}
		else
			$_SESSION["login_time"] = time();
	}

	function logout()
	{
		global $current_user;
		$current_user = new user("");
		unset($_SESSION["session_user"]);
		unset($_SESSION["login_time"]);
	}
	function ismail( $str ) 
	{
		if( eregi("([a-z0-9\_\-\.]+)@([a-z0-9\_\-\.]+)", $str) ) return true;
		else return false; 
	}

	function isLogin()
	{
		return isset($_SESSION["session_user"]);
	}


}

class administrator extends developer
{
	private $admin_id = 0;

	function __constructor($user_id)
	{
		global $DB;
		
		if($user_id !== "") {
			
			if($this->privilege == 1) //admin 일 때
			{

				$query = $DB->MakeQuery("SELECT * From amin where user_id=%s", $user_id);
				$admin_info = $DB->getRow($query);

				$this->admin_id = intval($admin_info["admin_id"]);
			}
		}
	}

	function admin_login($user_id, $password)
	{
		global $DB, $core, $current_user;
		$query = $DB->MakeQuery("SELECT * From user where user_id=%s", $user_id);
		$user_info = $DB->getRow($query);

		if($user_info["password"] == md5($password))
		{
			if($this->privilege == 1) //admin 일 때
			{
			
				$this->user_id = $user_info["user_id"];
				$this->name = $user_info["name"];

				$query = $DB->MakeQuery("SELECT * From developer where user_id=%s", $user_id);
				$developer_info = $DB->getRow($query);

				$this->developer_id = $developer_info["developer_id"];
				$this->major = $developer_info["major"];
				$this->university = $developer_info["university"];
				$this->hometown = $developer_info["hometown"];

				$query = $DB->MakeQuery("SELECT * From admin where user_id=%s", $user_id);
				$admin_info = $DB->getRow($query);

				$this->admin_id = $admin_info["admin_id"];
				$_SESSION["session_user"] = serialize($this);
				$_SESSION["login_time"] = time();
			}
			else 
			{
				return false;
			}
			
			//권한 구하기
			$query = $DB->MakeQuery("SELECT value FROM user_var WHERE user_id=%d AND user_var.key='auth'", $this->id);
			$this->auth = $DB->getColumn($query);
			return true;
		}
		else
			return false;
	}



}


 
?>