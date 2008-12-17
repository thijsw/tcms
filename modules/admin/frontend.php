<?php

class Frontend_Admin extends Frontend {

	public $module;
	public $method;

	public function index () {
		$rep = Repository::getInstance();
		$this->module = $this;
	}

	public function login () {

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