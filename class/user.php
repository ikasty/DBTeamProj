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

	public $file_list[] = "";

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

			$query = $DB->MakeQuery("SELECT * From 근무 where id=%s", $this->developer_id);
			$work_on_info = $DB->getRow($query);

			$this->company = $major_info["회사이름"];

			$query = $DB->MakeQuery("SELECT * From 부서 where 회사이름=%s", $this->company);
			$department_info = $DB->getRow($query);

			$this->company = $department_info["부서id"];

			//다중속성
			$query = $DB->MakeQuery("SELECT 평가자료 From 평가자료 where 개발자id=%s", $this->developer_id);
			$file_list = $DB->getColumn($query);
			
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
		if ($user_id === "") return false;
		
		$query = $DB->MakeQuery("SELECT * From 개발자 where id=%s", $user_id);
		$developer_info = $DB->getRow($query);


		if ($developer_info["id"] != "") //개발자 ID 로 관리자 체크
		{
			return false;
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
			$query = $DB->MakeQuery("SELECT 자료id From 평가자료 where 개발자id=%s", $D_list[i++]);
			$DFile_list[] = $DB->getColumn($query);

			if(strpos($DFile_list,$file_id) == true) {
				//평가 
			}
			else {
				return false;
			}
		}
	}

	function File_Upload()
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	}

	function StartEvaluate()
	{

	}

}
?>