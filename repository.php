<?php

require_once 'package.php';

class Repository {

	private static $instance;
	private $frontend = array();
	private $backend  = array();
	
	private function __construct() {}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Repository();
		return self::$instance;
	}

	public function get_all_modules ($type) {
		global $__modules_path;

		if (($d = opendir($__modules_path)) == false) {
			throw new Exception_Core("Modules directory is not accessible");
		}

		$modules = array();
		while (($file = readdir($d)) !== false) {
			if (filetype($__modules_path . '/' . $file) == 'dir' && strlen($file) > 2) {
				if ($module = $this->load_module($file, $type)) {
					$modules[] = $module;
				}
			}
		}

		return $modules;
	}

	public function load_frontend ($module) {
		return $this->load_module($module, 'frontend');		
	}

	public function load_backend ($module) {
		return $this->load_module($module, 'backend');
	}

	private function load_module ($module, $type) {
		global $__module_file;

		// module 'module' must not be instantiated
		if ($module == 'frontend' || $module == 'backend' || $module == 'module') return;

		// already loaded
		if (isset($this->{$type}[$module]))
			return $this->{$type}[$module];

		// require abstract module class
		require_once sprintf($__module_file, 'module', 'module');

		// require abstract frontend and backend classes
		require_once sprintf($__module_file, 'module', $type);

		if (!file_exists($file = sprintf($__module_file, $module, $type))) {
			return; // not found.
		} else {
			require_once $file;
		}

		// get dependencies for this module
		$deps = $this->get_dependencies($module, $type);

		// instantiate object
		$class = ucfirst($type) . '_' . ucfirst($module);
		$this->{$type}[$module] = new $class($this->read_package($module));

		// add dependencies to reference in this module
		foreach ($deps as $object) {
			$this->{$type}[$module]->set_module($object);
		}

		return $this->{$type}[$module];
	}

	public function get_dependencies ($module, $type) {
		$package = $this->read_package($module);
		$modules = array();
		foreach ($package->get_dependencies() as $module) {
			if ($module = $this->load_module($module, $type)) {
				$modules[] = $module;
			}
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