<?php

/**
 *
 * @package Lazy\Http
 */
interface Lazy_Http_Session {

	public function id($id);

	public function removeValue($name);

	public function setValue($name, $value);

	public function value($name);

}

?>