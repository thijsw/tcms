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

	public function render ($object, $file)
	{
		require_once TCMS_PATH . '/libraries/smarty/Smarty.class.php';
		$this->_smarty = new Smarty();
		$this->_smarty->compile_dir = TCMS_PATH . '/tmp';

		/* Assign component-specific template variables */
		$name = strtolower(substr(get_class($object), 7));
		$this->_smarty->template_dir = TCMS_PATH . '/modules/' . $name . '/frontend/';
		$this->_smarty->assign('rep', Repository::getInstance());
		$this->_smarty->assign('this', $object);

		return $this->_smarty->fetch($file);
	}

}

?>