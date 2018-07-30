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
	 * Real file path
	 */
	private $realFile;



	/**
	 * Constructor
	 */
	public function __construct() {
		$this->realFile = WP_CONTENT_DIR.'/custom-functions.php';
	}



	/**
	 * Update content
	 */
	public function update($content) {

		// Previous file
		$previousContent = @file_get_contents($this->realFile);

		// Save new content
		if (true !== ($result = $this->save($content)))
			return $result;

		// Look for errors
		if (true !== ($result = $this->validate())) {
			$this->save($previousContent);
			return $result;
		}

		// Done
		return true;
	}



	/**
	 * Validate new file content
	 */
	private function validate() {


		// Done
		return true;
	}



	/**
	 * Save directly to file
	 */
	private function save($content) {

		// Check writable file
		if (!is_writeable($this->realFile))
			return new WP_Error('file_not_writable', 'The file wp-content/custom-functions.php is not writable');

		// Try to open the file
		$fh = @fopen($this->realFile, 'w+');
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