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
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */

class TransitQuote_Pro_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::init_database();
		return true;
	}
	/**
	 * Initialize the database
	 *
	 * @since    1.0.0
	 */

	public static function init_database(){
		//set up custom database on activate 
		$plugin = new TransitQuote_Pro4(); 
		$plugin->init_settings();
		$plugin->load_dependencies();
		$cdb = $plugin->get_custom_db();
		$cdb->create_tables();
		$plugin->insert_default_data($cdb);
		$plugin->update_default_data($cdb);
		$plugin->delete_orphaned_rates();
		self::add_cap();
	}

	private static function add_cap(){
		// Add manage_transitquote permission to all who have manage_options
		$roles = get_editable_roles();
        foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
            if (isset($roles[$key])){
            	switch ($key) {
            		case 'Dispatch':
            		$role->add_cap('manage_transitquote');
            			break;
            		
            		default:
            			if($role->has_cap('manage_options')) {
                			$role->add_cap('manage_transitquote');
                		};
            			break;
            	}
            }
        }        
	}




}
?>