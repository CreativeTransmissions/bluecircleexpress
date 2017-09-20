<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */

class TransitQuote_Pro_Activator {

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
		$plugin = new TransitQuote_Pro(); 
		$plugin->load_dependencies();
		$cdb = $plugin->get_custom_db();
		$cdb->create_tables();
		$plugin->insert_default_data($cdb);
	}




}
?>