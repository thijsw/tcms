<?php

/**
 * Storage of models
 *
 * @package tcms
 */
class Storage {

	private static $instance;
	private $models = array();
	
	private function __construct() {}

	public static function getInstance()
	{
		if (empty(self::$instance))
			self::$instance = new Storage();
		return self::$instance;
	}

	/**
	 * Load model
	 *
	 * @param string $class The class to be created
	 * @param int|array $id The specific id or data needed to fill this object is gathered elsewhere
	 * @return Model|null
   */
	public function load ($class, $id_data) {
		global $__module_file;

		$id = is_int($id_data) ? $id_data : (int) $id_data['id'];

		// Already loaded
		if (isset($this->models[$class][$id]))
			return $this->models[$class][$id];

		// Extract module en model name from class name and instantiate model
		list ($module, $model) = explode('_', $class);
		require_once sprintf($__module_file, 'module', 'model');
		require_once sprintf($__module_file, strtolower($module), strtolower($model));
		$this->models[$class][$id] = new $class;

		// Fill model with data either via the database or by using the array
		if (is_array($id_data))
			$data = $id_data;
		else {
			$db = Database::getInstance();
			$data = $db->get_row(sprintf('SELECT * FROM %s WHERE id = %d', strtolower($class), (int) $id));
		}

		if (!is_array($data)) {
			return null;
		}

		foreach ($data as $key => $value) {
			$this->models[$class][$id]->$key = $value;
		}

		return $this->models[$class][$id];
	}

	/**
	 * Delete model from database and internal cache
	 *
	 * @param Model $model The specific model to be deleted
	 * @return void
	 */
	public function delete (Model $model) {
		$db = Database::getInstance();
		$db->query(sprintf('DELETE FROM %s WHERE id = %d LIMIT 1', strtolower(get_class($model)), $model->id));
		unset($this->models[$class][$model->id]);
	}

}

?>