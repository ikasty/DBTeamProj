<?php

/* 기본적으로 developer, administrator 클래스가 있고, privilege(0,1)로 개발자 관리자를 구분함
   로그인은 개발자용 로그인, 관리자 로그인을 따로 만들었음. (추후 개발자면서 관리자인 사람을 위해서)

*/

/* 개발자가 필요한 기능
 		
 		개발자 로그인 로그아웃 *

		개발자 등록
 		평가신청
 		평가하기
 		자료 업로드
 		개인정보 수정(전문분야 포함)
 		정보검색 ?
 		회사 이직, 퇴직
 		부서 이직
		
		개인 자료 이력 조회
		개인 평가 이력 조회

*/
class developer 
{
	public $user_id = "";
	private $password = "";
	public $user_name = "";
	private $privilege = 0; //권한등급 레벨(0-개발자/1-관리자)

	public $developer_id = "";
	public $major = ""; //DB에 안보임
	public $university = "";
	public $hometown = "";

	function __constructor($user_id)
	{
		global $DB;
		
		if($user_id !== "") {
			$query = $DB->MakeQuery("SELECT * From 유저 where id=%s", $user_id);
			$user_info = $DB->getRow($query);

			$this->user_id = $user_info["아이디"];
			$this->password = ($user_info["비밀번호"]);
			$this->user_name = $user_info["이름"];
			$this->privilege = intval($user_info["권한등급"]);

			$query = $DB->MakeQuery("SELECT * From 개발자 where 유저id=%s", $user_id);
			$developer_info = $DB->getRow($query);

			$this->developer_id = $developer_info["id"];
			$this->major = $developer_info["전공"];		//DB에 없음
			$this->university = $developer_info["대학교"];
			$this->hometown = $developer_info["고향"];
		}
	}

	function login($user_id, $password)
	{
		global $DB, $core, $current_user;
		$query = $DB->MakeQuery("SELECT * From 유저 where id=%s", $user_id);
		$user_info = $DB->getRow($query);

		if($user_info["비밀번호"] == md5($password))
		{
			
			$this->user_id = $user_info["id"];
			$this->name = $user_info["이름"];

			$query = $DB->MakeQuery("SELECT * From 개발자 where 유저id=%s", $user_id);
			$developer_info = $DB->getRow($query);

			$this->developer_id = $developer_info["id"];
			$this->major = $developer_info["전공"];		//DB에 없음
			$this->university = $developer_info["대학교"];
			$this->hometown = $developer_info["고향"];
			$_SESSION["session_user"] = serialize($this);
			$_SESSION["login_time"] = time();
			
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

	function update() 
	{
		global $DB;
		$DB->Update('유저',
			//TABEL
		array(	'id'=>$_POST["user_id"],
			'비밀번호'=>md5($_POST["password"]),
			'이름'=>$_POST["user_name"],
			'권한등급'=>$_POST["privilege"]),
			//VALUE
		array("%s", "%s", "%s", "%d"),
			//TYPE
		array('id'=>$this->user_id),
			//WHERE
		array("%d"));
			//WHERETYPE ?
		
		$this->user_id = $_POST["user_id"];
		$this->비밀번호 = $_POST["password"];
		$this->이름 = $_POST["user_name"];
		$this->권한등급 = $_POST["privilege"];
		//$_SESSION["session_user"] = serialize($this); 

		$DB->Update('개발자',
			//TABEL
		array(	'id'=>$_POST["developer_id"],
			'전공'=>md5($_POST["major"]),
			'대학교'=>$_POST["university"],
			'고향'=>$_POST["hometown"]),
			//VALUE
		array("%s", "%s", "%s", "%s"),
			//TYPE
		array('id'=>$this->user_id),
			//WHERE
		array("%d"));
			//WHERETYPE 
		
		$this->id = $_POST["developer_id"];
		$this->전공 = $_POST["major"];
		$this->대학교 = $_POST["university"];
		$this->고향 = $_POST["hometown"];
		$_SESSION["session_user"] = serialize($this);
		//this의 정보를 보관하는 session_user 라는 이름의 SESSION 값 같은데 사용법을 모름
	}



}
/* 관리자가 필요한 기능

	관리자 로그인 로그아웃 *

	정보 검색(평가자 피평가자 그룹도 검색이 가능하게)
	타 개발자 및 관리자 정보 수정(권한 수정)
	회사 정보 수정 
	매핑 기능
	회사 전문성 평가 통계
	해당 평가자에 대한 성향 통계
	평가 신청의 등록 및 종료 

*/
class administrator extends developer
{
	private $admin_id = ""; //추후 어떤 관리자가 수정하였는지 이력을 위해 만든 관리자 id 

	function __constructor($user_id)
	{
		global $DB;
		
		if($user_id !== "") {
			
			if($this->privilege == 1) //admin 일 때
			{

				$query = $DB->MakeQuery("SELECT * From 관리자 where 유저id=%s", $user_id);
				$admin_info = $DB->getRow($query);

				$this->admin_id = $admin_info["관리자id"];
			}
		}
	}

	function admin_login($user_id, $password)
	{
		global $DB, $core, $current_user;
		$query = $DB->MakeQuery("SELECT * From 유저 where id=%s", $user_id);
		$user_info = $DB->getRow($query);

		if($user_info["비밀번호"] == md5($password))
		{
			if($this->privilege == 1) //admin 일 때
			{
			
				$this->user_id = $user_info["id"];
				$this->name = $user_info["이름"];

				$query = $DB->MakeQuery("SELECT * From 개발자 where 유저id=%s", $user_id);
				$developer_info = $DB->getRow($query);

				$this->developer_id = $developer_info["id"];
				$this->major = $developer_info["전공"];		//미구현
				$this->university = $developer_info["대학교"];
				$this->hometown = $developer_info["고향"];

				$query = $DB->MakeQuery("SELECT * From 관리자 where 유저id=%s", $user_id);
				$admin_info = $DB->getRow($query);

				$this->admin_id = $admin_info["관리자id"];
				$_SESSION["session_user"] = serialize($this);
				$_SESSION["login_time"] = time();
			}
			else 
			{
				return false;
			}
			return true;
		}
		else
			return false;
	}




}


 
?>