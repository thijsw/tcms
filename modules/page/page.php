<?php

class Page_Page extends Model {

	private $author = null;

	/**
	 * Function to set Author from the outside (performance reasons)
	 *
	 * @return void
	 */
	public function set_author (Module_Author $author) {
		$this->author = $author;
	}

	/**
	 * Get associated Author object, which is either set via set_author() or loaded from Storage
	 *
	 * @return Module_Author
	 */
	public function get_author () {
		if (($this->author instanceof Model) === false) {
			$storage = Storage::getInstance();
			$this->author = $storage->load('Module_Author', $this->author);
		}
		return $this->author;
	}

}

?>