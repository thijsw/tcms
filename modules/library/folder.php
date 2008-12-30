<?php

require_once 'modules/navigation/item.php';

class Library_Folder extends Navigation_Item {

	private $file_class = 'Library_File';

	public function get_contents () {
		$db = Database::getInstance();
		$rows = $db->get_rows(sprintf("SELECT * FROM %s WHERE folder = %d", strtolower($this->file_class), (int) $this->id));
		if (is_array($rows)) {
			$storage = Storage::getInstance();
			return $storage->load_multiple($this->file_class, $rows);
		}
		return array();
	}

	public function get_children () {
		$children = parent::get_children();
		usort($children, create_function ('$a, $b', 'return strcmp($a->title, $b->title);'));
		return $children;
	}

}

?>