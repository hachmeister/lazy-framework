<?php

/**
 *
 * @package Lazy\Http
 */
class Lazy_Http_DefaultSession implements Lazy_Http_Session {

	public function __construct() {
		session_start();
	}

	public function id($id) {
		return session_id();
	}

	public function removeValue($name) {
		unset($_SESSION[$name]);
	}

	public function setValue($name, $value) {
		$_SESSION[$name] = $value;
	}

	public function value($name) {
		return $_SESSION[$name];
	}

}

?>