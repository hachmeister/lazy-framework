<?php

// set includes.
$includes = array('../app', '../lib');
set_include_path(implode(PATH_SEPARATOR, $includes));

// exception handling.
//error_reporting(E_ALL);
function exception_handler($errno, $errstr, $errfile, $errline ) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_handler");

// define autoload function.
function __autoload($className) {
	if (class_exists($className, false) || interface_exists($className, false)) {
		return;
	}

	require_once str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
}

?>