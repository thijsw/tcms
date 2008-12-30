<?php

require_once 'modules/navigation/backend.php';

class Backend_Library extends Backend_Navigation {

	protected $image_class = 'Library_Image';
	protected $class_item = 'Library_Folder';

/*
	public function get_images () {
		$storage = Storage::getInstance();
		$db = Database::getInstance();
		$data = $db->get_rows(sprintf("SELECT * FROM %s ORDER BY created", strtolower($this->image_class)));
		if (is_array($data))
			return $storage->load_multiple($this->image_class, $data);
		else return array();
	}
*/

	public function get_folders () {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$rows = $db->get_rows(sprintf('SELECT * FROM %s WHERE parent IS NULL ORDER BY title', strtolower($this->class_item)));
		return $storage->load_multiple($this->class_item, $rows);
	}

	public function create ($data) {
		$this->set_template('edit');
		if ($data) {
			if (isset($_FILES)) {
				$this->store_file($data, $_FILES['upload']);
			}

		}
	}

	public function add_item ($data) {
		$this->set_template('add_item');

		if ($this->get(3) > 0)
			$this->id = (int) $this->get(3);

		if ($data) {
			$db = Database::getInstance();
			$data['parent'] = isset($this->id) ? $this->id : null;
			if ($this->id)
				$data['sort'] = $db->get_one(sprintf("SELECT IFNULL(MAX(sort)+1, 1) FROM library_folder WHERE parent = %d", $this->id));
			else
				$data['sort'] = $db->get_one("SELECT IFNULL(MAX(sort)+1, 1) FROM library_folder WHERE parent IS NULL");
			$db = Database::getInstance();
			$db->insert($this, 'folder', $data);
			$res = Response::getInstance();
			$res->redirect($this->url('admin', 'module', $this->get_module_name()));
		}
	}

	private function store_file ($data, $file) {
		global $__uploads_path;

		if (!is_array($file))
			throw new Exception_Core("No image upload found");

		if (!is_writable($__uploads_path))
			throw new Exception_Core("Upload path $__uploads_path isn't writable by the server user");

		$row = array();
		foreach (array('name', 'size', 'name', 'mimetype') as $key)
			$row[$key] = isset($file[$key]) ? $file[$key] : '';

		$row['title'] = isset($data['title']) ? $data['title'] : '';
		unset($data['class']);

		$location = $__uploads_path . DIRECTORY_SEPARATOR . basename($file['name']);
		if (!move_uploaded_file($file['tmp_name'], $location)) {
			throw new Exception_Core("File couldn't be saved");
		}

		chmod($location, 0644);

	}

}

?>