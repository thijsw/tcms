<?php

class Module_Admin extends Module {

	public $module;
	public $method;

	public function index () {
		return $this->module();
	}

	public function login () {
		return $this->frontend('login');
	}

	public function module () {
		$rep = Repository::getInstance();

		if (($this->module = $rep->load_module($this->get(1))) === null) {
			$this->module = $this;
		}

		if ($this->get(2) && $this->module) {
			if (method_exists($this->module, $this->get(2))) {
				$this->method = $this->get(2);
			}
		}

		$this->param = count($_POST) > 0 ? $_POST : null;

		return $this->frontend('main');
	}

}

?>