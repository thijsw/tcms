<?php

class Response {

	private static $instance;
	private $headers = array();

	private function __construct() {}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Response();
		return self::$instance;
	}

	public function set_header($name, $value) {
		$this->headers[$name] = $value;
	}

	public function set_content_type ($content_type) {
		return $this->set_header('Content-Type', $content_type);
	}

	public function echo_headers () {
		foreach ($this->headers as $name => $value) {
			header($name . ": " . $value);
		}
	}

}

?>