<?php

class Model {

	private $values = array();

	public function __construct () {
		// ...
	}

	public function __set ($key, $value) {
		$this->values[$key] = $value;
	}

	public function __get ($key) {
		return isset($this->values[$key]) ? $this->values[$key] : null;
	}

}

?>