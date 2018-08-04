<?php

// Subpackage namespace
namespace LittleBizzy\CustomFunctions\File;

// Aliased namespaces
use \LittleBizzy\CustomFunctions\Helpers;

/**
 * AJAX class
 *
 * @package Custom Functions
 * @subpackage Admin
 */
class AJAX extends Helpers\Singleton {



	// Methods
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Validate code and save file
	 */
	public function save() {

		// Check user permissions
		if (!current_user_can('manage_options'))
			$this->error('Current user does not have enough permissions.');

		// Check nonce
		if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], $this->plugin->file))
			$this->error('Verification error, please reload this page and try again (you can lose the changes).');

		// Check code
		if (!isset($_POST['code']))
			$this->error('Code content is missing');

		// Remove back slashes
		$code = wp_unslash($_POST['code']);

		// Check code
		if (true !== ($result = $this->plugin->factory->code->update($code))) {
			error_log(print_r($result, true));
			$this->error($result->get_error_message());
		}

		// Done
		$this->output($this->response());
	}



	// Internal
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Default response
	 */
	private function response() {
		return [
			'status' => 'ok',
			'reason' => '',
			'data' 	 => [],
		];
	}



	/**
	 * Output error
	 */
	private function error($reason) {
		$response = $this->response();
		$response['status'] = 'error';
		$response['reason'] = $reason;
		$this->output($response);
	}



	/**
	 * Output AJAX in JSON format and exit
	 */
	private function output($response) {
		@header('Content-Type: application/json');
		die(@json_encode($response));
	}



}