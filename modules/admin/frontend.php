<?php

class Frontend_Admin extends Frontend {

	public $module;
	public $method;

	public function index () {
		return $this->module();
	}

	public function login () {
		return $this->render('login');
	}

	public function module () {
		$rep = Repository::getInstance();

		if (($this->module = $rep->load_backend($this->get(1))) === null) {
			$this->module = $this;
		}

		if ($this->get(2) && $this->module) {
			if (method_exists($this->module, $this->get(2))) {
				$this->method = $this->get(2);
			}
		}

		$this->param = count($_POST) > 0 ? $_POST : null;

		return $this->render('main');
	}

}

?>