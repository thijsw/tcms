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

	public function __construct(Package $package) {
		$this->package = $package;
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
		return strtolower($this->package->title);
	}

	public function get_dependencies () {
		$rep = Repository::getInstance();
		return $rep->get_dependencies($this->get_module_name());
	}

	public function __toString () {
		return get_class($this);
	}

	public function get_css_link ($type = 'frontend') {
		return '?css/' . $type . '/' . $this->get_module_name();
	}

	public function get_icon_path () {
		global $__modules_path;
		if (file_exists(sprintf($__modules_path . '/%s/icon.png', $this->get_module_name())))
			return sprintf('modules/%s/icon.png', $this->get_module_name());
		else return 'modules/module/icon.png';
	}
}

?>