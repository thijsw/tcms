<?php

require_once 'config.php';
require_once 'repository.php';
require_once 'request.php';
require_once 'response.php';
require_once 'database.php';
require_once 'storage.php';
require_once 'exception/core.php';
require_once 'exception/http.php';

class TCms {
	
	public function __construct () {
		$req = Request::getInstance();
		$rep = Repository::getInstance();
		$res = Response::getInstance();

		// call method
		if (!method_exists($module = $rep->load_frontend($req->get_module()), $method = $req->get_method())) {
			$status = 404;
			$module = $rep->load_frontend('error');
		} else {
			$status = $module->$method(count($_POST) > 0 ? $_POST : null);
		}

		$res->set_status($status);
		$res->echo_headers();
		echo $module->render($module->get_template());
	}

}

try {
	new TCms ();
} catch (Exception $e) {
	echo "<strong>TCMS " . str_replace('_', ' ', get_class($e)) . "</strong> :: " . $e->getMessage();
}


?>