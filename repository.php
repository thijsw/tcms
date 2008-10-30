<?php

require_once 'package.php';

class Repository {

	private static $instance;
	
	private function __construct() {}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Repository();
		return self::$instance;
	}

	public function get_all_modules () {
		global $__modules_path;

		if (($d = opendir($__modules_path)) == false) {
			throw new Exception_Core("Modules directory is not accessible");
		}

		$modules = array();
		while (($file = readdir($d)) !== false) {
			if (filetype($__modules_path . '/' . $file) == 'dir' && strlen($file) > 2) {
				if ($module = $this->load_module($file)) {
					$modules[] = $module;
				}
			}
		}

		return $modules;
	}

	public function load_module ($module) {
		global $__module_file;

		// module 'module' must not be instantiated
		if ($module == 'module') return;

		// already loaded
		if (isset($this->$module))
			return $this->$module;

		// include the 'abstract' module file first
		require_once sprintf($__module_file, 'module');

		if (!file_exists($file = sprintf($__module_file, $module))) {
			throw new Exception_Core("Requested module $module could not be found");
		} else {
			require_once $file;
		}

		// get dependencies for this module
		$deps = $this->get_dependencies($module);

		// instantiate object
		$class = 'Module_' . ucfirst($module);
		$this->$module = new $class($this->read_package($module));

		// add dependencies to reference in this module
		foreach ($deps as $object) {
			$this->$module->set_module($object);
		}
		
		return $this->$module;
	}

	public function get_dependencies ($module) {
		$package = $this->read_package($module);
		$modules = array();
		foreach ($package->get_dependencies() as $module) {
			$this->load_module($module);
			$modules[] = $this->$module;
		}
		return $modules;
	}

	/**
	 * Get package for module
	 *
	 * @param string $module
	 * @return Package
	 */
	public function read_package ($module) {
		global $__package_file;

		if (!file_exists($file = sprintf($__package_file, $module))) {
			throw new Exception_Core("Package file for module $module could not be found");
		}

		return new Package(file_get_contents($file));
	}

}

?>