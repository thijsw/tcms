<?php

define ('STATUS_OK',											200);
define ('STATUS_BAD_REQUEST',							400);
define ('STATUS_AUTHORIZATION_REQUIRED',	401);
define ('STATUS_FORBIDDEN', 							403);
define ('STATUS_NOT_FOUND',								404);
define ('STATUS_INTERNAL_SERVER_ERROR',		500);

abstract class Module {

	private $package;
	private $modules = array();
	private $segments = array();
	protected $template = 'view';

	private function read_package () {
		if (!is_null($this->package)) return;

		list ($type, $module) = explode('_', strtolower(get_class($this)));

		global $__package_file;

		if (!file_exists($file = sprintf($__package_file, $module))) {
			throw new Exception_Core("Package file for module $module could not be found");
		}

		$this->package = new Package(file_get_contents($file));
	}

	public function get_dependencies ($type) {
		$this->read_package();
		$rep = Repository::getInstance();
		$modules = array();

		$method = 'load_' . $type;
		foreach ($this->package->get_dependencies() as $module) {
			if ($module = $rep->$method($module)) {
				$modules[] = $module;
			}
		}
		return $modules;
	}

	/**
	 * Set reference to other modules
	 *
	 * @return void
	 */
	public function set_module (Module $module) {
		if (!in_array($module, $this->modules))
			$this->modules[] = $module;
	}

	protected function get_module ($name) {
		foreach ($this->modules as $module)
			if ($this->get_module_name() == strtolower($name))
				return $module;
	}

	public function set_template ($template = 'view') {
		$this->template = $template;
		return $this;
	}

	public function get_template () {
		return $this->template;
	}

	/**
	 * Get all items which can be used in the Navigation module
	 *
	 * @return Multidimensional array
	 */
	public function get_all_public_items () {
		return array();
	}

	public function set_get_params (array $segments) {
		$this->segments = $segments;
	}

	/**
	 * Shortcut to Request::get()
	 *
	 * @return null|string
	 */
	public function get ($i) {
		$req = Request::getInstance();
		return $req->get($i);
	}

	public function is_system () {
		return $this->package->is_system();
	}

	public function get_module_title () {
		return $this->package->title;
	}

	public function get_module_name () {
		list ($type, $module) = explode('_', get_class($this));
		return strtolower($module);
	}

	public function __toString () {
		return get_class($this);
	}

	public function url () {
		global $__mod_rewrite;
		$arguments = array();
		foreach (func_get_args() as $argument) {
			if (!is_null($argument)) $arguments[] = $argument;
		}
		return 'http://' . $_SERVER['HTTP_HOST'] . ($__mod_rewrite ? '/' : '/?') . implode($arguments, '/');
	}

	public function get_css_link ($type = 'frontend') {
		return $this->url('css', $type, $this->get_module_name());
	}

	public function get_icon_path () {
		global $__modules_path;
		if (file_exists(sprintf($__modules_path . '/%s/icon.png', $this->get_module_name())))
			return sprintf('modules/%s/icon.png', $this->get_module_name());
		else return 'modules/module/icon.png';
	}
}

?>