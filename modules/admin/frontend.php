<?php

require_once 'helpers/authentication.php';

class Frontend_Admin extends Frontend {

	public $module;
	public $method;

	private $json = null;

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
			$res->redirect($this->url('admin'));
		}
		if (isset($_POST) && $auth->login($_POST['username'], $_POST['password'])) {
			$res->redirect($this->url('admin'));
		}
	}

	public function logout () {
		$auth = Authentication::getInstance();
		$auth->logout();
		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'login'));
	}

	public function json_public_items () {
		if (strlen($name = $this->get(1)) < 2) return STATUS_NOT_FOUND;

		if (($module = Repository::getInstance()->load_backend($name)) === null) {
			return STATUS_NOT_FOUND;
		}

		Template::getInstance()->set_render(false);
		Response::getInstance()->set_content_type('application/json');
		$this->json = json_encode($module->get_public_items());
	}

	public function render ($style) {
		if (isset($this->json))
			return $this->json;
		return parent::render($style);
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

		$this->method = $method = 'index';

		if ($this->get(2)) {
			if (method_exists($this->module, $this->get(2))) {
				$this->method = $method = $this->get(2);
			}
		}

		return $this->module->$method(count($_POST) > 0 ? $_POST : null);
	}

}

?>