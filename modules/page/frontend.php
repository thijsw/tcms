<?php

require_once 'modules/homepage/frontend.php';

class Frontend_Page extends Frontend_Homepage {

	public function index () {
		echo 'list pages';
	}

	public function view () {
		return $this->render('page');
	}

	public function get_title () {
		return 'Pagina-titel';
	}

}

?>