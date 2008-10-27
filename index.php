<?php

require_once 'config.php';
require_once 'package.php';
require_once 'exception/core.php';

class TCms {

	private $_segments = array();
	
	public function __construct () {
		global $__default_module;

		// match either /foo/bar, index.php?foo/bar or /?foo/bar
		preg_match('/^(\/index\.php\?)?(\/\?)?(.*)$/', $_SERVER['REQUEST_URI'], $matches);

		// store segments, first one is name of module
		$module = empty($matches[3]) ? $__default_module : $matches[3];
		$this->_segments = explode('/', $module);

		// load module and its dependencies
		$this->load_module($this->_segments[0]);
	}

	public function load_module ($module) {
		global $__module_file;

		if (!file_exists(sprintf($__module_file, $module))) {
			throw new Exception_Core("Requested module $module could not be found");
		}
		
		$this->get_dependencies($module);
		

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
	echo "<strong>TCms Exception</strong> :: " . $e->getMessage();
}


?>