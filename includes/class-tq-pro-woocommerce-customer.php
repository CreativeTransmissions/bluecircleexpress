<?php

/**
 * Define Label Fetcher  functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
namespace TransitQuote_Pro4;
class TQ_WooCommerceCustomer {

    public function __construct($config = null) {
        $this->cdb = $config['cdb'];
        $this->public = $config['public'];
        $this->debug = $config['debug'];
    }

    public function is_logged_in() {
		// if(is_admin()){
		// 	return false;
		// }
		$wp_user_id = get_current_user_id();
		if ($wp_user_id == 0) {
			return false;
		}
		return $wp_user_id;
    }

    public function is_repeat_customer() {
        $wp_user_id = get_current_user_id();
        if ($wp_user_id == 0) {
			return false;
		}
		$customer = $this->cdb->get_row('customers', $wp_user_id, 'wp_user_id');
		if (empty($customer)) {
			return false;
		} 
		return true;
    }

    public function get_tq_customer() {
		$wp_user_id = get_current_user_id();
		$this->customer = $this->cdb->get_row('customers', $wp_user_id, 'wp_user_id');
		if (empty($this->customer)) {
			return false;
		}
		return $this->customer;
    }

    public function get_latest_job($customer_id) {
		$jobs_table = $this->cdb->get_table_full_name('jobs');
		$sql = "SELECT * from ".$jobs_table." where customer_id = $customer_id order by id DESC limit 1;";
		$this->latest_job = $this->cdb->query($sql);
		if(empty($this->latest_job)){
			return false;
		}
		return $this->latest_job[0];
    }

    public function get_latest_job_details($job) {
		$this->latest_job = $this->public->get_job_details($job);
		if(empty($this->latest_job)){
			return false;
		}
		return $this->latest_job;
    }

}
