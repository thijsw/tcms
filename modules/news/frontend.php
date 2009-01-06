<?php

require_once 'modules/page/frontend.php';

class Frontend_News extends Frontend_Page {

	public $model_class = 'News_Item';

	public function index () {
		return STATUS_OK;
	}

	public function get_title () {
		return $this->item ? $this->item->title : 'Nieuws';
	}

}

?>