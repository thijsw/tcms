<?php

class Page_Page extends Model {

	private $author = null;

	public function set_author (Module_Author $author) {
		$this->author = $author;
	}

	public function get_author () {
		return $this->author;
	}

}

?>