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

		$real_file = WP_CONTENT_DIR.'/custom-functions.php';

		// Enqueue editor
		wp_enqueue_script('wp-theme-plugin-editor');

		// Editor settings
		$settings = ['codeEditor' => wp_enqueue_code_editor(['file' => $real_file])];
		wp_add_inline_script( 'wp-theme-plugin-editor', sprintf('jQuery(function($) { wp.themePluginEditor.init($("#template"), %s); })', wp_json_encode($settings)));
		wp_add_inline_script( 'wp-theme-plugin-editor', sprintf('wp.themePluginEditor.themeOrPlugin = "plugin";'));

		// Editor contents
		$content = empty($posted_content)? @file_get_contents($real_file) : $posted_content;

		// Functions documentation
		$docs_select = '';
		$functions = wp_doc_link_parse($content);
		if ( !empty($functions) ) {
			$docs_select = '<select name="docs-list" id="docs-list">';
			$docs_select .= '<option value="">' . __( 'Function Name&hellip;' ) . '</option>';
			foreach ( $functions as $function) {
				$docs_select .= '<option value="' . esc_attr( $function ) . '">' . esc_html( $function ) . '()</option>';
			}
			$docs_select .= '</select>';
		}

		// Arguments
		$args = [
			'editing' 		=> true,
			'writable' 		=> @is_writeable($real_file),
			'content' 		=> $content,
			'docs_select' 	=> $docs_select,
		];

		// Show data
		$this->show($args);
	}



	// Internal
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Page display
	 */
	private function show($args) {

		// Vars
		extract($args);

		// Display  ?>
		<div class="wrap">

			<h1>Custom Functions</h1>

			<h2>Editing wp-content/custom-functions.php</h2>

			<form name="template" id="template" action="plugin-editor.php" method="post">

				<?php //wp_nonce_field( 'edit-plugin_' . $file, 'nonce' ); ?>

				<div>
					<label for="newcontent" id="theme-plugin-editor-label"><?php _e( 'Selected file content:' ); ?></label>
					<textarea cols="70" rows="25" name="newcontent" id="newcontent" aria-describedby="editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4"><?php echo $content; ?></textarea>
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="file" value="<?php // echo esc_attr( $file ); ?>" />
					<input type="hidden" name="plugin" value="<?php // echo esc_attr( $plugin ); ?>" />
				</div>

				<?php if ( !empty( $docs_select ) ) : ?>
				<div id="documentation" class="hide-if-no-js"><label for="docs-list"><?php _e('Documentation:') ?></label> <?php echo $docs_select ?> <input type="button" class="button" value="<?php esc_attr_e( 'Look Up' ) ?> " onclick="if ( '' != jQuery('#docs-list').val() ) { window.open( 'https://api.wordpress.org/core/handbook/1.0/?function=' + escape( jQuery( '#docs-list' ).val() ) + '&amp;locale=<?php echo urlencode( get_user_locale() ) ?>&amp;version=<?php echo urlencode( get_bloginfo( 'version' ) ) ?>&amp;redirect=true'); }" /></div>
				<?php endif; ?>

				<?php if ( $writable ) : ?>
					<p class="submit">
						<?php submit_button( __( 'Update File' ), 'primary', 'submit', false ); ?>
						<span class="spinner"></span>
					</p>

				<?php else : ?>
					<p><em><?php _e('You need to make this file writable before you can save your changes. See <a href="https://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.'); ?></em></p>

				<?php endif; ?>

			</form>

		</div><?php
	}



}