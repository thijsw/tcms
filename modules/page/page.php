<?php

class Module_Page extends Module {

	public $page;

	public function _get_all_pages () {
		$db = Database::getInstance();
		return $db->get_rows("select p.*, u.name_first, u.name_last from page_pages p left join users u on u.id=p.author order by p.id");
	}

	public function _get_page ($id) {
		$db = Database::getInstance();
		return $db->get_row(sprintf("select * from page_pages where id = %d", $id));
	}

	public function index () {
		echo 'list pages';
	}

	public function view () {
		var_dump($this);
		echo 'view page';
	}

	public function create ($data) {
		if ($data) {
			$data['enabled'] = $data['enabled'] ? 1 : 0;
			$data['author'] = 1;
			//$data['created'] = time();
			$db = Database::getInstance();
			$id = $db->insert($this, 'pages', $data);
			$this->page = $this->_get_page($id);
		}
		return $this->backend('edit');
	}

	public function edit ($data) {
		if (($this->page = $this->_get_page($this->get(3))) == false) {
			throw new Exception_HTTP(404);
		}

		if ($data) {
			$data['enabled'] = $data['enabled'] ? 1 : 0;
			$db = Database::getInstance();
			$db->update($this, 'pages', $this->get(3), $data);
			// update info
			$this->page = $this->_get_page($this->get(3));
		}

		return $this->backend('edit');
	}

}

?>