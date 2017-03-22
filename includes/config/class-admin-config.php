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
                                                  'title'=>'Quote Options',
                                                  'fields'=>array(
                                                    'success_message'=>array(
                                                      'id'=>'success_message',
                                                      'label'=>'Success Message',
                                                      'type'=>'input'),
                                                    'min_notice'=>array(
                                                      'id'=>'min_notice',
                                                      'label'=>'Minimum Notice Period',
                                                      'type'=>'input'),
                                                    'min_notice_charge'=>array(
                                                      'id'=>'min_notice_charge',
                                                      'label'=>'Minimum Notice Charge',
                                                      'type'=>'input'),
                                                    'currency'=>array(
                                                      'id'=>'currency',
                                                      'label'=>'Currency Symbol',
                                                      'type'=>'select'),
                                                    'quote_element'=>array(
                                                      'id'=>'quote_element',
                                                      'label'=>'Quote Display Element',
                                                      'type'=>'input'),
                                                    'distance_unit'=>array(
                                                      'id'=>'distance_unit',
                                                      'label'=>'Distance Unit',
                                                      'type'=>'select'),
                                                    'layout'=>array(
                                                      'id'=>'layout',
                                                      'label'=>'Layout',
                                                      'type'=>'select'),
                                                    'start_location'=>array(
                                                      'id'=>'start_location',
                                                      'label'=>'Start Location',
                                                      'type'=>'addresspicker'),
                                                    'geolocate'=>array(
                                                      'id'=>'geolocate',
                                                      'label'=>'Geolocation',
                                                      'type'=>'checkbox'
                                                      ),
                                                    'api_key'=>array(
                                                      'id'=>'api_key',
                                                      'label'=>'Googl Maps API Key',
                                                      'type'=>'input')
                                                    )
                                                )

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