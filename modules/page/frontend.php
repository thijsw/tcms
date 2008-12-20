<?php

require_once 'modules/homepage/frontend.php';

class Frontend_Page extends Frontend_Homepage {


	public function view () {
		$storage = Storage::getInstance();
		if (($this->page = $storage->load('Page_Page', (int) $this->get(1))) === false) {
			return STATUS_NOT_FOUND;
		}
	}

	public function get_title () {
		return $this->page ? $this->page->title : '(Naamloos)';
	}

}

?>