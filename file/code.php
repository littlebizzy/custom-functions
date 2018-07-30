<?php

// Subpackage namespace
namespace LittleBizzy\CustomFunctions\File;

// Aliased namespaces
use \LittleBizzy\CustomFunctions\Helpers;

/**
 * Code class
 *
 * @package Custom Functions
 * @subpackage File
 */
class Code {



	/**
	 * Plugin object
	 */
	private $plugin;



	/**
	 * Constructor
	 */
	public function __construct($plugin) {
		$this->plugin = $plugin;
	}



	/**
	 * Update content
	 */
	public function update($content) {

		// Previous file
		$previousContent = @file_get_contents($this->plugin->realFile);
error_log($content);
		// Save new content
		if (true !== ($result = $this->save($content)))
			return $result;
error_log('here 0');
		// Invalidate OPcache
		$this->invalidateOPcache();

		// Look for errors
		/* if (true !== ($result = $this->validate())) {
			$this->save($previousContent);
			$this->invalidateOPcache();
			return $result;
		} */

		// Done
		return true;
	}



	/**
	 * Validate new file content
	 *
	 * This is an adaptation of existing WP code:
	 * 	Function: wp_edit_theme_plugin_file
	 * 	File: wp-admin/includes/file.php
	 */
	private function validate() {


		/* Requests configuration */

		// Prepare scrape key
		$scrape_key = md5(rand());
		$transient = 'scrape_key_'.$scrape_key;
		$scrape_nonce = strval(rand());
		set_transient($transient, $scrape_nonce, 60); // It shouldn't take more than 60 seconds to make the two loopback requests.

		// Cookies, params and headers
		$cookies = wp_unslash($_COOKIE);
		$headers = ['Cache-Control' => 'no-cache'];
		$scrape_params = [
			'wp_scrape_key' => $scrape_key,
			'wp_scrape_nonce' => $scrape_nonce,
		];

		// Include Basic auth in loopback requests.
		if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
			$headers['Authorization'] = 'Basic '.base64_encode(wp_unslash($_SERVER['PHP_AUTH_USER']).':'.wp_unslash($_SERVER['PHP_AUTH_PW']));

		// Make sure PHP process doesn't die before loopback requests complete.
		@set_time_limit(300);

		// Time to wait for loopback requests to finish.
		$timeout = 100;

		// Parseable text
		$needle_start = "###### wp_scraping_result_start:$scrape_key ######";
		$needle_end = "###### wp_scraping_result_end:$scrape_key ######";




		/* Remote requests */

		// Target URL
		$url = admin_url('plugins.php?page=custom-functions');
		$url = add_query_arg( $scrape_params, $url );

		// Perform request
		$r = wp_remote_get( $url, compact( 'cookies', 'headers', 'timeout' ) );
		$body = wp_remote_retrieve_body( $r );
		$scrape_result_position = strpos( $body, $needle_start );

		$loopback_request_failure = array(
			'code' => 'loopback_request_failed',
			'message' => __( 'Unable to communicate back with site to check for fatal errors, so the PHP change was reverted. You will need to upload your PHP file change by some other means, such as by using SFTP.' ),
		);
		$json_parse_failure = array(
			'code' => 'json_parse_error',
		);

		$result = null;
		if ( false === $scrape_result_position ) {
			$result = $loopback_request_failure;
		} else {
			$error_output = substr( $body, $scrape_result_position + strlen( $needle_start ) );
			$error_output = substr( $error_output, 0, strpos( $error_output, $needle_end ) );
			$result = @json_decode( trim( $error_output ), true );
			if ( empty( $result ) ) {
				$result = $json_parse_failure;
			}
		}

error_log('test 1');
error_log(print_r($result, true));

		// Try making request to homepage as well to see if visitors have been whitescreened.
		if ( true === $result ) {
error_log('test 2');
			$url = home_url( '/' );
			$url = add_query_arg( $scrape_params, $url );
			$r = wp_remote_get( $url, compact( 'cookies', 'headers', 'timeout' ) );
			$body = wp_remote_retrieve_body( $r );
			$scrape_result_position = strpos( $body, $needle_start );

			if ( false === $scrape_result_position ) {
				$result = $loopback_request_failure;
			} else {
				$error_output = substr( $body, $scrape_result_position + strlen( $needle_start ) );
				$error_output = substr( $error_output, 0, strpos( $error_output, $needle_end ) );
				$result = json_decode( trim( $error_output ), true );
				if ( empty( $result ) ) {
					$result = $json_parse_failure;
				}
			}
		}

		delete_transient( $transient );

		if ( true !== $result ) {

			if ( ! isset( $result['message'] ) ) {
				$message = __( 'Something went wrong.' );
			} else {
				$message = $result['message'];
				unset( $result['message'] );
			}
			return new WP_Error( 'php_error', $message, $result );
		}


		// Done
		return true;
	}



	/**
	 * Clear OPcache for this file
	 */
	private function invalidateOPcache() {
		if (function_exists('opcache_invalidate'))
			@opcache_invalidate($this->plugin->realFile, true);
	}



	/**
	 * Save directly to file
	 */
	private function save($content) {

		// Check writable file
		if (!is_writeable($this->plugin->realFile))
			return new WP_Error('file_not_writable', 'The file wp-content/custom-functions.php is not writable');

		// Try to open the file
		$fh = @fopen($this->plugin->realFile, 'w+');
		if (false === $fh)
			return new WP_Error('file_not_writable', 'Cannot open the file wp-content/custom-functions.php for writing');

		// Write data
		$written = @fwrite($fh, $content);
		@fclose($fh);

		// Check data
		if (false === $written)
			return new WP_Error('unable_to_write', 'Unable to write to the file wp-content/custom-functions.php');

		// Done
		return true;
	}



}