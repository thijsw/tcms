<?php

require_once 'modules/homepage/frontend.php';

class Frontend_Page extends Frontend_Homepage {

	public $item;
	public $model_class = 'Page_Page';

	public function view () {
		$storage = Storage::getInstance();
		if (($this->item = $storage->load($this->model_class, (int) $this->get(1))) === false)
			return STATUS_NOT_FOUND;
		if ($this->item->enabled === 0)
			return STATUS_NOT_FOUND;
	}

	public function index () {
		return STATUS_NOT_FOUND;
	}

	public function get_items ($offset = 0, $length = null) {
		static $items = array();
		if (empty($items)) {
			$rep = Repository::getInstance();
			$backend = $rep->load_backend($this->get_module_name());
			$items = $backend->get_all_items();
		}
		if (is_null($length))
			return $items;
		return array_slice($items, $offset, $length);
	}

	public function get_title () {
		return $this->item ? $this->item->title : '(Naamloos)';
	}

}

?>