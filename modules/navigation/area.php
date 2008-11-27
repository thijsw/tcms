<?php

class Navigation_Area extends Model {

	public function get_items ($parent = null) {
		$db = Database::getInstance();
		$rows = $db->get_rows(sprintf(
			'SELECT * FROM navigation_item WHERE `area` = %d AND `parent` IS NULL ORDER BY `sort`',
			$this->id
		));

		$storage = Storage::getInstance();
		return $storage->load_multiple('Navigation_Item', $rows);
	}

}

?>