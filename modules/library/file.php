<?php

require_once 'modules/page/page.php';

define ('IMAGE_MODE_MAX_WIDTH',		1);
define ('IMAGE_MODE_MAX_HEIGHT',	2);

class Library_File extends Page_Page {

	public function is_picture () {
		preg_match('/\.(png|jpe?g)$/i', $this->name, $matches);
		if (!isset($matches[1])) return false;
		return true;
	}

	function get_human_readable_filesize () {
		$sizes = array('YB', 'ZB', 'EB', 'PB', 'TB', 'GB', 'MB', 'kB', 'B');
		$total = count($sizes);
		$size  = $this->size;
		while ($total-- && $size > 1024) $size /= 1024;
		return sprintf('%.2f %s', $size, $sizes[$total]);
	}

	public function resize_picture ($size, $mode = IMAGE_MODE_MAX_WIDTH) {
		global $__uploads_path;
		if (!$this->is_picture()) return;

		$path   = $__uploads_path . DIRECTORY_SEPARATOR . $this->name;
		$n_path = $__uploads_path . DIRECTORY_SEPARATOR . md5($this->name . $mode . $size);

		if (file_exists($n_path)) {
			return file_get_contents($n_path);
		}

		$image  = imagecreatefrompng($path);

		list($width, $height) = getimagesize($path);

		switch ($mode) {
			case IMAGE_MODE_MAX_HEIGHT:
				$n_width = floor($size * $width / $height);
				$n_height = $size;
			break;
			case IMAGE_MODE_MAX_WIDTH:
			default:
				$n_width = $size;
				$n_height = floor($size * $height / $width);
			break;
		}

		$new = imagecreatetruecolor($n_width, $n_height);
		imagecopyresampled($new, $image, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
		imagejpeg($new, $n_path, 100);
		return file_get_contents($n_path);
	}

}

?>