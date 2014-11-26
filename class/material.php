<?php
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);


class Material
{

	public $file_id = "";
	public $upload_time = "";


	//public $file_major = "";      평가자료의 전문분야 CS
	public $file_category = "";  //평가자료의 자료구분  Embedded System

	protected function __construct($file_id)
	{
		$DB = getDB();

		if($file_id !== "") {
			$query = $DB->MakeQuery("SELECT * From 평가자료 where 자료id=%s", $file_id);
			$file_info = $DB->getRow($query);

			$this->file_id = $file_info["자료id"];
			$this->upload_time = $file_info["업로드시간"];

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
			'upload_time'=>$_POST["업로드시간"]),
		array("%s", "%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->file_id = $_POST["자료id"];
		$this->upload_time = $_POST["업로드시간"];

		$DB->Update('자료분야',
		array('file_category'=>$_POST["자료분야"]),
		array("%s"),
		array('id'=>$this->id),
		array("%d"));
		
		$this->file_category = $_POST["자료분야"];
		
		$_SESSION["session_user"] = serialize($this);
	}

	function File_Upload($file_id)
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

	function proposeEvaluate($file_id)
	{


	}







}
?>