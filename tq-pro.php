<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://transitquote.co.uk
 * @since             1.0.0
 * @package           TransitQuote_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       TransitQuote Pro
 * Plugin URI:        http://transitquote.co.uk
 * Description:       Automatic Transportation Quote Calculator For WordPress
 * Version:           4.2.8
 * Author:            Creative Transmissions
 * Author URI:        https://transitquote.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tq-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! defined( 'TQ_PLUGIN_PATH' ) ) {
	define( 'TQ_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tq-pro-activator.php
 */
function activate_TransitQuote_Pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tq-pro-activator.php';
	TransitQuote_Pro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tq-pro-deactivator.php
 */
function deactivate_TransitQuote_Pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tq-pro-deactivator.php';
	TransitQuote_Pro_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_TransitQuote_Pro' );
register_deactivation_hook( __FILE__, 'deactivate_TransitQuote_Pro' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tq-pro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_TransitQuote_Pro() {

	$plugin = new TransitQuote_Pro4();
	$plugin->run();

}
function tp_save_error($tmp_plugin){
  	update_option( 'wp_tq_pro_plugin_activation_error',  ob_get_contents() );
}

add_action( 'activated_plugin', 'tp_save_error' );

run_TransitQuote_Pro();
