<?php
/** user 클래스 : 양민영
*/

// 이번 과제에서는 아래 체크를 해야함 by 대연
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

class user
{
	public $name = "";
	public $id = 0;
	public $user_id = "";
	public $sex = "";
	public $address = "";
	public $address_ = "";
	public $phone = "";
	public $email = "";
	public $birth = "";
	private $auth = "";

	function user($user_id)
	{
		global $DB;
		
		if($user_id !== "") {
			$query = $DB->MakeQuery("SELECT * From user where user_id=%s", $user_id);
			$user_info = $DB->getRow($query);

			$this->name = $user_info["name"];
			$this->id = intval($user_info["id"]);
			$this->user_id = $user_info["user_id"];
			$this->sex = $user_info["sex"];
			$this->address = $user_info["address"];
			$this->address_ = $user_info["address_"];
			$this->phone = $user_info["phone"];
			$this->email = $user_info["email"];
			$this->birth = $user_info["birth"];

			//권한 구하기
			$query = $DB->MakeQuery("SELECT value FROM user_var WHERE user_id=%d AND user_var.key='auth'", $this->id);
			$this->auth = $DB->getColumn($query);
		} else {
			$this->auth = array("no_user");
		}
	}

	function login($user_id, $password)
	{
		global $DB, $core, $current_user;
		$query = $DB->MakeQuery("SELECT * From user where user_id=%s", $user_id);
		$user_info = $DB->getRow($query);
		if($user_info["password"] == md5($password))
		{
			
			$this->name = $user_info["name"];
			$this->id = $user_info["id"];
			$this->user_id = $user_info["user_id"];
			$this->sex = $user_info["sex"];
			$this->address = $user_info["address"];
			$this->address_ = $user_info["address_"];
			$this->phone = $user_info["phone"];
			$this->email = $user_info["email"];
			$this->birth = $user_info["birth"];;
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

	function joinus()
	{
		global $DB;
		$query = $DB->MakeQuery("SELECT * From user where user_id=%s", $_POST["user_id"]);
		$user_info = $DB->getRow($query);		
		if(isset($user_info))
			return 0;
		if($_POST["pwd"]!=$_POST["pwd_"])
			return 0;
		if(!ismail($_POST["email"]))
			return 0;

		$id = $DB->Insert('user', array(
			'user_id'=>$_POST["user_id"],
			'password'=>$_POST["password"],
			'address'=>$_POST["address"],
			'address_'=>$_POST["address_"],
			'name'=>$_POST["name"],
			'sex'=>$_POST["sex"],
			'phone'=>$_POST["phone"],
			'email'=>$_POST["email"],
			'birth'=>$_POST["birth"]
			), array("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s"));

		$DB->Insert('user_var', array(
				'user_id'=>$id,
				'key'=>'auth',
				'value'=>'user'
			), array("%d", "%s", "%s"));

	}

	function update()
	{
		global $DB;
		$DB->Update('user',
		array('password'=>md5($_POST["password"]),
			'address'=>$_POST["address"],
			'address_'=>$_POST["address_"],
			'phone'=>$_POST["phone"],
			'email'=>$_POST["email"],
			'birth'=>$_POST["birth"]),
		array("%s", "%s", "%s", "%s", "%s", "%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->address = $_POST["address"];
		$this->address_ = $_POST["address_"];
		$this->phone = $_POST["phone"];
		$this->email = $_POST["email"];
		$this->birth = $_POST["birth"];
		$_SESSION["session_user"] = serialize($this);
	}

	function getAuth($auth) {
		return in_array($auth, $this->auth);
	}
}