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



	/**
	 * Plugin page
	 */
	public function show($args) {

		// Vars
		extract($args);

		// Display  ?>
		<div class="wrap">

			<h1>Custom Functions</h1>

			<h2>Editing wp-content/functions.php</h2>

			<form name="template" id="template" class="custom-functions-template" method="post">

				<div style="margin-right: 0">
					<label for="newcontent" id="theme-plugin-editor-label"><?php _e( 'Selected file content:' ); ?></label>
					<textarea cols="70" rows="25" name="newcontent" id="newcontent" aria-describedby="editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4"><?php echo esc_textarea($content); ?></textarea>
				</div>

				<?php if (!empty($docsSelect)) : ?>

					<div id="documentation" class="hide-if-no-js"><label for="docs-list"><?php _e('Documentation:') ?></label> <?php echo $docsSelect ?>
						<input type="button" class="button" value="<?php esc_attr_e('Look Up'); ?>" onclick="if ('' != jQuery('#docs-list').val()) { window.open( 'https://api.wordpress.org/core/handbook/1.0/?function=' + escape(jQuery('#docs-list').val()) + '&amp;locale=<?php echo urlencode(get_user_locale()) ?>&amp;version=<?php echo urlencode(get_bloginfo('version')) ?>&amp;redirect=true'); }" />
					</div>

				<?php endif; ?>

				<?php if ($writable) : ?>

					<div class="editor-notices" style="margin-right: 0"></div>

					<p class="submit">
						<input type="button" id="custom-functions-template-button" class="button button-primary" value="<?php _e('Update File'); ?>" />
						<span class="spinner"></span>
					</p>

				<?php else : ?>

					<p><em><?php _e('You need to make this file writable before you can save your changes. See <a href="https://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.'); ?></em></p>

				<?php endif; ?>

				<?php function_exists('wp_print_file_editor_templates')? wp_print_file_editor_templates() : $this->wp_print_file_editor_templates(); ?>

			</form>

		</div><?php
	}



	/**
	 * Helper funtion to avoid crashes due previous WP versions
	 * Located at: wp-admin/includes/file.php
	 */
	private function wp_print_file_editor_templates() {
		?>
		<script type="text/html" id="tmpl-wp-file-editor-notice">
			<div class="notice inline notice-{{ data.type || 'info' }} {{ data.alt ? 'notice-alt' : '' }} {{ data.dismissible ? 'is-dismissible' : '' }} {{ data.classes || '' }}">
				<# if ( 'php_error' === data.code ) { #>
					<p>
						<?php
						printf(
							/* translators: %$1s is line number and %1$s is file path. */
							__( 'Your PHP code changes were rolled back due to an error on line %1$s of file %2$s. Please fix and try saving again.' ),
							'{{ data.line }}',
							'{{ data.file }}'
						);
						?>
					</p>
					<pre>{{ data.message }}</pre>
				<# } else if ( 'file_not_writable' === data.code ) { #>
					<p><?php _e( 'You need to make this file writable before you can save your changes. See <a href="https://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.' ); ?></p>
				<# } else { #>
					<p>{{ data.message || data.code }}</p>

					<# if ( 'lint_errors' === data.code ) { #>
						<p>
							<# var elementId = 'el-' + String( Math.random() ); #>
							<input id="{{ elementId }}"  type="checkbox">
							<label for="{{ elementId }}"><?php _e( 'Update anyway, even though it might break your site?' ); ?></label>
						</p>
					<# } #>
				<# } #>
				<# if ( data.dismissible ) { #>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e( 'Dismiss' ); ?></span></button>
				<# } #>
			</div>
		</script>
		<?php
	}



}