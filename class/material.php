<?php
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);


class Material
{

	//url이 저장될 자료정보 필드 미리 추가
	public $file_id = "";
	public $file_category = "";  
	public $upload_time = "";
	public $contribution = 0;
	public $url = "";

	protected function __construct($file_id)
	{
		$DB = getDB();

		if($file_id !== "") {
			$query = $DB->MakeQuery("SELECT * From 평가자료 where 자료id=%s", $file_id);
			$file_info = $DB->getRow($query);

			$this->file_id = $file_info["자료id"];
			$this->upload_time = $file_info["업로드시간"];
			$this->contribution = $file_info["기여도"];
			$this->url = $file_info["자료정보"];

			$query = $DB->MakeQuery("SELECT * From 자료분야 where 자료id=%s", $file_id);
			$category_info = $DB->getRow($query);

			$this->file_category = $category_info["자료분야"];
		}
	}

	public static function getMaterial($file_id)
	{
		global $DB;

		$query = $DB->MakeQuery("SELECT * From 평가자료 where 자료id=%s", $file_id);
		$material_info = $DB->getRow($query);


		if ($material_info["자료id"] != "")
		{
			return new Material($file_id);
		}
		else
		{
			return false;
		}
	}

	function updateMaterial()
	{
		global $DB;

		$DB->Update('평가자료',
		array('file_id'=>$_POST["자료id"],
			'upload_time'=>$_POST["업로드시간"],
			'contribution'=>$_POST["기여도"],
			'url'=>$_POST["자료정보"]),
		array("%s", "%s", "%s", "%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->file_id = $_POST["자료id"];
		$this->upload_time = $_POST["업로드시간"];
		$this->contribution = $_POST["기여도"];

		$DB->Update('자료분야',
		array('file_category'=>$_POST["자료분야"]),
		array("%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->file_category = $_POST["자료분야"];
		
		$_SESSION["session_user"] = serialize($this);
	}

}
?>