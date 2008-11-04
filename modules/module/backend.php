<?php

abstract class Backend extends Module {

	public function render ($template) {
		require_once 'helpers/template.php';

		$file = sprintf(TCMS_PATH . '/modules/%s/backend/%s.tpl', $this->get_module_name(), $template);

		if (!file_exists($file)) {
			$file = sprintf(TCMS_PATH . '/modules/module/backend/%s.tpl', $template);
		}

		$tpl = Template::getInstance();
		return $tpl->render($this, $file);
	}

}

?>