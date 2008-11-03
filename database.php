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
			
		$this->query('SET NAMES utf8');
	}

	public function query ($sql) {
		if (($ret = mysql_query($sql, $this->connection)) == false) {
			throw new Exception_MySQL(mysql_error());
		}
		return $ret;
	}

	public function get_one ($sql) {
		return current($this->get_row($sql));
	}

	public function get_last_insert_id () {
		return (int) $this->get_one('SELECT LAST_INSERT_ID()');
	}

	public function get_row ($sql) {
		$ret = $this->query($sql);
		return mysql_fetch_assoc($ret);		
	}

	public function get_rows ($sql) {
		$ret = $this->query($sql);
		$rows = array();
		while ($row = mysql_fetch_assoc($ret)) {
			$rows[] = $row;
		}
		return $rows ? $rows : null;
	}

	public function update (Module $module, $table, $id, $data) {
		if (count($data) < 1) return;

		// table name consists of prefix plus given name
		$table = $module->get_module_name() . '_' . $table;

		$sql = "UPDATE $table SET ";

		foreach ($data as $key => $value) {
			$sql .= "`$key` = '" . mysql_real_escape_string($value) . "', ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= " WHERE id = $id LIMIT 1";

		return $this->query($sql);
	}

	public function insert (Module $module, $table, $data) {
		if (count($data) < 1) return;

		// table name consists of prefix plus given name
		$table = $module->get_module_name() . '_' . $table;

		foreach (array_values($data) as $value) {
			$values .= "'" . mysql_real_escape_string($value) . "',";
		}

		$values = substr($values, 0, -1);

		$sql = "INSERT INTO $table (".implode(',', array_keys($data)).") VALUES (".$values.")";

		$this->query($sql);
		return $this->get_last_insert_id();
	}

	public function delete (Module $module, $table, $id) {
		$table = $module->get_module_name() . '_' . $table;

		return $this->query(sprintf("DELETE FROM $table WHERE id = %d", $id));
	}

}

?>