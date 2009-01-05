<?php

class Navigation_Item extends Model {

	private $children = null; // null, not array

	public function can_move_up () {
		return (bool) $this->get_previous_ancestor();
	}

	public function can_move_down () {
		return (bool) $this->get_next_ancestor();
	}

	public function is_root () {
		return is_null($this->parent);
	}

	public function is_active () {
		$req = Request::getInstance();
		return (
			$this->module == $req->get_module() &&
			(strlen($this->method) < 1 ? 'index' : $this->method) == $req->get_method() && // empty() does not work properly
			$this->param == $req->get(1)
		);
	}

	public function get_module () {
		$rep = Repository::getInstance();
		return $rep->load_backend($this->module);
	}

	public function get_link () {
		return $this->url($this->module, $this->method, $this->param);
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

	public function get_ancestors () {
		for ($a = array(), $item = $this; !$item->is_root(); array_unshift($a, $item), $item = $item->get_parent());
		return $a;
	}

	public function get_next_ancestor () {
		$parent = $this->get_parent();
		if (!$parent) return;
		$children = $parent->get_children();
		if (count($children) === 1) return;
		for ($i = 0; $i < count($children); $i++) {
			if ($children[$i] === $this && isset($children[$i+1])) // important: test identical not equal
				return $children[$i+1];
		}
	}

	public function get_previous_ancestor () {
		$parent = $this->get_parent();
		if (!$parent) return;
		$children = $parent->get_children();
		if (count($children) === 1) return;
		for ($i = 0; $i < count($children); $i++) {
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
			$this->children = array();
		}

		$storage = Storage::getInstance();
		$storage->delete($this);
	}

	public function get_children () {
		$db = Database::getInstance();

		if (!is_null($this->children))
			return $this->children;

		$rows = $db->get_rows(sprintf(
			'SELECT * FROM %s WHERE `parent` = %d ORDER BY `sort`',
			strtolower(get_class($this)),
			$this->id
		));

		if (!is_array($rows)) return $this->children = array();

		$storage = Storage::getInstance();
		return $this->children = $storage->load_multiple(get_class($this), $rows);
	}

	public function has_children () {
		return (bool) $this->get_children();
	}

	public function change_parent (Navigation_Item $item) {
		$db = Database::getInstance();

		$db->query(sprintf(
			'UPDATE %s SET parent = %d WHERE `id` = %d',
			strtolower(get_class($this)),
			$item->id,
			$this->id
		));

		$this->parent = $item->id;
	}

	/**
	 * Move node up in tree, if possible
	 *
	 * @return boolean
	 */
	public function move_up () {
		if (!$this->can_move_up())
			return false;
		$storage = Storage::getInstance();

		$node = $this->get_previous_ancestor();
		$this->sort--; $node->sort++;
		$storage->save($this); $storage->save($node);
	}

	/**
	 * Move node down in tree, if possible
	 *
	 * @return boolean
	 */
	public function move_down () {
		if (!$this->can_move_down())
			return false;
		$storage = Storage::getInstance();

		$node = $this->get_next_ancestor();
		$this->sort++; $node->sort--;
		$storage->save($this); $storage->save($node);
	}

}

?>