<?php

require_once 'modules/page/backend.php';

class Backend_News extends Backend_Page {

	public $model_name = 'item';
	public $model_class = 'News_Item';

	public function get_title () {
		return 'Lijst met nieuwsberichten';
	}

	public function get_public_items () {
		$items = array();
		$items[] = array(
			'module' => $this->get_module_name(),
			'method' => '',
			'param' => '',
			'title' => 'Nieuws',
			'enabled' => 1
			);
		return array_merge($items, parent::get_public_items());
	}

}

?>