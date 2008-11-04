<?php

class Backend_Navigation extends Backend {

	public function get_navigation_items ($area) {
		$db = Database::getInstance();
		return $db->get_rows(sprintf('select * from navigation_items where area = %d order by id', (int) $area));
	}

	public function get_navigation_areas () {
		$db = Database::getInstance();
		return $db->get_rows('select * from navigation_areas');
	}

}

?>