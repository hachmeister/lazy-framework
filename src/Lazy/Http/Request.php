<?php

/**
 *
 * @package Lazy\Http
 */
interface Lazy_Http_Request {

	public function scheme();

	public function host();

	public function port();

	public function path();

	public function param($name);

	public function params();

	public function method();

	public function session();

}

?>