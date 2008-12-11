<?php

class Frontend_Homepage extends Frontend {

	public function get_title () {
		return 'Welkom bij de Studenten Organisatie Groningen (SOG)';
	}

	public function index () {
		return $this->render('view');
	}

}

?>