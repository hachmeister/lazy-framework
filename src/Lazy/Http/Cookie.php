<?php

/**
 *
 * @package Lazy\Http
 */
class Lazy_Http_Cookie {

	private $name;

	private $value;

	public function __construct($name = '', $value = '') {
		$this->name = $name;
		$this->value = $value;
	}

	public function name() {
		return $this->name;
	}

	public function value() {
		return $this->value;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setValue($value) {
		$this->value = $value;
	}

}

?>