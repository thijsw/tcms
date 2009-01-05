<?php

class Template {

	private static $instance;
	private $_smarty;
	private $render = true;
	private $values = array();

	private function __construct() {}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Template();
		return self::$instance;
	}

	public function set_render ($yesorno = true) {
		$this->render = $yesorno;
	}

	// no overloading method, because Smarty isn't able to write to attributes directly
	public function set ($name, $value) {
		$this->values[$name] = $value;
	}

	public function __get ($name) {
		return isset($this->values[$name]) ? $this->values[$name] : null;
	}

	public function render ($object, $type, $style)
	{
		if ($this->render === false) return;
		require_once TCMS_PATH . '/libraries/smarty/Smarty.class.php';
		$this->_smarty = new Smarty();
		$this->_smarty->compile_dir = TCMS_PATH . '/tmp';

		/* Define all possible templates, following class hierarchy */
		$class = get_class($object);
		do {
			preg_match('/^([^_]+)_?([^_]+)?$/', $class, $matches);
			$folder = isset($matches[2]) ? $matches[2] : $matches[1];
			$file = sprintf(TCMS_PATH . '/modules/%s/%s/%s.tpl', strtolower($folder), $type, $style);
			if (file_exists($file))
				break;
			$file = null;
		} while ($class = get_parent_class($class));

		if (is_null($file)) {
			return "<!-- No appropriate template found for '$object' with style '$style' -->";
		}

		/* Assign component-specific template variables */
		$name = strtolower(substr(get_class($object), 7));
		$this->_smarty->template_dir = TCMS_PATH . '/modules/' . $name . '/frontend/';

		$auth = Authentication::getInstance();
		$this->_smarty->assign('tpl', $this); // object to assign variables to that are being used by multiple templates
		$this->_smarty->assign('user', $auth->get_user());
		$this->_smarty->assign('rep', Repository::getInstance());
		$this->_smarty->assign('this', $object);

		return $this->_smarty->fetch($file);
	}

}

?>