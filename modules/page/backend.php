<?php

class Backend_Page extends Backend {

	public $page;

	public function _get_all_pages () {
		$db = Database::getInstance();
		return $db->get_rows("select p.*, u.name_first, u.name_last from page_pages p left join users u on u.id=p.author order by p.id");
	}

	public function _get_page ($id) {
		$db = Database::getInstance();
		return $db->get_row(sprintf("select * from page_pages where id = %d", $id));
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
		if (($this->page = $this->_get_page($this->get(3))) == false) {
			throw new Exception_HTTP(404);
		}

		if ($data) {
			$data['enabled'] = $data['enabled'] ? 1 : 0;
			$data['modified'] = date('Y-m-d H:i:s');
			$db = Database::getInstance();
			$db->update($this, 'pages', $this->get(3), $data);
			// update info
			$this->page = $this->_get_page($this->get(3));
		}

		return $this->render('edit');
	}

	public function delete () {
		if (($this->page = $this->_get_page($this->get(3))) == false) {
			throw new Exception_HTTP(404);
		}

		$db = Database::getInstance();
		$db->delete($this, 'pages', (int) $this->get(3));

		$res = Response::getInstance();
		$res->redirect('/?admin/module/page');
	}

}

?>