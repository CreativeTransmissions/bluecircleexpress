<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Balance_Voucher
 * @subpackage WP_Balance_Voucher/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Balance_Voucher
 * @subpackage WP_Balance_Voucher/includes
 * @author     Your Name <email@example.com>
 */

class WP_Balance_Voucher_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::init_database();
	}
	/**
	 * Initialize the database
	 *
	 * @since    1.0.0
	 */

	public static function init_database(){
		//set up custom database on activate 
		$plugin = new WP_Balance_Voucher(); 
		$plugin->load_dependencies();
		$cdb = $plugin->get_custom_db();
		$cdb->create_tables();
		$plugin->insert_default_data($cdb);
	}




}
?>