<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           TransitQuote_Premium
 *
 * @wordpress-plugin
 * Plugin Name:       WP Balance Voucher
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       A plugin for http://balance.jimbyrne.co.uk/
 * Version:           1.0.0
 * Author:            Creative Transmissions
 * Author URI:        http://creativetransmissions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-balance-voucher-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-balance-voucher-activator.php';
	TransitQuote_Premium_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-balance-voucher-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-balance-voucher-deactivator.php';
	TransitQuote_Premium_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-balance-voucher.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new TransitQuote_Premium();
	$plugin->run();

}
function ct_save_error($tmp_plugin){
  	update_option( 'wp_sell_plugin_activation_error',  ob_get_contents() );
}

add_action( 'activated_plugin', 'ct_save_error' );

run_plugin_name();
