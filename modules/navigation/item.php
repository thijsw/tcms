<?php

class Navigation_Item extends Model {

	public function can_move_up () {
		return (bool) $this->get_previous_ancestor();
	}

	public function can_move_down () {
		return (bool) $this->get_next_ancestor();
	}

	public function is_root () {
		return is_null($this->parent);
	}

	public function get_root () {
		$node = $this;
		while (!$node->is_root()) {
			$node = $node->get_parent();
		}
		return $node;
	}

	public function get_parent () {
		if (is_null($this->parent)) return;
		$storage = Storage::getInstance();
		return $storage->load(get_class($this), $this->parent);
	}

	public function get_depth ($i = 0) {
		if (($parent = $this->get_parent()) === null)
			return $i;
		else return $parent->get_depth(++$i);
	}

	public function get_next_ancestor () {
		$parent = $this->get_parent();
		if (!$parent) return;
		if (count($children) === 1) return;
		for ($i = 0, $children = $parent->get_children(); $i < count($children); $i++) {
			if ($children[$i] === $this && isset($children[$i+1])) // important: test identical not equal
				return $children[$i+1];
		}
	}

	public function get_previous_ancestor () {
		$parent = $this->get_parent();
		if (!$parent) return;
		if (count($children) === 1) return;
		for ($i = 0, $children = $parent->get_children(); $i < count($children); $i++) {
			if ($children[$i] === $this && isset($children[$i-1])) // important: test identical not equal
				return $children[$i-1];
		}
	}

	/**
	 * Delete this item and its children recursively
	 *
	 * @return void
	 */
	public function delete () {
		while ($this->has_children()) {
			foreach ($this->get_children() as $child) {
				$child->delete();
			}
		}

		$storage = Storage::getInstance();
		$storage->delete($this);
	}

	public function get_children () {
		$db = Database::getInstance();

		$rows = $db->get_rows(sprintf(
			'SELECT * FROM navigation_item WHERE `parent` = %d ORDER BY `sort`',
			$this->id
		));

		if (!is_array($rows)) return array();

		$storage = Storage::getInstance();
		return $storage->load_multiple('Navigation_Item', $rows);
	}

	public function has_children () {
		return (bool) $this->get_children();
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