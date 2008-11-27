<?php

class Backend_Navigation extends Backend {

	public $current = null;

	public function set_current($item) {
		$this->current = $item;
	}

	public function get_navigation_areas () {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$rows = $db->get_rows('SELECT * FROM navigation_area');
		return $storage->load_multiple('Navigation_Area', $rows);
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

	public function has_children ($id) {
		$db = Database::getInstance();
		return $db->get_one(sprintf('select id from navigation_item where parent = %d', (int) $id));
	}

	public function delete_item ($id) {
		$id = (int) $this->get(3);

		// delete its children recursively, if any
		while ($cid = $this->has_children($id)) {
			$this->delete_item($cid);
		}

		$db = Database::getInstance();
		$db->query(sprintf('DELETE FROM navigation_item WHERE id = %d', $id));

		$res = Response::getInstance();
		$res->redirect('/?admin/module/navigation');
	}

}

?>