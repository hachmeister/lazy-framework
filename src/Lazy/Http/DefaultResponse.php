<?php

/**
 *
 * @package Lazy\Http
 */
class Lazy_Http_DefaultResponse implements Lazy_Http_Response {

	protected $content;

	protected $cookies;

	protected $status;

	public function __construct() {
		$this->content = '';
		$this->cookies = array();
		$this->status = 200;
	}

	public function content() {
		return $this->content;
	}

	public function cookies() {
		return $this->cookies;
	}

	public function status() {
		return $this->status;
	}

	public function addContent($content) {
		$this->content .= $content;
	}

	public function addCookie(Lazy_Http_Cookie $cookie) {
		$this->cookies[] = $cookie;
	}

	public function setStatus($status) {
		if (is_int($status)) {
			$this->status = $status;
		} else {
			throw new Exception('Status must be a number!');
		}
	}

}

?>