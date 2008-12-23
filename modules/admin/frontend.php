<?php

require_once 'helpers/authentication.php';

class Frontend_Admin extends Frontend {

	public $module;
	public $method;

	public function __construct () {
		$auth = Authentication::getInstance();
		if ($auth->is_authenticated())
			return;
		return $this->set_template('login');
	}

	public function login () {
		$auth = Authentication::getInstance();
		$res = Response::getInstance();
		if ($auth->is_authenticated()) {
			$res->redirect('?admin');
		}
		if (isset($_POST) && $auth->login($_POST['username'], $_POST['password'])) {
			$res->redirect('?admin');
		}
	}

	public function logout () {
		$auth = Authentication::getInstance();
		$auth->logout();
		$res = Response::getInstance();
		$res->redirect('?admin/login');
	}

	public function index () {
		$rep = Repository::getInstance();
		$this->module = $this;
	}

	public function module () {
		$rep = Repository::getInstance();

		if (($this->module = $rep->load_backend($this->get(1))) === null) {
			$this->module = $this;
		}

		$this->method = 'index';

		if ($this->get(2) && $this->module) {
			if (method_exists($this->module, $this->get(2))) {
				$this->method = $this->get(2);
			}
		}

		$this->param = count($_POST) > 0 ? $_POST : null;
	}

}

?>