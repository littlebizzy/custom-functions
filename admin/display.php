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

			<h2>Editing wp-content/custom-functions.php</h2>

			<form name="template" id="template" class="custom-functions-template" method="post">

				<div>
					<label for="newcontent" id="theme-plugin-editor-label"><?php _e( 'Selected file content:' ); ?></label>
					<textarea cols="70" rows="25" name="newcontent" id="newcontent" aria-describedby="editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4"><?php echo esc_textarea($content); ?></textarea>
				</div>

				<?php if (!empty($docsSelect)) : ?>

					<div id="documentation" class="hide-if-no-js"><label for="docs-list"><?php _e('Documentation:') ?></label> <?php echo $docsSelect ?>
						<input type="button" class="button" value="<?php esc_attr_e('Look Up'); ?>" onclick="if ('' != jQuery('#docs-list').val()) { window.open( 'https://api.wordpress.org/core/handbook/1.0/?function=' + escape(jQuery('#docs-list').val()) + '&amp;locale=<?php echo urlencode(get_user_locale()) ?>&amp;version=<?php echo urlencode(get_bloginfo('version')) ?>&amp;redirect=true'); }" />
					</div>

				<?php endif; ?>

				<?php if ($writable) : ?>
					<p class="submit">
						<input type="button" id="custom-functions-template-button" class="button button-primary" value="<?php _e('Update File'); ?>" />
						<span class="spinner"></span>
					</p>

				<?php else : ?>
					<p><em><?php _e('You need to make this file writable before you can save your changes. See <a href="https://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.'); ?></em></p>

				<?php endif; ?>

			</form>

		</div><?php
	}



}