<?php

class Backend_Homepage extends Backend {

	public $item = null;

	public function index () {
		$db = Database::getInstance();
		$id = $db->get_one("SELECT page_id FROM homepage LIMIT 1");
		if ($id) {
			$storage = Storage::getInstance();
			$this->item = $storage->load('Page_Page', (int) $id);
		}
		return parent::index();
	}

	public function update_id ($post) {
		if (!empty($post)) {
			$db = Database::getInstance();
			$db->query(sprintf("UPDATE homepage SET page_id = %d", (int) $post['id']));
			Response::getInstance()->redirect($this->url('admin', 'module', $this->get_module_name()));
		}
		return STATUS_BAD_REQUEST;
	}

}

?>