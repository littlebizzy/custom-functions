<?php

// Subpackage namespace
namespace LittleBizzy\CustomFunctions\Core;

// Aliased namespaces
use \LittleBizzy\CustomFunctions\Admin;
use \LittleBizzy\CustomFunctions\Core;
use \LittleBizzy\CustomFunctions\File;
use \LittleBizzy\CustomFunctions\Helpers;

/**
 * Object Factory class
 *
 * @package Custom Functions
 * @subpackage Core
 */
class Factory extends Helpers\Factory {



	/**
	 * Registrar object
	 */
	protected function createRegistrar() {
		return new Helpers\Registrar($this->plugin);
	}



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
		return new Admin\Display();
	}



	/**
	 * AJAX object
	 */
	protected function createAjax() {
		return File\AJAX::instance($this->plugin);
	}



	/**
	 * Code object
	 */
	 protected function createCode() {
 		return new File\Code($this->plugin);
 	}



}