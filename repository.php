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

		// instantiate object
		$class = ucfirst($type) . '_' . ucfirst($module);
		$obj = $this->{$type}[$module] = new $class();

		// add dependencies to reference in this module
		foreach ($obj->get_dependencies($type) as $object) {
			$obj->set_module($object);
		}

		return $obj;
	}

}

?>