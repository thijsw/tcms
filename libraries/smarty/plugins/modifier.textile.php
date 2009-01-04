<?php

require_once TCMS_PATH . '/libraries/textile/textile.class.php';

function smarty_modifier_textile($string)
{
		static $textile = null;
		if (is_null($textile))
			$textile = new Textile();
		return $textile->TextileThis($string);
}

?>