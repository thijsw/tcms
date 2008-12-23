<?php

require_once 'modules/homepage/frontend.php';

class Frontend_Error extends Frontend_Homepage {

	private $status;

	public function get_title () {
		switch ($this->status) {
			case 404: return 'Pagina niet gevonden';
			case 500: return 'Onbekende interne fout';
			default:  return 'Onbekende fout opgetreden';
		}
	}

	public function get_status () {
		return $this->status;
	}

	public function set_status ($status) {
		$this->status = $status;
	}

}

?>