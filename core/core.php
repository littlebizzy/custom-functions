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
	 * Plugin AJAX request
	 */
	private $isAJAX = false;



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

			// This plugin request
			$this->isAJAX = true;

			// Destroy any previous buffer
			$level = (int) @ob_get_level();
			for ($i = $level; $i > 0; $i--) {
				@ob_end_clean();
			}

			// Start buffering
			@ob_start();

			// Handle the ajax request
			add_action('wp_ajax_'.$_POST['action'], [$this->plugin->factory->ajax, 'save']);
		}
	}



	/**
	 * Load custom functions file
	 */
	private function load() {

		// Avoid AJAX context
		if (!$this->isAJAX) {

			// Check file before include it
			if (@file_exists($this->plugin->realFile)) {

				// Use include to show a warning instead of
				// generate a PHP fatal error and stop execution
				@include_once $this->plugin->realFile;
			}
		}
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