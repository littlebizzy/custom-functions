<?php

// Subpackage namespace
namespace LittleBizzy\CustomFunctions\Admin;

/**
 * Display class
 *
 * @package Custom Functions
 * @subpackage Admin
 */
class Display {



	// Properties
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Plugin object
	 */
	private $plugin;



	// Initialization
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Constructor
	 */
	public function __construct($plugin) {

		// Plugin object
		$this->plugin = $plugin;

		// Arguments
		$args = [

		];

		// Show data
		$this->display($args);
	}



	// Internal
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Display page
	 */
	private function display($args) {

	}



}