<?php

class Backend_Page extends Backend {

	public $page;
	public $pages = array();

	private function get_all_pages () {
		$db = Database::getInstance();
		$rows = $db->get_rows("SELECT p.*, u.id author FROM page_page p LEFT JOIN module_author u on u.id = p.author ORDER BY p.id");

		if (!$rows) return array();

		$pages = array();
		$storage = Storage::getInstance();
		foreach ($rows as $row) {
			$page = $storage->load('Page_Page', $row);
			$author = $storage->load('Module_Author', $row['author']);
			$page->set_author($author);
			$pages[] = $page;
		}

		return $pages;
	}

	public function index () {
		$this->pages = $this->get_all_pages();
		return parent::index();
	}

	public function get_all_public_items () {
		$array = array();
		foreach ($this->_get_all_pages() as $page) {
			if ($page['enabled'] < 1) continue;
			$array[] = array(
				'module' => $this->get_module_name(),
				'method' => 'view',
				'param' => $page['id'],
				'title' => $page['title']
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
			$id = $db->insert($this, 'pages', $data);
			$this->page = $this->_get_page($id);
		}
		return $this->render('edit');
	}

	public function edit ($data) {
		$storage = Storage::getInstance();

		if (($this->page = $storage->load('Page_Page', (int) $this->get(3))) == false) {
			throw new Exception_HTTP(404);
		}

		if ($data) {
			$data['enabled'] = $data['enabled'] ? 1 : 0;
			$data['modified'] = date('Y-m-d H:i:s');
			$this->page = $storage->save($this->page, $data);
		}

		return $this->render('edit');
	}

	public function delete () {
		$storage = Storage::getInstance();

		if (($this->page = $storage->load('Page_Page', (int) $this->get(3))) == false) {
			throw new Exception_HTTP(404);
		}

		$storage->delete($this->page);

		$res = Response::getInstance();
		$res->redirect('/?admin/module/page');
	}

}

?>