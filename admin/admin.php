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

		// Handle possible posted content
		$postedContent = isset($_POST['custom-functions-content'])? $_POST['custom-functions-content'] : false;

		// Real file
		$realFile = WP_CONTENT_DIR.'/custom-functions.php';

		// Enqueue editor
		wp_enqueue_script('wp-theme-plugin-editor');

		// Editor settings
		$settings = ['codeEditor' => wp_enqueue_code_editor(['file' => $realFile])];
		wp_add_inline_script('wp-theme-plugin-editor', sprintf('jQuery(function($) { wp.themePluginEditor.init($("#template"), %s); })', wp_json_encode($settings)));
		wp_add_inline_script('wp-theme-plugin-editor', sprintf('wp.themePluginEditor.themeOrPlugin = "plugin";'));

		// Custom script
		wp_enqueue_script($this->plugin->prefix.'-admin-script', plugins_url('assets/admin.js', $this->plugin->file), ['jquery'], $this->plugin->version, true);

		// Editor contents
		$content = (false === $postedContent)? @file_get_contents($realFile) : $postedContent;

		// Functions documentation
		$docsSelect = '';
		if ('.php' == substr($realFile, strrpos($realFile, '.'))) {
			$functions = wp_doc_link_parse($content);
			if (!empty($functions) && is_array($functions)) {
				foreach ($functions as $function)
					$docsSelect .= '<option value="'.esc_attr($function).'">'.esc_html($function).'()</option>';
				$docsSelect = '<select name="docs-list" id="docs-list"><option value="">'.__('Function Name&hellip;').'</option>'.$docsSelect.'</select>';
			}
		}

		// Arguments
		$args = [
			'editing' 		=> true,
			'writable' 		=> @is_writeable($realFile),
			'content' 		=> $content,
			'docs_select' 	=> $docsSelect,
		];

		// Shows page
		$this->plugin->factory->display->show($args);
	}



}