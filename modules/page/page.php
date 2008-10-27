<?php

require_once 'module.php';

class Module_Page extends Module {
	
	public function index () {
		echo 'list pages';
	}

	public function view () {
		var_dump($this);
		echo 'view page';
	}

}

?>