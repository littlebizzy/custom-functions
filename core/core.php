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
		$this->context();
		$this->load();
	}



	/**
	 * Initialization
	 */
	private function init() {

		// Custom functions real file
		$this->plugin->realFile = WP_CONTENT_DIR.'/custom-functions.php';
	}



	/**
	 * Run plugin under WP context
	 */
	private function context() {

		// Check admin area
		if (is_admin()) {

			// Check AJAX request
			if (defined('DOING_AJAX') && DOING_AJAX) {
				$this->ajax();

			// Admin area
			} else {
				$this->admin();
			}
		}
	}



	/**
	 * Start the admin class
	 */
	private function admin() {

		// Factory object
		$this->plugin->factory = new Factory($this->plugin);

		// Admin display
		$this->plugin->factory->admin();
	}



	/**
	 * Handle AJAX request
	 */
	private function ajax() {

		// Check this plugin AJAX action
		if (!empty($_POST['action']) && $this->plugin->prefix.'_save' == $_POST['action']) {

			// Factory object
			$this->plugin->factory = new Factory($this->plugin);

			// Handle the ajax request
			add_action('wp_ajax_'.$_POST['action'], [$this->plugin->factory->ajax, 'save']);

			// Clean buffer
			@ob_clean();

			// Start buffering
			@ob_start();
		}
	}



	/**
	 * Load custom functions file
	 */
	private function load() {

		// Check file before include it
		if (@file_exists($this->plugin->realFile))
			@include_once $this->plugin->realFile;
	}



}