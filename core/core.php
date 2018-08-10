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
	 * Pseudo-constructor
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
		$this->plugin->realFile = WP_CONTENT_DIR.'/functions.php';

		// Factory object
		$this->plugin->factory = new Factory($this->plugin);

		// Create registrar object and set hooks handler
		$this->plugin->factory->registrar->setHandler($this);
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
				$this->plugin->factory->admin();
			}
		}
	}



	/**
	 * Handle AJAX request
	 */
	private function ajax() {

		// Check this plugin AJAX action
		if (!empty($_POST['action']) && $this->plugin->prefix.'_save' == $_POST['action']) {

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



	/**
	 * Activation hook
	 * Try to create wp-content/functions.php file if it does not exists
	 */
	public function onActivation() {
		if (!@file_exists($this->plugin->realFile)) {
			@file_put_contents($this->plugin->realFile, '<?php'."\n\n");
		}
	}



}