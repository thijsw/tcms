<?php

require_once 'modules/navigation/backend.php';

class Backend_Library extends Backend_Navigation {

	protected $class_file = 'Library_File';
	protected $class_item = 'Library_Folder';

	public function get_folders () {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$id = $db->get_one(sprintf('SELECT id FROM %s WHERE parent IS NULL LIMIT 1', strtolower($this->class_item)));
		$root = $storage->load($this->class_item, (int) $id);
		return $root ? $root->get_children() : array();
	}

	public function get_file_by_name ($name) {
		$db = Database::getInstance();
		$storage = Storage::getInstance();
		$id = $db->get_one(sprintf("SELECT id FROM %s WHERE name = '%s' LIMIT 1", strtolower($this->class_file), $name));
		return $id ? $storage->load($this->class_file, (int) $id) : null;
	}

	public function list_contents () {
		if (!$this->get(3)) return STATUS_NOT_FOUND;

		$this->id = (int) $this->get(3);
		$storage = Storage::getInstance();
		if (($this->folder = $storage->load($this->class_item, $this->id)) === null)
			return STATUS_NOT_FOUND;

		$this->set_template('list_contents');
		$this->set_title($this->folder->title);

		$db = Database::getInstance();
		$rows = $db->get_rows(sprintf('SELECT p.*, u.id author FROM %s p LEFT JOIN module_author u on u.id = p.author WHERE folder = %d ORDER BY title', strtolower($this->class_file), $this->id));

		$this->contents = array();
		if (!$rows) return;

		foreach ($rows as $row) {
			$file = $storage->load($this->class_file, $row);
			$author = $storage->load('Module_Author', $row['author']);
			$file->set_author($author);
			$this->contents[] = $file;
		}
	}

	public function create ($data) {
		$this->set_template('edit');
		if ($data) {
			if (isset($_FILES)) {
				$this->store_file($data, $upload = $_FILES['upload']);
			} else {
				throw new Exception_Core("File upload failed");
			}

			$row = array();
			foreach (array('title', 'folder') as $key) {
				$row[$key] = isset($data[$key]) ? $data[$key] : '';
			}

			$row['author'] = Authentication::getInstance()->get_user()->id;
			$row['created'] = date('Y-m-d H:i:s');
			$row['size'] = isset($upload['size']) ? $upload['size'] : 0;
			$row['mimetype'] = isset($upload['type']) ? $upload['type'] : 'text/plain';
			$row['name'] = isset($upload['name']) ? $upload['name'] : '';

			$db = Database::getInstance();
			$db->insert($this, 'file', $row);

			$res = Response::getInstance();
			$res->redirect($this->url('admin', 'module', $this->get_module_name(), 'list_contents', $row['folder']));
		}
	}

	public function add_item ($data) {
		$this->set_template('add_item');

		if ($this->get(3) > 0)
			$this->id = (int) $this->get(3);
		else return STATUS_NOT_FOUND;

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

	public function upload_file () {
		$this->set_template('upload_file');

		if ($this->get(3) > 0)
			$this->id = (int) $this->get(3);
		else return STATUS_NOT_FOUND;

		$storage = Storage::getInstance();
		if (($this->folder = $storage->load($this->class_item, $this->id)) === null)
			return STATUS_NOT_FOUND;

	}

	private function store_file ($data, $file) {
		global $__uploads_path;

		if (!is_array($file))
			throw new Exception_Core("No file upload found");

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