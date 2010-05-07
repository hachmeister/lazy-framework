<?php

/**
 *
 * @package Lazy\Http
 */
interface Lazy_Http_Response {

	public function content();

	public function cookies();

	public function status();

	public function addContent($content);

	public function addCookie(Lazy_Http_Cookie $cookie);

	public function setStatus($status);

}

?>