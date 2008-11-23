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

	public function to_array () {
		return iterator_to_array($this->getIterator());
	}

}

?>