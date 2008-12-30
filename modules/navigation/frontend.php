<?php

class Frontend_Navigation extends Frontend {

	public function get_menu ($tag) {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$id = $db->get_one($q = sprintf("SELECT id FROM navigation_item WHERE parent IS NULL AND tag = '%s'", $tag));
		return $storage->load('Navigation_Item', (int) $id);
	}

}

?>