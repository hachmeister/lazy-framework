<?php

/**
 *
 * @package Lazy\Http
 */
class Lazy_Http_Dispatcher {

	private static $base = '';

	private static $routes = array();

	public static function connect($route, $controller, $action = 'index') {
		$connect = array();
		$connect['controller'] = $controller;
		$connect['action'] = $action;
		self::$routes[$route] = $connect;
	}

	public static function urlTo($controller, $action = 'index', $params = array()) {
		foreach (self::$routes as $route => $connect) {
			if ($connect['controller'] == $controller && $connect['action'] == $action) {
				foreach ($params as $name => $value) {
					$route = str_replace(':' . $name, $value, $route);
				}
				return self::$base . '/' . $route;
			}
		}
		throw new Exception('No matching connect for [controller => ' . $controller . ', action => ' . $action . ']');
	}

	public static function dispatch($path) {
		$params = array();
		$pathParts = explode('/', ltrim(substr($path, strlen(self::$base)), '/'));
		// echo '<pre>' . print_r($pathParts, true) . '</pre>';
		$pathPartsCount = count($pathParts);
		foreach (self::$routes as $route => $connect) {
			$routeParts = explode('/', $route);
			// echo '<pre>' . print_r($routeParts, true) . '</pre>';
			$routePartsCount = count($routeParts);
			$routeMatches = true;
			for ($i = 0; $i < $routePartsCount; $i++) {
				if ($routeParts[$i] == '*') {
					break;
				} elseif (($routePartsCount - 1) == $i && $routePartsCount < $pathPartsCount ) {
					$routeMatches = false;
					break;
				} elseif (!isset($pathParts[$i])) {
					$routeMatches = false;
					break;
				} elseif (substr($routeParts[$i], 0, 1) == ':') {
					$params[substr($routeParts[$i], 1)] = $pathParts[$i];
					continue;
				} elseif ($routeParts[$i] != $pathParts[$i]) {
					$routeMatches = false;
					break;
				}
			}
			if ($routeMatches) {
				// echo "<pre>'" . $path . "' matches to route '" . $route . "' and connects to [controller => " . $connect['controller'] . ", action => " . $connect['action'] . "]</pre>";
				// echo '<pre>' . print_r($params, true) . '</pre>';
				return array(
					'controller' => $connect['controller'],
					'action' => $connect['action'],
					'params' => $params
				);
			}
		}
		throw new Exception('No matching route for [path => ' . $path . ']');
	}

	public static function setBase($base) {
		self::$base = $base;
	}

}

?>