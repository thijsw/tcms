<?php

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

	public function set_get_params (array $segments) {
		$this->segments = $segments;
	}

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
		return substr(strtolower(get_class($this)), 7);
	}

	public function get_dependencies () {
		$rep = Repository::getInstance();
		return $rep->get_dependencies($this->get_module_name());
	}

	protected function frontend ($template) {
		require_once 'helpers/template.php';

		$file = sprintf(TCMS_PATH . '/modules/%s/frontend/%s.tpl', $this->get_module_name(), $template);

		if (!file_exists($file)) {
			throw new Exception_Core("Template file $file does not exist");
		}

		$tpl = Template::getInstance();
		return $tpl->render($this, $file);
	}

	public function backend ($template) {
		require_once 'helpers/template.php';

		$file = sprintf(TCMS_PATH . '/modules/%s/backend/%s.tpl', $this->get_module_name(), $template);

		if (!file_exists($file)) {
			$file = sprintf(TCMS_PATH . '/modules/module/backend/%s.tpl', $template);
		}

		$tpl = Template::getInstance();
		return $tpl->render($this, $file);
	}

	public function __toString () {
		return get_class($this);
	}

	public function get_css_link () {
		return '?css/view/' . $this->get_module_name();
	}
	
	public function get_icon_path () {
		global $__modules_path;
		if (file_exists(sprintf($__modules_path . '/%s/icon.png', $this->get_module_name())))
			return sprintf('modules/%s/icon.png', $this->get_module_name());
		else return 'modules/module/icon.png';
	}
}

?>