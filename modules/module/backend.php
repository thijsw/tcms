<?php

abstract class Backend extends Module {

	public function index () {
		return $this->render('overview');
	}

	public function render ($style) {
		require_once 'helpers/template.php';
		$tpl = Template::getInstance();
		return $tpl->render($this, 'backend', $style);
	}

}

?>