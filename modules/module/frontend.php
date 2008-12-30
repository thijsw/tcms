<?php

abstract class Frontend extends Module {

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