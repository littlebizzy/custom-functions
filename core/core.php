<?php

// Subpackage namespace
namespace LittleBizzy\CustomFunctions\Core;

// Aliased namespaces
use \LittleBizzy\CustomFunctions\Helpers;

/**
 * Core class
 *
 * @package Custom Functions
 * @subpackage Core
 */
final class Core extends Helpers\Singleton {



	/**
	 * Pseudo constructor
	 */
	protected function onConstruct() {
		$this->init();
		$this->load();
		$this->context();
	}



	/**
	 * Initialization
	 */
	private function init() {

		// Custom functions real file
		$this->plugin->realFile = WP_CONTENT_DIR.'/custom-functions.php';
	}



	/**
	 * Load custom functions file
	 */
	private function load() {

		// Check file before include it
		if (@file_exists($this->plugin->realFile))
			@include_once $this->plugin->realFile;
	}



	/**
	 * Run plugin under WP context
	 */
	private function context() {

		// Check admin area
		if (!is_admin())
			return;

		// Set Factory object
		$this->plugin->factory = new Factory($this->plugin);

		// Check AJAX request
		if (defined('DOING_AJAX') && DOING_AJAX) {

			// Check this plugin prefix in action param
			if (!empty($_POST) && is_array($_POST) && !empty($_POST['action'])) {

				// Check action value
				if ($this->plugin->prefix.'_save' == $_POST['action']) {

					// Handle the ajax request
					add_action('wp_ajax_'.$_POST['action'], [$this->plugin->factory->ajax, 'save']);
				}
			}

		// Admin area
		} else {

			// Admin display
			$this->plugin->factory->admin();
		}
	}



}