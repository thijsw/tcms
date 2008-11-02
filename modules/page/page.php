<?php

class Module_Page extends Module {

	public function _get_all_pages () {
		$db = Database::getInstance();
		return $db->get_rows("select * from page_pages left join users on users.id=page_pages.author order by page_pages.id");
	}

	public function index () {
		echo 'list pages';
	}

	public function view () {
		var_dump($this);
		echo 'view page';
	}

}

?>