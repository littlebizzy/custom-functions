<?php

// Subpackage namespace
namespace LittleBizzy\CustomFunctions\Core;

// Aliased namespaces
use \LittleBizzy\CustomFunctions\Admin;
use \LittleBizzy\CustomFunctions\Core;
use \LittleBizzy\CustomFunctions\Helpers;

/**
 * Object Factory class
 *
 * @package Custom Functions
 * @subpackage Core
 */
class Factory extends Helpers\Factory {



	/**
	 * Admin object
	 */
	protected function createAdmin() {
		return Admin\Admin::instance($this->plugin);
	}



	/**
	 * Display object
	 */
	protected function createDisplay() {
		return new Admin\Display($this->plugin);
	}



	/**
	 * AJAX object
	 */
	protected function createAjax() {
		return new Core\AJAX($this->plugin);
	}



}