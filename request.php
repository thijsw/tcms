<?php

class Request {

	private static $instance;
	private $segments = array();

	private function __construct() {
		global $__default_module, $__default_method;

		$rep = Repository::getInstance();

		// match either /foo/bar, index.php?foo/bar or /?foo/bar
		preg_match('/^(\/index\.php\?)?(\/\?)?(.*)$/', $_SERVER['REQUEST_URI'], $matches);

		// store segments, first one is name of module
		$this->segments = explode('/', strlen($matches[3]) < 2 ? $__default_module : $matches[3]);
	}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Request();
		return self::$instance;
	}

	public function get_module () {
		return $this->segments[0];
	}

	public function get_method () {
		global $__default_method;
		return empty($this->segments[1]) ? $this->segments[1] = $__default_method : $this->segments[1];
	}

	public function get ($i) {
		if (!is_int($i)) throw new Exception_Core("Get param must be of type integer");
		return $this->segments[$i+1];
	}

	public function post ($name) {
		return $_POST[$name];
	}
	
}

?>