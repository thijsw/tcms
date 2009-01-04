<?php

class Backend_Navigation extends Backend {

	public $current = null;
	protected $class_item = 'Navigation_Item';

	public function set_current(Navigation_Item $item) {
		$this->current = $item;
	}

	public function get_navigation_areas () {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$rows = $db->get_rows(sprintf('SELECT * FROM %s WHERE parent IS NULL AND tag IS NOT NULL', strtolower($this->class_item)));
		return $storage->load_multiple($this->class_item, $rows);
	}

	public function add_item ($data) {
		if ($this->get(3) < 1) return;
		$this->set_template('add_item');

		$this->id = (int) $this->get(3);

		if ($data) {
			$db = Database::getInstance();
			$data['enabled'] = $data['enabled'] ? 1 : 0;
			$data['parent'] = $this->id;
			$data['sort'] = $db->get_one(sprintf("SELECT IFNULL(MAX(sort)+1, 1) FROM %s WHERE parent = %d", strtolower($this->class_item), $this->id));
			list($data['method'], $data['param']) = explode('/', $data['item']);
			unset($data['item']);
			$db = Database::getInstance();
			$db->insert($this, 'item', $data);
			$res = Response::getInstance();
			$res->redirect($this->url('admin', 'module', $this->get_module_name()));
		}
	}

	public function delete_item () {
		if ($this->get(3) < 1) return STATUS_NOT_FOUND;

		$storage = Storage::getInstance();

		$item = $storage->load($this->class_item, (int) $this->get(3));
		$item->delete();

		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'module', $this->get_module_name()));
	}

	public function move_up () {
		if ($this->get(3) < 1) return STATUS_NOT_FOUND;

		$storage = Storage::getInstance();
		$item = $storage->load($this->class_item, (int) $this->get(3));
		$item->move_up();

		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'module', $this->get_module_name()));
	}

	public function move_down () {
		if ($this->get(3) < 1) return STATUS_NOT_FOUND;

		$storage = Storage::getInstance();
		$item = $storage->load($this->class_item, (int) $this->get(3));
		$item->move_down();

		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'module', $this->get_module_name()));
	}

	public function move_item ($data) {
		if ($this->get(3) < 1) return STATUS_NOT_FOUND;
		$storage = Storage::getInstance();
		$this->item = $storage->load($this->class_item, (int) $this->get(3));

		if (isset($data) && isset($data['move'])) {
			$parent = $storage->load($this->class_item, (int) $data['move']);
			if (!$parent) return STATUS_NOT_FOUND;
			$this->item->change_parent($parent);

			$res = Response::getInstance();
			$res->redirect($this->url('admin', 'module', $this->get_module_name()));
			return;
		}

		$this->set_template('move_item');
	}

}

?>