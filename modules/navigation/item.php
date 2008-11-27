<?php

class Navigation_Item extends Model {

	public function can_move_up () {
		// ...
	}

	public function can_move_down () {
		// ...
	}

	public function get_area () {
		$storage = Storage::getInstance();
		return $storage->load('Navigation_Area', $this->area);
	}

	public function get_parent () {
		if (!$this->parent) return;
		$storage = Storage::getInstance();
		return $storage->load(get_class($this), $this->parent);
	}

	public function get_next_ancestor () {
		$parent = $this->get_parent();
		if (!$parent) return;

	}

	public function get_previous_ancestor () {
		// ..
	}

	/**
	 * Delete this item
	 *
	 * @return void
	 */
	public function delete () {
		// ...
	}

	public function get_children () {
		if (!$this->haschildren) return array();

		$db = Database::getInstance();
		$rows = $db->get_rows(sprintf(
			'SELECT * FROM navigation_item WHERE `area` = %d AND `parent` = %d ORDER BY `sort`',
			$this->get_area()->id,
			$this->id
		));

		$storage = Storage::getInstance();
		return $storage->load_multiple('Navigation_Item', $rows);
	}

	public function move_up () {
		// ...
	}

	public function move_down () {
		// ...
	}

	/**
	 * Move tree of items or a single item to another branch in the tree
	 *
	 * @param Item $parent The item under which the tree must be placed
	 * @return boolean
	 */
	public function move_to_tree (Navigation_Item $parent) {
		// ...
	}

	public function add_child (Navigation_Item $item) {
		// ...
	}

}

?>