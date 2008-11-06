<?php

class Navigation_Item extends Model {
	
	/**
	 * Delete this item
	 *
	 * @return void
	 */
	public function delete () {
		// ...
	}

	public function get_children () {
		// ...
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