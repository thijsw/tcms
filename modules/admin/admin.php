<?php

class Module_Admin extends Module {

	public function index () {
		return $this->render('main');
	}

	public function login () {
		return $this->render('login');
	}

	public function render_module () {
		$rep = Repository::getInstance();

		if (($module = $rep->load_module($this->get(1))) === null) {
			throw new Exception_HTTP(404);
		}

		return $module->render_backend('overview');
	}

}

?>