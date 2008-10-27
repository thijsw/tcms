<?php

require_once 'config.php';
require_once 'package.php';
require_once 'exception/core.php';
require_once 'exception/http.php';

class TCms {

	private $_segments = array();
	
	public function __construct () {
		global $__default_module, $__default_method;

		// match either /foo/bar, index.php?foo/bar or /?foo/bar
		preg_match('/^(\/index\.php\?)?(\/\?)?(.*)$/', $_SERVER['REQUEST_URI'], $matches);

		// store segments, first one is name of module
		$this->_segments = explode('/', empty($matches[3]) ? $__default_module : $matches[3]);

		// load module and its dependencies
		$this->load_module($module = $this->_segments[0]);
		
		// call method
		$method = empty($this->_segments[1]) ? $__default_method : $this->_segments[1];
		if (method_exists($this->$module, $method)) {
			$this->$module->$method();
		} else {
			throw new Exception_HTTP(404);
		}

	}

	public function load_module ($module) {
		global $__module_file;

		if (!file_exists($file = sprintf($__module_file, $module))) {
			throw new Exception_Core("Requested module $module could not be found");
		} else {
			require_once $file;
		}

		$this->get_dependencies($module);
		$class = 'Module_' . ucfirst($module);
		$this->$module = new $class;
	}
	
	public function test_dependencies () {
		
	}

	public function get_dependencies ($module) {
		$package = $this->read_package($module);
		foreach ($package->get_dependencies() as $module) {
			$this->load_module($module);
		}
	}

	public function read_package ($module) {
		global $__package_file;

		if (!file_exists($file = sprintf($__package_file, $module))) {
			throw new Exception_Core("Package file for module $module could not be found");
		}

		return new Package(file_get_contents ($file));
	}

}

try {
	new TCms ();
} catch (Exception $e) {
	echo "<strong>" . str_replace('_', ' ', get_class($e)) . "</strong> :: " . $e->getMessage();
}


?>