<?php

class Package {
	
	private $xml;
	
	public function __construct ($xml) {
		$this->xml = new SimpleXMLElement($xml);
	}

	public function __get ($name) {
		return $this->xml->$name;
	}

	public function is_system () {
		return $this->xml['system'] == "true";
	}

	public function get_dependencies () {
		$dependencies = array();
		foreach ($this->xml->xpath('//dependencies/module') as $module) {
			$dependencies[] = strtolower((string) $module);
		}
		return $dependencies;
	}
	
}

?>