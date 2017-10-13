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

namespace TransitQuote_Pro3;
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

              'tq_pro_form_options'=>array(
                              'key'=>'tq_pro_form_options',
                              'title'=>'Order Form',
                              'sections'=>array('pro_settings_form_options'=>array(
                                                'id'=>'pro_settings_form_options',
                                                'title'=>'Order Form Options',
                                                'fields'=>array(
                                                    
                                                      'form_section_order'=>array(
                                                        'id'=>'form_section_order',
                                                        'label'=>'Form Section Order',
                                                        'type'=>'select',
                                                        'options'=>array('Customer Information', 'Delivery Information'),
                                                        'default'=>'Delivery Information',
                                                        'help'=>'Please select the information that the customer will enter first.<br/>If you ask for Delivery Information first the customer will see their quote before having to enter their contact details.'),

                                                      'ask_for_postcode'=>array(
                                                        'id'=>'ask_for_postcode',
                                                        'label'=>'Ask For Postcode',
                                                        'type'=>'checkbox',
                                                        'default'=>0,
                                                        'help'=>'Ask the customer for a postal code in the order form.'),

                                                      'ask_for_unit_no'=>array(
                                                        'id'=>'ask_for_unit_no',
                                                        'label'=>'Ask For Unit No',
                                                        'type'=>'checkbox',
                                                        'default'=>0,
                                                        'help'=>'Ask the customer for a unit/appartment number.'),

                                                      'show_vehicle_description'=>array(
                                                        'id'=>'show_vehicle_description',
                                                        'label'=>'Show Vehicle Description',
                                                        'type'=>'checkbox',
                                                        'help'=>'If enabled, this option will display the description of the selected vehicle as entered on the Vehicles tab.<br/>The description will change if the customer changes the vehicle selection drop down.',
                                                        'default'=>0),

                                                      'show_vehicle_link'=>array(
                                                        'id'=>'show_vehicle_link',
                                                        'label'=>'Show Vehicle Link',
                                                        'type'=>'checkbox',
                                                        'help'=>'If enabled, this option will display a link to another page on your website which should provide your customer with more information about the selected vehicle.<br/>The link address will be based on the vehicle name as entered on the Vehicles tab with hyphens (-) instead of spaces.<br/>The link will change if the customer changes the vehicle selection drop down.',
                                                        'default'=>0)/*,

                                                      'show_service_description'=>array(
                                                        'id'=>'show_service_description',
                                                        'label'=>'Show Service Description',
                                                        'type'=>'checkbox',
                                                        'help'=>'If enabled, this option will display the description of the selected service as entered on the Services tab.<br/>The description will change if the customer changes the service selection drop down.',
                                                        'default'=>0),

                                                      'show_service_link'=>array(
                                                        'id'=>'show_service_link',
                                                        'label'=>'Show Service Link',
                                                        'type'=>'checkbox',
                                                        'help'=>'If enabled, this option will display a link to another page on your website which should provide your customer with more information about the selected service.<br/>The link address will be based on the service name as entered on the Service tab with hyphens (-) instead of spaces.<br/>The link will change if the customer changes the service selection drop down.',
                                                        'default'=>0)*/
                                                    )
                                                )
                                        )
                                
               ),

              'tq_pro_map_options'=>array(
                              'key'=>'tq_pro_map_options',
                              'title'=>'Map Options',
                              'sections'=>array('pro_settings_map_options'=>array(
                                                  'id'=>'pro_settings_map_options',
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
                                                      'options'=>array('Kilometer', 'Mile'),
                                                      'default'=>'Kilometer'),
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
                              'sections'=>array('pro_settings_quote_options'=>array(
                                                'id'=>'pro_settings_quote_options',
                                                'title'=>'Quote Options',
                                                'fields'=>array(
                                                    
                                                      'currency'=>array(
                                                        'id'=>'currency',
                                                        'label'=>'Currency',
                                                        'type'=>'select',
                                                        'table'=>'currencies',
                                                        'display_field'=>'name',
                                                        'id_field'=>'id',
                                                        'default'=>18,
                                                        'help'=>'Please select the currency used for quotes and PayPal payments.'),
                                                      'max_address_pickers'=>array(
                                                        'id'=>'max_address_pickers',
                                                        'label'=>'Maximum Destinations',
                                                        'type'=>'input',
                                                        'help'=>'Customers can request one or more destinations as part of the same job. If multiple destinations are allowed you can enter a number to limit the number of stops on one route.',
                                                        'default'=>3),
                                                      'min_notice'=>array(
                                                        'id'=>'min_notice',
                                                        'label'=>'Minimum Notice Period (HH:MM)',
                                                        'type'=>'input',
                                                        'help'=>'Please enter minimum notice period before which an additional charge is incurred.'),
                                                      'min_notice_charge'=>array(
                                                        'id'=>'min_notice_charge',
                                                        'label'=>'Minimum Notice Charge',
                                                        'type'=>'input',
                                                        'help'=>'Please enter the additional charge for jobs booked within 24 hours..',
                                                        'default'=>0),
                                                      'min_price'=>array(
                                                        'id'=>'min_price',
                                                        'label'=>'Minimum Price Accepted',
                                                        'type'=>'input',
                                                        'help'=>'If you do not wish to accept jobs below a certain price, enter the minimum price here and the customer will not be able to make a booking.',
                                                        'default'=>0),
                                                      'min_price_message'=>array(
                                                        'id'=>'min_price_message',
                                                        'label'=>'Minimum Price Message',
                                                        'type'=>'textarea',
                                                        'help'=>'This message will be displyed when a customer attempts to book a job below the minimum price.',
                                                      'default'=>'Sorry, we are unable to accept jobs below our minimum price. Please contact us if you need any further assistance.'),
                                                      'min_distance'=>array(
                                                        'id'=>'min_distance',
                                                        'label'=>'Minimum Distance Accepted',
                                                        'type'=>'input',
                                                        'help'=>'If you do not wish to accept jobs shorter than a specific distance, enter the distance here and the customer will not be able to make a booking.',
                                                        'default'=>0),
                                                      'min_distance_message'=>array(
                                                        'id'=>'min_distance_message',
                                                        'label'=>'Minimum Distance Message',
                                                        'type'=>'textarea',
                                                        'help'=>'This message will be displyed when a customer attempts to book a job below the minimum distance.',
                                                      'default'=>'Sorry, we are unable to accept jobs below our minimum distance. Please contact us if you need any further assistance.'),
                                                      'success_message'=>array(
                                                        'id'=>'success_message',
                                                        'label'=>'Success Message',
                                                        'type'=>'textarea',
                                                        'help'=>'Please enter the message that will be displayed to the customer after their quote has been saved and displayed on screen. This should explain any next steps they must take to confirm their booking.',
                                                        'default'=>'Thank you for your order. We will be in touch to confirm your order as soon as possible.'),
                                                      'quote_element'=>array(
                                                        'id'=>'quote_element',
                                                        'label'=>'Quote Display Element',
                                                        'help'=>'Please enter the class or id of the html element in which to display the final quote.<br/>Note that by specifying a class you can have the quote amount appear in multiple elements such as a visible element for displaying to the customer and a hidden form element for saving the amount.',
                                                        'type'=>'input',
                                                        'default'=>'quote')
                                                    )
                                                )

                                )
               ),
              'tq_pro_email_options'=>array(
                              'key'=>'tq_pro_email_options',
                              'title'=>'Email Options',
                              'sections'=>array('pro_settings_email_options'=>array(
                                                  'id'=>'pro_settings_email_options',
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
                                                        'help'=>'Please enter the <em>contact or business name</em> that customers will recieve their quote emails from.<br/>Example: <b>TransitQuote Customer Service</b>',
                                                        'default'=>'Your Business Name'),
                                                      'customer_subject'=>array(
                                                        'id'=>'customer_subject',
                                                        'label'=>'Customer Quote Email Subject',
                                                        'type'=>'input',
                                                        'help'=>'Please enter the email subject for customer quote emails.<br/>Example: <b>Your Tranporation Quote</b>',
                                                        'default'=>'Your Tranporation Quote'),
                                                      'customer_message'=>array(
                                                        'id'=>'customer_message',
                                                        'label'=>'Customer Quote Email Message',
                                                        'type'=>'textarea',
                                                        'help'=>'Please enter the message to your customer that will appear above the journey details and quote.',
                                                        'default'=>'Thank you for your order. Your tranporation details and quote are below.')
                                                    )
                                              ))
                              ),

              'tq_pro_paypal_options'=>array(
                              'key'=>'tq_pro_paypal_options',
                              'title'=>'PayPal Options',
                              'sections'=>array('tq_pro_paypal_options'=>array(
                                                  'id'=>'pro_settings_paypal_options',
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
                                                        'help'=>'When this box is ticked all payments will be simulated using the PayPal sandbox website.',
                                                        'default'=>1
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