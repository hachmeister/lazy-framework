<?php

/**
 *
 * @package Lazy\Http
 */
class Lazy_Http_DefaultRequest implements Lazy_Http_Request {

	protected $scheme;

	protected $host;

	protected $port;

	protected $path;

	protected $params;

	protected $method;

	protected $session;

	public function __constructor() {
		$this->params = array();
	}

	public function scheme() {
		return $this->scheme;
	}

	public function host() {
		return $this->host;
	}

	public function port() {
		return $this->port;
	}

	public function path() {
		return $this->path;
	}

	public function param($name) {
		return $this->params[$name];
	}

	public function params() {
		return $this->params;
	}

	public function method() {
		return $this->method;
	}

	public function session() {
		return $this->session;
	}

	public function setScheme($scheme) {
		$this->scheme = $scheme;
	}

	public function setHost($host) {
		$this->host = $host;
	}

	public function setPort($port) {
		$this->port = $port;
	}

	public function setPath($path) {
		$this->path = $path;
	}

	public function setParams($params) {
		$this->params = $params;
	}

	public function setMethod($method) {
		$this->method = $method;
	}

	public function setSession(Lazy_Http_Session $session) {
		$this->session = $session;
	}

}

?>