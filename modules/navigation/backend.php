<?php

class Backend_Navigation extends Backend {

	public $current = null;

	public function set_current(Navigation_Item $item) {
		$this->current = $item;
	}

	public function get_navigation_areas () {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$rows = $db->get_rows('SELECT * FROM navigation_item WHERE parent IS NULL AND tag IS NOT NULL');
		return $storage->load_multiple('Navigation_Item', $rows);
	}

	public function get_uri (Navigation_Item $item) {
		$uri = '/?';
		$segments = array('module', 'method', 'param');

		while ($segment = array_shift($segments)) {
			if (strlen($item->$segment) > 0) {
				$uri .= $item->$segment . '/';
			}
		}

		// cut off trailing slash, or single question mark if uri points to root
		return substr($uri, 0, -1);
	}

	public function add_item () {
		if ($this->get(3) < 1) return;
		$this->set_template('add_item');
	}

	public function delete_item () {
		if ($this->get(3) < 1) return;

		$storage = Storage::getInstance();
		$item = $storage->load('Navigation_Item', (int) $this->get(3));
		$item->delete();

		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'module', $this->get_module_name()));
	}

	public function move_up () {
		if ($this->get(3) < 1) return;

		$storage = Storage::getInstance();
		$item = $storage->load('Navigation_Item', (int) $this->get(3));
		$item->move_up();

		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'module', $this->get_module_name()));
	}

	public function move_down () {
		if ($this->get(3) < 1) return;

		$storage = Storage::getInstance();
		$item = $storage->load('Navigation_Item', (int) $this->get(3));
		$item->move_down();

		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'module', $this->get_module_name()));
	}


}

?>