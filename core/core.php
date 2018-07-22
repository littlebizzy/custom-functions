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

		// Check admin area
		if (!is_admin())
			return;

		// Factory object
		$this->plugin->factory = new Factory($this->plugin);

		// Check AJAX request
		if (defined('DOING_AJAX') && DOING_AJAX) {

			// Check this plugin prefix in action param
			if (!empty($_POST) && is_array($_POST) && !empty($_POST['action'])) {

				// Check action value
				if ($this->plugin->prefix.'_save' == $_POST['action']) {

					// Handle the ajax request
					$this->plugin->factory->ajax()->save();
				}
			}

		// Admin area
		} else {

			// Admin display
			$this->plugin->factory->admin();
		}
	}



}