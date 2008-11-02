<?php

require_once 'config.php';
require_once 'repository.php';
require_once 'request.php';
require_once 'response.php';
require_once 'database.php';
require_once 'exception/core.php';
require_once 'exception/http.php';

class TCms {
	
	public function __construct () {
		$req = Request::getInstance();
		$rep = Repository::getInstance();
		$res = Response::getInstance();

		// load module and its dependencies
		$module = $rep->load_module($req->get_module());

		// call method
		$method = $req->get_method();
		if (method_exists($module, $method)) {
			echo $module->$method();
			$res->echo_headers();
		} else {
			throw new Exception_HTTP(404);
		}
	}

}

try {
	new TCms ();
} catch (Exception $e) {
	echo "<strong>TCMS " . str_replace('_', ' ', get_class($e)) . "</strong> :: " . $e->getMessage();
}


?>