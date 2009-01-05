<?php

require_once 'modules/page/frontend.php';

class Frontend_Column extends Frontend_Page {

	public $item;
	public $model_class = 'Column_Column';

	public function index () {}

	public function get_title () {
		return $this->item ? $this->item->title : 'Geen titel';
	}

}

?>