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
		add_action('admin_menu', [$this, 'menu']);
	}



	// WP hooks
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Display menu
	 */
	public function menu() {
		add_plugins_page('Custom Functions', 'Custom Functions', 'manage_options', 'custom-functions', [$this, 'page']);
	}



	/**
	 * Admin page
	 */
	public function page() {

		// Exit on unauthorized access
		if (!current_user_can('manage_options'))
			die;

		// Handle possible posted content
		$postedContent = isset($_POST['custom-functions-content'])? $_POST['custom-functions-content'] : false;

		// Enqueue editor
		wp_enqueue_script('wp-theme-plugin-editor');

		// Editor settings
		$settings = ['codeEditor' => wp_enqueue_code_editor(['file' => $this->plugin->realFile])];
		wp_add_inline_script('wp-theme-plugin-editor', sprintf('jQuery(function($) { wp.themePluginEditor.init($("#template"), %s); })', wp_json_encode($settings)));
		wp_add_inline_script('wp-theme-plugin-editor', sprintf('wp.themePluginEditor.themeOrPlugin = "plugin";'));

		// Custom script and data
		wp_enqueue_script($this->plugin->prefix.'-admin', plugins_url('assets/admin.js', $this->plugin->file), ['jquery'], $this->plugin->version, true);
		wp_add_inline_script($this->plugin->prefix.'-admin', 'var '.$this->plugin->prefix.'_data = { nonce: "'.esc_attr(wp_create_nonce($this->plugin->file)).'" }');

		// Styles adjustements
		add_action('admin_footer', [$this, 'footer']);

		// Editor contents
		$content = (false === $postedContent)? @file_get_contents($this->plugin->realFile) : $postedContent;

		// Functions documentation
		$docsSelect = '';
		$functions = wp_doc_link_parse($content);
		if (!empty($functions) && is_array($functions)) {
			foreach ($functions as $function)
				$docsSelect .= '<option value="'.esc_attr($function).'">'.esc_html($function).'()</option>';
			$docsSelect = '<select name="docs-list" id="docs-list"><option value="">'.__('Function Name&hellip;').'</option>'.$docsSelect.'</select>';
		}

		// Arguments
		$args = [
			'writable' 		=> @is_writeable($this->plugin->realFile),
			'content' 		=> $content,
			'docs_select' 	=> $docsSelect,
		];

		// Shows page
		$this->plugin->factory->display->show($args);
	}



	/**
	 * Avoid right margins
	 */
	public function footer() {
		echo '<style>.editor-notices, #template .notice { margin-right: 0; }</style>'."\n";
	}



}