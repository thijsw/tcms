<?php

class Response {

	private static $instance;
	private $headers = array();
	private $redirect = null;
	private $status = 200;
	private $cookies = array();

	private function __construct () {}

	public static function getInstance ()
	{
		if (empty(self::$instance))
			self::$instance = new Response();
		return self::$instance;
	}

	public function set_header ($name, $value) {
		$this->headers[$name] = $value;
	}

	public function redirect ($uri) {
		$this->redirect = $uri;
	}

	public function set_content_type ($content_type) {
		return $this->set_header('Content-Type', $content_type);
	}

	public function set_status ($code) {
		if (!is_int($code)) return;
		$this->status = $code;
	}

	public function set_cookie ($name, $value, $expire = null) {
		if (is_null($expire)) {
			$expire = time()+3600;
		}
		$this->cookies[$name] = array('value' => $value, 'expire' => $expire);
	}

	public function echo_headers () {

		// 302 Found response header is automatically set by PHP
		if ($this->redirect) {
			header("Location: " . $this->redirect);
		} else switch ($this->status) {
			case 403: header("HTTP/1.1 404 Forbidden"); break;
			case 404: header("HTTP/1.1 404 Not Found"); break;
			default:  header("HTTP/1.1 200 OK");
		}

		foreach ($this->headers as $name => $value) {
			header($name . ": " . $value);
		}

		foreach ($this->cookies as $name => $meta) {
			setcookie($name, $meta['value'], $meta['expire']);
		}
	}

}

?>