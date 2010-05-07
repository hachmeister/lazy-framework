<?php

/**
 *
 * @package Lazy\Utils
 */
class Lazy_Utils_ExceptionUtils {

	public static function formatParams($params) {
		$result = '';
		$max = count($params);

		for ($i = 0; $i < $max; $i++) {
			$result .= self::formatParam($params[$i]);

			if (($i + 1) < $max) {
				$result .= ', ';
			}
		}

		return $result;
	}

	public static function formatParam($param) {
		if (is_array($param)) {
			return self::formatArray($param);
		} elseif (is_bool($param)) {
			return self::formatBool($param);
		} elseif (is_null($param)) {
			return self::formatNull($param);
		} elseif (is_string($param)) {
			return self::formatString($param);
		} else {
			return $param;
		}
	}

	private static function formatArray($param) {
		$result = 'array(';
		$keys = array_keys($param);
		$max = count($keys);

		for ($i = 0; $i < $max; $i++) {
			$key = $keys[$i];
			$result .= self::formatParam($key);
			$result .= ' => ';
			$result .= self::formatParam($param[$key]);

			if (($i + 1) < $max) {
				$result .= ', ';
			}
		}

		$result .= ')';
		return $result;
	}

	private static function formatBool($param) {
		return ($param) ? 'true' : 'false';
	}

	private static function formatNull($param) {
		return '<span class="null">null</span>';
	}

	private static function formatString($param) {
		$result = $param;

		if (strlen($result) > 20) {
			$result = substr($result, 0, 17) . '<span class="abbrev">...</span>';
		}

		$result = str_replace("\n", '<span class="special">\n</span>', $result);
		$result = str_replace("\t", '<span class="special">\t</span>', $result);

		return '<span class="string">"' . $result . '"</span>';
	}

}

?>