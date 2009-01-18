<?php

class Frontend_Homepage extends Frontend {

	public function index () {
		$db = Database::getInstance();
		$id = $db->get_one("SELECT page_id FROM homepage LIMIT 1");
		if ($id) {
			$storage = Storage::getInstance();
			$this->item = $storage->load('Page_Page', (int) $id);
		}
	}

	public function get_title () {
		if ($this->item)
			return $this->item->title;
		return 'Welkom bij de Studenten Organisatie Groningen (SOG)';
	}

}

?>