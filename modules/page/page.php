<?php

require_once 'module.php';

class Module_Page extends Module {
	
	public function index () {
		echo 'list pages';
	}

	public function view () {
		echo 'view page';
	}

}

?>