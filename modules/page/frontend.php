<?php

class Frontend_Page extends Frontend {

	public function index () {
		echo 'list pages';
	}

	public function view () {
		var_dump($this);
		echo 'view page';
	}

}

?>