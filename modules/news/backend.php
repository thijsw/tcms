<?php

require_once 'modules/page/backend.php';

class Backend_News extends Backend_Page {

	public $model_name = 'item';
	public $model_class = 'News_Item';

	public function get_title () {
		return 'Lijst met nieuwsberichten';
	}

}

?>