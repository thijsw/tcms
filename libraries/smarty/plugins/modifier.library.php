<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * TCMS Library plugin
 *
 * Type:     modifier<br>
 * Name:     library<br>
 * Purpose:  Convert library to images and so on
 * @author   Thijs Wijnmaalen
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_library($string)
{
	// Syntax: {file.jpg,l,120}
	return preg_replace_callback('/\{([a-z0-9_-\s]+\.j?pn?g),(l|r),(\d+)\}/i', 'html_library_items', $string);
}

function html_library_items ($matches) {
	$rep = Repository::getInstance();
	$backend = $rep->load_backend('library');
	$file = $backend->get_file_by_name($matches[1]);

	if (!$file)
		return "<strong>[FILE {$matches[1]} NOT FOUND]</strong>";

	if (!$file->is_picture())
		return "<strong>[FILE {$matches[1]} IS NOT AN IMAGE]</strong>";

	$class = $matches[2] == 'l' ? 'left' : 'right';

	return '<img src="' . $backend->url($backend->get_module_name(), 'view_image', $file->id, 'w', $matches[3]) . '" class="' . $class . '" />';
}

/* vim: set expandtab: */

?>