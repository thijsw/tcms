<?php

require_once 'modules/page/frontend.php';

class Frontend_Column extends Frontend_Page {

	public $item;
	public $model_class = 'Column_Column';

	public function index () {}

	public function get_title () {
		return $this->item ? $this->item->title : 'Columns';
	}

	public function get_items ($offset = 0, $length = null) {
		static $items = array();
		if (empty($items)) {
			$rep = Repository::getInstance();
			$backend = $rep->load_backend('column');
			$items = $backend->get_all_items();
		}
		return array_slice($items, $offset, $length);
	}

}

?>