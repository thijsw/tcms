<?php

require_once 'exception/mysql.php';

class Database {

	private static $instance;

	public static function getInstance ()
	{
		if (empty(self::$instance))
			self::$instance = new Database();
		return self::$instance;
	}

	private function __construct () {
		if (($this->connection = mysql_connect('localhost', 'root', '')) == false)
			throw new Exception_MySQL ("Connection could not be established : " . mysql_error());
		
		if (mysql_select_db('tcms', $this->connection) == false)
			throw new Exception_MySQL("Database table could not be selected / does not exist : " . mysql_error());
	}

	public function query ($sql) {
		return mysql_query($sql, $this->connection);
	}

	public function get_rows ($sql) {
		$ret = $this->query($sql);
		$rows = array();
		while ($row = mysql_fetch_assoc($ret)) {
			$rows[] = $row;
		}
		return $rows ? $rows : null;
	}

	public function create_table ($name, array $fields, array $indexes = null) {
		
	}
	
}

?>