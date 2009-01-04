<?php

class Authentication {

	private static $instance;
	private $logged_in = false;
	private $user;

	private function __construct ()
	{
		$req = Request::getInstance();
		if (!is_null($req->get_cookie('authentication'))) {
			$data = unserialize(stripslashes($req->get_cookie('authentication')));

			/* Corrupt cookie? */
			if (!is_numeric($data['id'])) return;

			$storage = Storage::getInstance();
			$this->user = $storage->load('Module_Author', (int) $data['id']);

			if ($this->generate_hash($this->user->username, $this->user->password) == $data['hash']) {
				$this->logged_in = true;
			}
		}
	}

	public static function getInstance ()
	{
		if (empty(self::$instance))
			self::$instance = new Authentication();
		return self::$instance;
	}

	public function get_user () {
		return $this->user;
	}

	public function is_authenticated ()
	{
		return (bool) $this->logged_in;
	}

	public function login ($username, $password)
	{
		$db = Database::getInstance();
		$res = Response::getInstance();

		$result = $db->get_row(sprintf("SELECT * FROM module_author WHERE username = '%s' AND password = '%s'", mysql_real_escape_string($username), md5($password)));

		if (!$result) {
			return false;
		}

		$hash = $this->generate_hash($username, md5($password));

		$res->set_cookie('authentication',
			serialize(
				array(
					'username' => $result['username'],
					'id' => $result['id'],
					'hash' => $hash
				)
			)
		);
		return $this->logged_in = true;
	}

	public function logout ()
	{
		$res = Response::getInstance();
		$res->set_cookie('authentication', '', time()-10800);
		$this->user = array();
		$this->logged_in = false;
	}

	public function generate_hash ($username, $password)
	{
		$str = "salt44549685406849308654286946645";
		$str .= isset($_SERVER['HTTP_REMOTE_ADDR']) ? $_SERVER['HTTP_REMOTE_ADDR'] : '';
		$str .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$str .= $username . $password;
		return sha1($str);
	}

}

?>