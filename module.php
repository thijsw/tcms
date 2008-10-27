<?php

class Module {
	
	private $modules = array();
	
	/**
	 * Set reference to other modules
	 *
	 * @return void
	 */
	public function setModule (Module $module) {
		if (!in_array($module, $this->modules))
			$this->modules[] = $module;
	}
	
	protected function getModule ($name) {
		foreach ($this->modules as $module)
			if (substr(strtolower(get_class($module)), 7) == strtolower($name))
				return $module;
	}
	
}

?>