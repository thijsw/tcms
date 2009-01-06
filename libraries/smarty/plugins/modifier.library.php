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
	// Inline images, syntax: {file.jpg,l,120}
	$string = preg_replace_callback('/\{([a-z0-9_-\s]+\.j?pn?g),(l|r),(\d+)\}/i', 'html_library_images', $string);

	// Other file types will be presented as downloads, syntax: {file.zip}
	$string = preg_replace_callback('/\{([a-z0-9_-\s]+\.[a-z]{3,4})\}/i', 'html_library_downloads', $string);

	return $string;
}

function html_library_downloads ($matches) {
	$rep = Repository::getInstance();
	$backend = $rep->load_backend('library');
	$file = $backend->get_file_by_name($matches[1]);

	if (!$file)
		return "<strong>[FILE {$matches[1]} NOT FOUND]</strong>";

	return sprintf('<p>Download <a href="%s">%s (%s)</a></p>',
		$backend->url($backend->get_module_name(), 'download', $file->id),
		$file->title,
		$file->get_human_readable_filesize()
	);
}

function html_library_images ($matches) {
	$rep = Repository::getInstance();
	$backend = $rep->load_backend('library');
	$file = $backend->get_file_by_name($matches[1]);

	if (!$file)
		return "<strong>[FILE {$matches[1]} NOT FOUND]</strong>";

	if (!$file->is_picture())
		return "<strong>[FILE {$matches[1]} IS NOT AN IMAGE]</strong>";

	$class = $matches[2] == 'l' ? 'left' : 'right';

	return sprintf(
		'<img src="%s" class="%s" title="%s" />',
		$backend->url($backend->get_module_name(), 'view_image', $file->id, 'w', $matches[3]),
		$class,
		$file->title
	);
}

/* vim: set expandtab: */

?>