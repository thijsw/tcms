<?php

class Backend_Navigation extends Backend {

	public $current = null;

	public function set_current($item) {
		$this->current = $item;
	}

	public function get_navigation_items ($area, $parent = null) {
		$db = Database::getInstance();
		return $db->get_rows(
			sprintf(
				'select * from navigation_items where area = %d and parent %s order by id',
				(int) $area,
				$parent > 0 ? '=' . (int) $parent : 'is null'
			)
		);
	}

	public function get_navigation_areas () {
		$db = Database::getInstance();
		return $db->get_rows('select * from navigation_areas');
	}

	public function get_uri ($item) {
		$uri = '/?';
		$segments = array('module', 'method', 'param');

		while ($segment = array_shift($segments)) {
			if (strlen($item[$segment]) > 0) {
				$uri .= $item[$segment] . '/';
			}
		}

		// cut off trailing slash, or single question mark if uri points to root
		return substr($uri, 0, -1);
	}

	public function has_children ($id) {
		$db = Database::getInstance();
		return $db->get_one(sprintf('select id from navigation_items where parent = %d', (int) $id));	
	}

	public function delete_item ($id) {
		$id = (int) $this->get(3);

		// delete its children recursively, if any
		while ($cid = $this->has_children($id)) {
			$this->delete_item($cid);
		}

		$db = Database::getInstance();
		$db->query(sprintf('delete from navigation_items where id = %d', $id));

		$res = Response::getInstance();
		$res->redirect('/?admin/module/navigation');
	}

}

?>