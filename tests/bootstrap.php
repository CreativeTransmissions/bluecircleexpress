<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Transitquote_Pro
 */
/* error_reporting(E_ALL );
 ini_set('display_errors', 1);*/

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	echo 'loading plugin: '.dirname( dirname( __FILE__ ) ) . '/tq-pro.php';
	require dirname( dirname( __FILE__ ) ) . '/tq-pro.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );
	echo 'start up the WP testing environment: '.$_tests_dir . '/includes/bootstrap.php';
// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
