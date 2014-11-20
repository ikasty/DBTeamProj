<?php
/**
* 인터넷프로그래밍 팀 프로젝트 DB 관리 클래스
* 
* Created on 2013. 5. 10.
* edited on 2014. 11. 18.
* @category		class
* @access		public
* @author		강대연
* @version		0.1
*/

if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

// class DB
// 
class DB {
	private $dbname;

	private $mysqli;

	/**
	* 기본 생성자
	*
	* @access public
	* @return object
	*/
	public function __construct() {
		global $db_setting;

		//데이터베이스 이름 불러오기
		$dbname = $db_setting["db_name"];
		//데이터베이스 객체 생성
		$this->mysqli = new mysqli($db_setting["db_host"], $db_setting["db_id"], $db_setting["db_pw"], $dbname);
		if ($this->mysqli->connect_errno)
			die("Failed to connect Database(" . $this->mysqli->connect_errno . "): " . $this->mysqli->connect_error);

		//문자셋 설정
		$this->mysqli->set_charset("utf8");
	}

	/**
	* 쿼리 문장을 만들어주는 함수
	*
	* @access public
	* @param String $query
	* @params String $Values
	* @return String
	*/
	public function MakeQuery($query, $values) {
		//우선 대체할 값들을 받은 다음
		$values = func_get_args();
		array_shift($values);
		//values가 여러개인 경우 배열 제거
		if (is_array($values[0])) $values = $values[0];

		//SQL Injection 방지 처리 후
		foreach ($values as $key=>$value)
			$values[$key] = addslashes($value);

		//혹시모를 "%s"에서 따옴표를 제거한다
		$query = str_replace("'%s'", "%s", $query);
		$query = str_replace('"%s"', "%s", $query);

		$query = str_replace('%s', "'%s'", $query);

		//'' 없는 문자열 처리
		$query = str_replace('%p', "%s", $query);

		return @vsprintf($query, $values);
	}

	/**
	* 입력받은 쿼리를 실행하는 함수
	*
	* @access public
	* @param String $query
	* @return XQLObject
	*/
	public function query($query) {
		return $this->mysqli->query($query);
	}

	/**
	* 입력받은 쿼리를 실행하고 결과를 배열로 리턴하는 함수
	*
	* @access public
	* @param String $query
	* @return Array
	*/
	public function getResult($query) {
		$result = $this->mysqli->query($query);
		if (!$result) return array();
		for ($return = array(); $tmp = $result->fetch_array(MYSQLI_ASSOC); ) $return[] = $tmp;
		return $return;
	}
	
	/**
	* 특정 조건대로 검색하여 열 하나로 받아오는 함수
	*
	* @access public
	* @param String $query
	* @return Array
	*/
	public function getRow($query) {
		$result = $this->mysqli->query($query);
		if (!$result)
			return false;
		return $result->fetch_assoc();
	}

	/**
	* 특정 조건대로 검색하여 행 하나로 받아오는 함수
	*
	* @access public
	* @param String $query
	* @return Array
	*/
	public function getColumn($query) {
		$result = $this->mysqli->query($query);
		if (!$result) return false;

		for ($return = array(); $tmp = $result->fetch_array(MYSQLI_NUM); ) $return[] = $tmp[0];
		return $return;
	}

	/**
	* 특정 조건대로 검색하여 결과 개수를 받아오는 함수
	*
	* @access public
	* @param String $query
	* @return integer
	*/
	public function getCount($query) {
		$result = $this->mysqli->query($query);
		if (!$result) return false;
		$result = $result->fetch_array();
		return (int) $result[0];
	}

	/**
	 * insert helper function
	 * usage:
	 * 		$DB->insert('tablename', array("id"=>1, "name"=>"John", "count"=>10));
	 * @access public
	 * @param String $table
	 * @param array $value
	 * @return boolean
	 */
	public function insert($table, $value) {
		if ( !count($value) ) return true;

		//우선 데이터를 준비한다
		if ( isset($value[0]) && is_array($value[0]) ) {
			$multi = true;
			$fields = array_keys($value[0]);
		} else {
			$multi = false;
			$fields = array_keys($value);
			$value = array($value);
		}
		
		//그리고 sql문을 만든다
		$query = "INSERT INTO " . $table . "(`" . implode("`,`", $fields) . "`) VALUES ";

		$value_array = array();
		foreach($value as $row) {
			$value_array[] = "(" . $this->makeList($row) . ")";
		}
		$query .= implode(",", $$value_array);

		return (bool) $this->query( $query );
	}

	public function insertedId() {
		return $this->mysqli->insert_id;
	}

	public function Update($table, $value, $type, $where, $where_type) {
		$data = array();
		$where_data = array();

		//우선 데이터를 준비한다
		foreach ($value as $key=>$values) {
			$data[] = '`' . $key . '`=' . array_shift($type);
		}
		foreach ($where as $key=>$values) {
			$where_data[] = '`' . $key . '`=' . array_shift($where_type);
		}

		//그리고 sql문을 만든다
		$query = "UPDATE " . $table . " SET " . implode(", ", $data) . " WHERE " . implode(" AND ", $where_data);
		return $this->mysqli->query( $this->MakeQuery( $query, array_merge( array_values($value), array_values($where) ) ) );
	}

	public function Deletes($table, $value, $type) {
		$data = array();

		//우선 데이터를 준비한다
		$fields = array_keys($value);
		foreach($value as $key=>$values) {
			$data[] = '`' . $key . '`=' . array_shift($type);
		}

		//그리고 sql문을 만든다
		$query = "DELETE FROM " . $table . " WHERE " . implode(" AND ", $data);
		return $this->mysqli->query( $this->MakeQuery($query, array_values($value)) );
	}

	public function makeList($array, $type = ',') {
		if (!is_array($array)) return '';

		$list = array();
		foreach ($array as $key => $value) {
			$list[] = "'" . $this->mysqli->real_escape_string($value) . "'";
		}

		return implode(",", $list);
	}
}

function getDB() {
	static $__DB = NULL;

	if ($__DB === NULL)
		$__DB = new DB();

	return $__DB;
}
?>