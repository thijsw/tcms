<?php

class Frontend_Navigation extends Frontend {

	public function get_menu ($tag) {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$id = $db->get_one($q = sprintf("SELECT id FROM navigation_item WHERE parent IS NULL AND tag = '%s'", $tag));
		return $storage->load('Navigation_Item', (int) $id);
	}

	public function get_breadcrumbs () {
		$req = Request::getInstance();

		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$id = $db->get_one($q = sprintf("SELECT id FROM navigation_item WHERE
			parent IS NOT NULL AND module = '%s' AND (method = '%s' OR method = '%s') AND param = '%s' LIMIT 1",
			$req->get_module(), $req->get_method(), $req->get_method() == 'index' ? '' : $req->get_method(), $this->get(1)
		));

		$item = $storage->load('Navigation_Item', (int) $id);

		if ($item)
			$ancestors = $item->get_ancestors();
		else $ancestors = array();

		// is the homepage module listed?
		$included = false;
		foreach ($ancestors as $item) {
			if ($item->module == 'homepage') {
				$included = true;
			}
		}

		if (!$included)
			array_unshift($ancestors, $this->get_homepage());

		return $ancestors;
	}

	public function get_homepage () {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$id = $db->get_one("SELECT id FROM navigation_item WHERE module = 'homepage' LIMIT 1");
		if ($id)
			return $storage->load('Navigation_Item', (int) $id);
	}

}

?>