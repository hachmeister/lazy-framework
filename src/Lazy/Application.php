<?php

/** Application class
 *
 * @package Lazy
 */
class Lazy_Application {

	protected function createRequest($params) {
		$request = new Lazy_Http_DefaultRequest();

		// set scheme.
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			$request->setScheme('https');
		} else {
			$request->setScheme('http');
		}

		// set host.
		$request->setHost($_SERVER['HTTP_HOST']);

		// set port.
		$request->setPort($_SERVER['SERVER_PORT']);

		// set path.
		$uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$request->setPath($uriParts[0]);

		// set params.
		foreach (array('_GET', '_POST') as $arrays) {
			foreach ($GLOBALS[$arrays] as $name => $value) {
				$params[$name] = $value;
			}
		}
		$request->setParams($params);

		// set method.
		$request->setMethod($_SERVER['REQUEST_METHOD']);

		// echo '<pre>' . print_r($_SERVER, true) . '</pre>';
		// echo '<pre>' . print_r($request, true) . '</pre>';

		return $request;
	}

	protected function createResponse() {
		return new Lazy_Http_DefaultResponse();
	}

	private function displayErrorPage(Exception $e) {
		echo '<html>' . "\n";
		echo '<head>' . "\n";
		echo '	<title>' . get_class($e) . ': ' . $e->getMessage() . '</title>' . "\n";
		echo '	<style type="text/css">' . "\n";
		echo '		div.message { padding: 16px 20px; border: 1px solid #CCC; background-color: #FFE; }' . "\n";
		echo '		span.abbrev { color: #999; }' . "\n";
		echo '		span.class { font-weight: bold; }' . "\n";
		echo '		span.function { font-weight: bold; }' . "\n";
		echo '		span.null { color: #E00; }' . "\n";
		echo '		span.special { font-weight: bold; }' . "\n";
		echo '	</style>' . "\n";
		echo '</head>' . "\n";
		echo '<body>' . "\n";
		echo '<div class="message">' . "\n";
		echo '<b>' . get_class($e) . ': ' . $e->getMessage() . '</b>' . "\n";
		echo '<pre>' . "\n";

		echo '  in ' . $e->getFile() . '(' . $e->getLine() . ')' . "\n";

		foreach ($e->getTrace() as $line) {
			echo '  in ' . $line['file'] . '(' . $line['line'] . '): ';
			if (isset($line['class'])) {
				echo '<span class="class">' . $line['class']  . '</span>' . $line['type'];
			}
			echo '<span class="function">' . $line['function'] . '</span>';
			if (isset($line['args'])) {
				echo '(' . Lazy_Utils_ExceptionUtils::formatParams($line['args']) . ')';
			} else {
				echo '()';
			}
			echo "\n";
		}

		// echo $e->getTraceAsString();

		echo '</div>';
	}

	public function run() {
		try {
			// routing.
			$uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
			$connect = Lazy_Http_Dispatcher::dispatch($uriParts[0]);

			// create request/response objects.
			$request = $this->createRequest($connect['params']);
			$response = $this->createResponse();

			// call controller.
			require_once 'controllers/' . $connect['controller'] . '.php';
			$controller = new $connect['controller']();
			$controller->$connect['action']($request, $response);
		} catch (Exception $e) {
			$this->displayErrorPage($e);
		}
	}

}

?>