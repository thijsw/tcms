<?php

abstract class Backend extends Module {

	public function index () {
		$this->set_template('overview');
	}

	public function render ($style = 'overview') {
		require_once 'helpers/template.php';
		$tpl = Template::getInstance();
		return $tpl->render($this, 'backend', $style);
	}

	public function get_edit_link () {
		return $this->url('admin', 'module', $this->get_module_name(), ($this->item ? 'edit' : 'create'), ($this->item ? $this->item->id : null));
	}

	public function get_public_items () {
		return array();
	}

}

?>