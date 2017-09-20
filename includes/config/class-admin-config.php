<?php

/**
 * Define the admin structure
 *
 * @link       http://customgooglemaptools.com
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 * @copyright 2016 Creative Transmissions
 */

namespace TransitQuote_Pro;
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
              'tq_pro_job_requests'=>array( 
                              'key'=>'tq_pro_job_requests',
                              'title'=>'Jobs',
                              'table'=>'jobs',
                              'sections'=>array()
                              ),

              'tq_pro_customers'=>array(
                              'key'=>'tq_pro_customers',
                              'title'=>'Customers',
                              'table'=>'customers',
                              'sections'=>array()
                              ),

              'tq_pro_rates'=>array(
                              'key'=>'tq_pro_rates',
                              'title'=>'Rates',
                              'table'=>'rates',
                              'sections'=>array(),
                              'data'=>array('distance_unit' => 'Kilometer')
                              ),

              'tq_pro_vehicles'=>array(
                              'key'=>'tq_pro_vehicles',
                              'title'=>'Vehicles',
                              'table'=>'vehicles',
                              'sections'=>array()
                              ),

              'tq_pro_services'=>array(
                              'key'=>'tq_pro_services',
                              'title'=>'Services',
                              'table'=>'services',
                              'sections'=>array()
                              ),

              'tq_pro_map_options'=>array(
                              'key'=>'tq_pro_map_options',
                              'title'=>'Map Options',
                              'sections'=>array('prem_settings_map_options'=>array(
                                                  'id'=>'prem_settings_map_options',
                                                  'title'=>'Map Options',
                                                  'fields'=>array(
                                                    'api_key'=>array(
                                                      'id'=>'api_key',
                                                      'label'=>'Googl Maps API Key',
                                                      'type'=>'input'),
                                                    'distance_unit'=>array(
                                                      'id'=>'distance_unit',
                                                      'label'=>'Distance Unit',
                                                      'type'=>'select',
                                                      'options'=>array('Kilometer', 'Mile')),
                                                    'start_location'=>array(
                                                      'id'=>'start_location',
                                                      'label'=>'Start Location',
                                                      'type'=>'addresspicker'),
                                                    'geolocate'=>array(
                                                      'id'=>'geolocate',
                                                      'label'=>'Geolocation',
                                                      'type'=>'checkbox'
                                                      )
                                                  )

                                          )
                                )
                              ),

              'tq_pro_quote_options'=>array(
                              'key'=>'tq_pro_quote_options',
                              'title'=>'Quote Options',
                              'sections'=>array('prem_settings_quote_options'=>array(
                                                'id'=>'prem_settings_quote_options',
                                                'title'=>'Quote Options',
                                                'fields'=>array(
                                                    
                                                      'currency'=>array(
                                                        'id'=>'currency',
                                                        'label'=>'Currency Symbol',
                                                        'type'=>'input',
                                                        'help'=>'Please enter the currency symbol or text to display. For example: £, $, GBP, USD etc..'),
                                                      'max_address_pickers'=>array(
                                                        'id'=>'stops_allowed',
                                                        'label'=>'Maximum Destinations',
                                                        'type'=>'input',
                                                        'help'=>'Customers can request one or more destinations as part of the same job. If multiple destinations are allowed you can enter a number to limit the number of stops on one route.',
                                                        'value'=>3),
                                                      'min_notice'=>array(
                                                        'id'=>'min_notice',
                                                        'label'=>'Minimum Notice Period (HH:MM)',
                                                        'type'=>'input',
                                                        'help'=>'Please enter minimum notice period before which an additional charge is incurred.'),
                                                      'min_notice_charge'=>array(
                                                        'id'=>'min_notice_charge',
                                                        'label'=>'Minimum Notice Charge',
                                                        'type'=>'input',
                                                        'help'=>'Please enter the additional charge for jobs booked within 24 hours..'),
                                                      'success_message'=>array(
                                                        'id'=>'success_message',
                                                        'label'=>'Success Message',
                                                        'type'=>'textarea',
                                                        'help'=>'Please enter the message that will be displayed to the customer after their quote has been saved and displayed on screen. This should explain any next steps they must take to confirm their booking.'),
                                                      'quote_element'=>array(
                                                        'id'=>'quote_element',
                                                        'label'=>'Quote Display Element',
                                                        'help'=>'Please enter the class or id of the html element in which to display the final quote.<br/>Note that by specifying a class you can have the quote amount appear in multiple elements such as a visible element for displaying to the customer and a hidden form element for saving the amount.',
                                                        'type'=>'input')
                                                    )
                                                )

                                )
               ),
              'tq_pro_email_options'=>array(
                              'key'=>'tq_pro_email_options',
                              'title'=>'Email Options',
                              'sections'=>array('prem_settings_email_options'=>array(
                                                  'id'=>'prem_settings_email_options',
                                                  'title'=>'Email Options',
                                                  'fields'=>array(
                                                    
                                                      'notify'=>array(
                                                        'id'=>'notify',
                                                        'label'=>'Send New Job Emails To',
                                                        'type'=>'input',
                                                        'help'=>'Please enter the email addresses that will recieve new job requests. You can enter more than one by separating them with a comma.<br/>Example: <b>boss@mycompany.com, staff@mycompany.com</b>'),
                                                      'from_address'=>array(
                                                        'id'=>'from_address',
                                                        'label'=>'Reply Address for Customer Quote Emails',
                                                        'help'=>'Please enter the <em>From</em> email address that customers will recieve their quote emails from.<br/>Example: <b>customerservice@mycompany.com</b>',
                                                        'type'=>'input'),
                                                      'from_name'=>array(
                                                        'id'=>'from_name',
                                                        'label'=>'Contact Name for Customer Quote Emails',
                                                        'type'=>'input',
                                                        'help'=>'Please enter the <em>From</em> email address that customers will recieve their quote emails from.<br/>Example: <b>customerservice@mycompany.com</b>'),
                                                      'customer_subject'=>array(
                                                        'id'=>'customer_subject',
                                                        'label'=>'Customer Quote Email Subject',
                                                        'type'=>'input',
                                                        'help'=>'Please enter the email subject for customer quote emails.<br/>Example: <b>Your Tranporation Quote</b>'),
                                                      'customer_message'=>array(
                                                        'id'=>'customer_message',
                                                        'label'=>'Customer Quote Email Message',
                                                        'type'=>'textarea',
                                                        'help'=>'Please enter the message to your customer that will appear above the journey details and quote.')
                                                    )
                                              ))
                              ),

              'tq_pro_paypal_options'=>array(
                              'key'=>'tq_pro_paypal_options',
                              'title'=>'PayPal Options',
                              'sections'=>array('prem_settings_paypal_options'=>array(
                                                  'id'=>'prem_settings_paypal_options',
                                                  'title'=>'PayPal Options',
                                                  'fields'=>array(
                                                    'application_client_id'=>array(
                                                        'id'=>'application_client_id',
                                                        'label'=>'PayPal Application Client ID',
                                                        'type'=>'input',
                                                        'help'=>'Log into PayPal and Create An App to Get This ID.'
                                                     ),
                                                    'application_client_secret'=>array(
                                                        'id'=>'application_client_secret',
                                                        'label'=>'PayPal Application Client Secret',
                                                        'type'=>'input',
                                                        'help'=>'Log into PayPal and Create An App to Get This Code.'
                                                     ),
                                                  
                                                    'sales_item_description'=>array(
                                                        'id'=>'sales_item_description',
                                                        'label'=>'PayPal Item Name',
                                                        'type'=>'input',
                                                        'help'=>'This is the item name that will be be listed against the payment in your customers PayPal account.'
                                                     ),
                                              
                                                    'sandbox'=>array(
                                                        'id'=>'sandbox',
                                                        'label'=>'Use Sandbox/Testing Mode',
                                                        'type'=>'checkbox',
                                                        'help'=>'When this box is ticked all payments will be simulated using the PayPal sandbox website.'
                                                     )
                                                     )
                                                  )
                                          )
                              ),

              'tq_pro_paypal_transactions'=>array(
                              'key'=>'tq_pro_paypal_transactions',
                              'title'=>'PayPal Transactions',
                              'sections'=>array()
                             )

      );
  }

}?>