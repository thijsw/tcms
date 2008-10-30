<?php

class Module_Css extends Module {

	public function view () {
		global $__modules_path;

		$rep = Repository::getInstance();
		$req = Request::getInstance();

		if ($this->get(1) == false) {
			throw new Exception_HTTP(404);
		}

		if (($mod = $rep->load_module($req->get(1))) == false) {
			throw new Exception_HTTP(404);			
		}

		$res = Response::getInstance();
		$res->set_content_type('text/css');

		$css = '';
		foreach (array_merge($rep->get_dependencies($this->get(1)), array($mod)) as $module) {
			$d = opendir($dir = $__modules_path . '/' . $module->get_module_name() . '/css/');
			while (($file = readdir($d)) !== false) {
				if (substr($file, -4) == '.css') {
					$css .= "\n/* " . $dir . $file . " */\n";
					$css .= file_get_contents($dir . $file);
				}
			}
		}
		return $css;
	}

}

?>