<?php

abstract class Frontend extends Module {

	public function get_title () {
		return get_class($this);
	}

	public function index () {
		return STATUS_OK;
	}

	public function render ($style = 'view') {
		require_once 'helpers/template.php';
		$tpl = Template::getInstance();
		return $tpl->render($this, 'frontend', $style);
	}

}

?>