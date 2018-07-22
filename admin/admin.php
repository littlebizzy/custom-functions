<?php

// Subpackage namespace
namespace LittleBizzy\CustomFunctions\Admin;

// Aliased namespaces
use \LittleBizzy\CustomFunctions\Helpers;

/**
 * Admin class
 *
 * @package Custom Functions
 * @subpackage Admin
 */
final class Admin extends Helpers\Singleton {



	// Initialization
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Pseudo constructor
	 */
	protected function onConstruct() {
		add_action('admin_menu', [$this, 'adminMenu']);
	}



	// WP hooks
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Display menu
	 */
	public function adminMenu() {
		add_plugins_page('Custom Functions', 'Custom Functions', 'manage_options', 'custom-functions', [$this, 'adminPage']);
	}



	/**
	 * Admin page
	 */
	public function adminPage() {

		// Exit on unauthorized access
		if (!current_user_can('manage_options'))
			die;

		// Shows page
		$this->plugin->factory->display();
	}



}