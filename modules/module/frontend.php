<?php

abstract class Frontend extends Module {

	public function render ($template) {
		require_once 'helpers/template.php';

		$file = sprintf(TCMS_PATH . '/modules/%s/frontend/%s.tpl', $this->get_module_name(), $template);

		if (!file_exists($file)) {
			throw new Exception_Core("Template file $file does not exist");
		}

		$tpl = Template::getInstance();
		return $tpl->render($this, $file);
	}

}

?>