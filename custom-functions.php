<?php
/*
Plugin Name: Custom Functions
Plugin URI: https://www.littlebizzy.com/plugins/custom-functions
Description: Enables the ability to input custom WordPress functions such as filters in a centralized place to avoid the dependence on a theme functions.php file.
Version: 1.0.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: CSTMFN
*/

// Plugin namespace
namespace LittleBizzy\CustomFunctions;

// Aliased namespaces
use LittleBizzy\CustomFunctions\Notices;

// Block direct calls
if (!function_exists('add_action'))
	die;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'cstmfn';
const VERSION = '1.0.0';

// Loader
require_once dirname(FILE).'/helpers/loader.php';

// Admin Notices
// Notices\Admin_Notices::instance(__FILE__);

/**
 * Admin Notices Multisite check
 * Uncomment "return;" to disable this plugin on Multisite installs
 */
if (false !== Notices\Admin_Notices_MS::instance(__FILE__)) { /* return; */ }

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');
