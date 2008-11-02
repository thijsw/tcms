<?php

class Module_Admin extends Module {

	public function index () {
		return $this->render_module();
	}

	public function login () {
		return $this->render('login');
	}

	public function render_module () {
		$rep = Repository::getInstance();

		if (($this->module = $rep->load_module($this->get(1))) === null) {
			$this->module = $this;
		}

		return $this->render('main');
	}

}

?>