<?php

class Template {

	private static $instance;
	private $_smarty;
	
	private function __construct() {}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Template();
		return self::$instance;
	}

	public function render ($object, $type, $style)
	{
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
			throw new Exception_Core("Template file $file does not exist");
		}

		/* Assign component-specific template variables */
		$name = strtolower(substr(get_class($object), 7));
		$this->_smarty->template_dir = TCMS_PATH . '/modules/' . $name . '/frontend/';
		$this->_smarty->assign('rep', Repository::getInstance());
		$this->_smarty->assign('this', $object);

		return $this->_smarty->fetch($file);
	}

}

?>