<?php

setlocale (LC_ALL, 'nl_NL');

require_once 'config.php';
require_once 'exception/core.php';
require_once 'exception/http.php';
require_once 'helpers/repository.php';
require_once 'helpers/request.php';
require_once 'helpers/response.php';
require_once 'helpers/database.php';
require_once 'helpers/storage.php';
require_once 'helpers/authentication.php';
require_once 'helpers/template.php';

class TCms {

	public function __construct () {
		$req = Request::getInstance();
		$rep = Repository::getInstance();
		$res = Response::getInstance();

		// call method
		if (method_exists($module = $rep->load_frontend($req->get_module()), $method = $req->get_method())) {
			$status = $module->$method(count($_POST) > 0 ? $_POST : null);
		} else $status = 404;

		// not 200 OK status, override module with error frontend
		if ($status !== 200 && $status !== null) {
			$module = $rep->load_frontend('error');
			$module->set_status($status);
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