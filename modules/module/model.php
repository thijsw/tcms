<?php

class Model {

	private $data;

	public function __construct () {
		$this->data = new ArrayObject();
	}

	public function getIterator () {
		return $this->data->getIterator();
	}

	public function __set ($key, $value) {
		return $this->data->offsetSet($key, $value);
	}

	public function __get ($key) {
		return $this->data->offsetExists($key) ? $this->data->offsetGet($key) : null;
	}

	public function url () {
		global $__mod_rewrite;
		$arguments = array();
		foreach (func_get_args() as $argument) {
			if (!is_null($argument)) $arguments[] = $argument;
		}
		return 'http://' . $_SERVER['HTTP_HOST'] . ($__mod_rewrite ? '/' : '/?') . implode($arguments, '/');
	}

	public function to_array () {
		return iterator_to_array($this->getIterator());
	}

}

?>