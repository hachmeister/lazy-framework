<?php

/**
 *
 * @package Lazy\Mvc
 */
class Lazy_Mvc_Controller {

	protected function redirectTo($controller, $action = 'index', $params = array()) {
		header('Location: ' . Lazy_Http_Dispatcher::urlTo($controller, $action, $params));
		exit;
	}

	protected function render($viewname, $model = array()) {
		$view = new Lazy_Mvc_View($viewname);
		echo $view->render($model);
	}

}

?>