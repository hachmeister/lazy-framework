<?php

/**
 *
 * @package Lazy\Mvc
 */
class Lazy_Mvc_View {

	private $viewname = null;

	private $model = array();

	private $stack = array();

	private $blocks = array();

	private $test = array();

	public function __construct($viewname) {
		$this->viewname = $viewname;
	}

	public function __call($name, $args) {
		if ($name == 'extends') {
			$this->test[] = 'extends(' . $args[0] . ')';

			$this->includeView($args[0]);
		} elseif ($name == 'block') {
			$this->test[] = 'block(' . $args[0] . ')';

			// need insert the reference?
			$insertReference = true;
			if (isset($this->blocks[$args[0]])) {
				$insertReference = false;
			}

			// create new block.
			$this->blocks[$args[0]] = array();

			// add the output until here to the previous block.
			$num = count($this->stack);
			if ($num > 0) {
				$previous = $this->stack[$num - 1];
				$this->blocks[$previous][] = ob_get_clean();
				if ($insertReference) {
					$this->blocks[$previous][] = &$this->blocks[$args[0]];
				}
			}

			// put the blockname to the stack.
			array_push($this->stack, $args[0]);

			// start output buffering
			ob_start();
		} elseif ($name == 'end') {
			$this->test[] = 'end()';

			$current = array_pop($this->stack);
			$this->blocks[$current][] = ob_get_clean();

			// start output buffering if there is still a block on the stack.
			if (count($this->stack) > 0) {
				ob_start();
			}
		} else {
			throw new Exception('Undefined method [' . $name . '] called!');
		}
	}

	public function __get($name) {
		if (isset($this->model[$name])) {
			return $this->model[$name];
		}
		return null;
	}

	public function __isset($name) {
		return isset($this->model[$name]);
	}

	public function render($model) {
		$this->model = $model;
		$this->block('__main__');
		$this->includeView($this->viewname);
		$this->end();
		return $this->composeParts($this->blocks['__main__']);
		//return print_r($this->blocks, true) . print_r($this->test, true);
	}

	private function composeParts($parts) {
		$content = '';
		foreach ($parts as $part) {
			if (is_array($part)) {
				$content .= $this->composeParts($part);
			} else {
				$content .= $part;
			}
		}
		return $content;
	}

	private function includeView($viewname) {
		include 'views/' . $viewname . '.php';
	}

}

?>
