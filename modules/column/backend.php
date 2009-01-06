<?php

require_once 'modules/page/backend.php';

class Backend_Column extends Backend_Page {

	public $model_name = 'column';
	public $model_class = 'Column_Column';

	public function get_all_items () {
		$db = Database::getInstance();
		$rows = $db->get_rows(sprintf("SELECT * FROM %s ORDER BY submission DESC", strtolower($this->model_class)));
		if (!$rows) return array();
		$items = array();
		$storage = Storage::getInstance();
		foreach ($rows as $row) {
			$items[] = $storage->load($this->model_class, $row);
		}
		return $items;
	}

	public function get_title () {
		return 'Lijst met columns';
	}

	public function create ($data) {
		if ($data) {
			$data['submission'] = date('Y-m-d H:i:s');
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
			$data['submission'] = $this->item->submission;
			$this->item = $storage->save($this->item, $data);
		}

		$this->set_template('edit');
	}

	public function get_public_items () {
		$items = array();
		$items[] = array(
			'module' => $this->get_module_name(),
			'method' => '',
			'param' => '',
			'title' => 'Overzicht van columns',
			'enabled' => 1
			);
		return array_merge($items, parent::get_public_items());
	}

}

?>
