<?php

abstract class Frontend extends Module {

	public function get_title () {
		return get_class($this);
	}

	public function render ($style) {
		require_once 'helpers/template.php';
		$tpl = Template::getInstance();
		return $tpl->render($this, 'frontend', $style);
	}

}

?>