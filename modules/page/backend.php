<?php

class Backend_Page extends Backend {

	public $item;
	public $items = array();
	public $model_name = 'page';
	public $model_class = 'Page_Page';

	public function get_all_items () {
		$db = Database::getInstance();
		$rows = $db->get_rows(sprintf("SELECT p.*, u.id author FROM %s p LEFT JOIN module_author u on u.id = p.author ORDER BY p.created DESC", strtolower($this->model_class)));

		if (!$rows) return array();

		$pages = array();
		$storage = Storage::getInstance();
		foreach ($rows as $row) {
			$page = $storage->load($this->model_class, $row);
			$author = $storage->load('Module_Author', $row['author']);
			$page->set_author($author);
			$pages[] = $page;
		}

		return $pages;
	}

	public function get_title () {
		return 'Lijst met pagina\'s';
	}

	public function index () {
		$this->items = $this->get_all_items();
		return parent::index();
	}

	public function get_public_items () {
		$array = array();
		foreach ($this->get_all_items() as $page) {
			$array[] = array(
				'module' => $this->get_module_name(),
				'method' => 'view',
				'param' => $page->id,
				'title' => $page->title,
				'enabled' => (bool) $page->enabled
			);
		}
		return $array;
	}

	public function create ($data) {
		if ($data) {
			$data['enabled'] = $data['enabled'] ? 1 : 0;
			$data['author'] = 1; // FIXME
			$data['created'] = date('Y-m-d H:i:s');
			$db = Database::getInstance();
			$id = $db->insert($this, $this->model_name, $data);

			$storage = Storage::getInstance();
			$this->item = $storage->load($this->model_class, $id);
		}
		$this->set_template('edit');
	}

	public function edit ($data) {
		$storage = Storage::getInstance();

		if (($this->item = $storage->load($this->model_class, (int) $this->get(3))) == false) {
			return STATUS_NOT_FOUND;
		}

		if ($data) {
			$data['enabled'] = $data['enabled'] ? 1 : 0;
			$data['modified'] = date('Y-m-d H:i:s');
			$this->item = $storage->save($this->item, $data);
		}

		$this->set_template('edit');
	}

	public function delete () {
		$storage = Storage::getInstance();

		if (($this->item = $storage->load($this->model_class, (int) $this->get(3))) == false) {
			return STATUS_NOT_FOUND;
		}

		$storage->delete($this->item);

		$res = Response::getInstance();
		$res->redirect($this->url('admin', 'module', $this->get_module_name()));
	}

}

?>