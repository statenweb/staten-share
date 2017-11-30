<?php

namespace StatenShare\Helpers\WP;

abstract class Thing {
	public function init() {
		$this->attach_hooks();
	}

	abstract public function attach_hooks();
}