<?php

class Page_Page extends Model {

	private $_author = null;

	/**
	 * Function to set Author from the outside (performance reasons)
	 *
	 * @return void
	 */
	public function set_author (Module_Author $author) {
		$this->_author = $author;
	}

	/**
	 * Get associated Author object, which is either set via set_author() or loaded from Storage
	 *
	 * @return Module_Author
	 */
	public function get_author () {
		if (($this->_author instanceof Module_Author) === false) {
			$storage = Storage::getInstance();
			$this->_author = $storage->load('Module_Author', $this->author);
		}
		return $this->_author;		
	}

}

?>