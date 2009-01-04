<?php

require_once 'modules/page/page.php';

define ('IMAGE_MODE_MAX_WIDTH',		1);
define ('IMAGE_MODE_MAX_HEIGTH',	2);

class Library_File extends Page_Page {

	public function is_picture () {
		preg_match('/\.(png|jpe?g)$/i', $this->name, $matches);
		if (!isset($matches[1])) return false;
		return true;
	}

}

?>