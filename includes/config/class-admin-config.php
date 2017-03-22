<?php

/**
 * Define the admin structure
 *
 * @link       http://customgooglemaptools.com
 * @since      1.0.0
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/includes
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 * @copyright 2016 Creative Transmissions
 */

namespace TransitQuote_Premium;
class Admin_Config {

  public function __construct() {
    //$this->debugging = true;
  }

  public static function get_config($config_name){

    $method = 'config_'.$config_name;
    return self::$method();

  }


  private static function config_tabs(){
    return array( 
              'premium_job_requests'=>array( 
                              'key'=>'premium_job_requests',
                              'title'=>'Jobs',
                              'table'=>'jobs',
                              'sections'=>array()
                              ),

              'premium_customers'=>array(
                              'key'=>'premium_customers',
                              'title'=>'Customers',
                              'table'=>'customers',
                              'sections'=>array()
                              ),

              'premium_rates'=>array(
                              'key'=>'premium_rates',
                              'title'=>'Rates',
                              'table'=>'rates',
                              'sections'=>array(),
                              'data'=>array('distance_unit' => 'Kilometer')
                              ),

              'premium_vehicles'=>array(
                              'key'=>'premium_vehicles',
                              'title'=>'Vehicles',
                              'table'=>'vehicles',
                              'sections'=>array()
                              ),

              'premium_services'=>array(
                              'key'=>'premium_services',
                              'title'=>'Services',
                              'table'=>'services',
                              'sections'=>array()
                              ),

              'premium_quote_options'=>array(
                              'key'=>'premium_quote_options',
                              'title'=>'Quote Options',
                              'sections'=>array('prem_settings_quote_options'=>array(
                                        'id'=>'prem_settings_quote_options',
                                        'title'=>'Quote Options')
                                        )
                              ),

              'premium_email_options'=>array(
                              'key'=>'premium_email_options',
                              'title'=>'Email Options',
                              'sections'=>array()
                              ),

              'premium_paypal_options'=>array(
                              'key'=>'premium_paypal_options',
                              'title'=>'PayPal Options',
                              'sections'=>array()
                              ),

              'premium_paypal_transactions'=>array(
                              'key'=>'premium_paypal_transactions',
                              'title'=>'PayPal Transactions',
                              'sections'=>array()
                              )
      );
  }

}?>