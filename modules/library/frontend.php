<?php

class Frontend_Library extends Frontend {

	protected $data;

	public function index () {
		return STATUS_NOT_FOUND;
	}

	public function download () {
		if ($this->get(1) < 1) return STATUS_NOT_FOUND;
		$this->id = (int) $this->get(1);

		$storage = Storage::getInstance();
		if (($file = $storage->load('Library_File', $this->id)) === null) {
			return STATUS_NOT_FOUND;
		}

		Template::getInstance()->set_render(false);

		global $__uploads_path;
		if (file_exists($path = $__uploads_path . DIRECTORY_SEPARATOR . $file->name) === false) {
			throw new Exception_Core("File $path could not be found on disk");
		}

		$res = Response::getInstance();
		$res->set_content_type($file->mimetype);
		$res->set_header('Content-Length', $file->size);
		$res->set_header('Content-Disposition', sprintf('attachment; filename="%s"', $file->name));

		$this->data = file_get_contents($path);

		return STATUS_OK;
	}

	public function render () {
		return $this->data;
	}

}

?>