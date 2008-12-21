<?php

class Authentication {

	private static $instance;

	private function __construct() {}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Authentication();
		return self::$instance;
	}

	public function is_authenticated () {
		return true;
	}

}

?>