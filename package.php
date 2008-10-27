<?php

class Package {
	
	public function __construct ($xml) {
		$this->xml = new SimpleXMLElement($xml);
	}

	public function get_author () {
		return $this->xml->author;
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