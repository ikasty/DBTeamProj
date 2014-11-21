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
	* 입력받은 쿼리를 실행하고 각 결과를 배열로 리턴하는 함수
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
	* @return Object
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
	* 특정 조건대로 검색하여 결과값을 받아오는 함수
	*
	* @access public
	* @param String $query
	* @return value
	*/
	public function getCount($query) {
		$result = $this->mysqli->query($query);
		if (!$result) return false;
		$result = $result->fetch_array();
		return $result[0];
	}

	/**
	 * select helper func
	 * usage:
	 * 		select(array('A'=>'Apartment'), array('id', 'name'=>'apartName'));
	 */
	public function select($tables, $field, $cond, $option, $join) {
		$query = "SELECT";

		// add field
		$query .= ' ' . $this->makeFieldName($field);

		// add table name
		// make 'FROM Customer C, Products P INNER JOIN Orders O ON (C.id=O.cid) ...'
		$query .= " FROM " . $this->makeTableName($tables, $join);

		// add where clause
		if ( !empty($cond) )
			$query .= " WHERE " . $this->makeCondition($cond);

		return $query;
	}

	private function makeFieldName($fields) {
		if (!is_array($fields)) return $fields;

		$ret = array();
		foreach($fields as $alias => $field) {
			if ($alias !== $field)
				$ret[] = $field . ' ' . $alias;
			else
				$ret[] = $field;
		}

		return implode(',', $ret);
	}

	private function makeTableName($tables, $join) {
		if (!is_array($tables)) return $tables;

		// make table names
		foreach ($tables as $alias => $table) {
			if ( !is_string($alias) ) $alias = $table;

			// make 'table' or 'table alias'
			$tblclause = ($alias == $table) ?
						 ($table) :
						 ($table . ' ' . $this->addIdentifierQuotes($alias));

			if ( isset($join[$alias]) ) {
				list( $jointype, $joincond ) = $join[$alias];

				// 'INNER JOIN table' or 'INNER JOIN table alias'
				$tblclause = $jointype . ' ' . $tblclause;

				$on = $this->makeList($joincond, 'AND');
				if ($on != '') $tblclause .= 'ON (' . $on . ')';

				$tblJoin[] = $tblclause;
			} else {
				$tblname[] = $tblclause;
			}
		} // end foreach

		return implode(',', $tblname) . ' ' . (!empty($tblJoin) ? implode(' ', $tblJoin) : '');
	}

	private function makeCondition($conds) {
		if (!is_array($conds)) return $conds;

		$ret = array();
		foreach ($conds as $field => $cond) {
			$ret_temp = $field;
			
			if (is_integer($field)) {
				$ret_temp = $cond;
			}
			else if (is_string($field)) {
				$ret_temp .= ' ' . $cond;
			}
			else if (is_array($cond)) {
				$ret_temp .= ' IN (' . implode(',', $cond) . ')';
			} else {
				continue;
			}
			$ret[] = $ret_temp;
		}
	}

	private function makeList($array, $type = ',') {
		if (!is_array($array)) return '';

		$list = array();
		foreach ($array as $key => $value) {
			$list[] = "'" . $this->mysqli->real_escape_string($value) . "'";
		}

		return implode($type, $list);
	}

	private function addIdentifierQuotes($s) { return '"' . str_replace('"', '""', $s) . '"'; }

	/**
	 * insert helper function
	 * usage:
	 * 		$DB->insert('tablename', array("id"=>1, "name"=>"John", "count"=>10));
	 *
	 * @access public
	 * @param String $table
	 * @param array $value
	 * @return String
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

		return (bool) $query;
	}

	/**
	 * return last insert id value
	 * @access public
	 * @return integer
	 */
	public function insertedId() {
		return $this->mysqli->insert_id;
	}

	//////////////////////////////////////////////////////////////
	// unrefactorized

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
}

function getDB() {
	static $__DB = NULL;

	if ($__DB === NULL)
		$__DB = new DB();

	return $__DB;
}
?>