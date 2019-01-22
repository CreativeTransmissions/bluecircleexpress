<?php

/**
 * Define the admin structure
 *
 * @link       http://transitquote.co.uk
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 * @copyright 2016 Creative Transmissions
 */

namespace TransitQuote_Pro4;
class Admin_Config {

  public function __construct() {
    $this->debugging = false;
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
              'tq_pro_blocked_dates'=>array( 
                              'key'=>'tq_pro_blocked_dates',
                              'title'=>'Blocked Dates',
                              'table'=>'blocked_dates',
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

              'tq_pro_journey_lengths'=>array(
                              'key'=>'tq_pro_journey_lengths',
                              'title'=>'Journey Lengths',
                              'table'=>'journey_lengths',
                              'sections'=>array()
                              ),

              'tq_pro_form_options'=>array(
                              'key'=>'tq_pro_form_options',
                              'title'=>'Order Form',
                              'sections'=>array('pro_settings_form_options'=>array(
                                                'id'=>'pro_settings_form_options',
                                                'title'=>'Order Form Options',
                                                'fields'=>array(

                                                     'form_theme'=>array(
                                                        'id'=>'form_theme',
                                                        'label'=>'Form Theme',
                                                        'type'=>'select',
                                                        'options'=>array('Classic', 'Light'),
                                                        'default'=>'Light',
                                                        'help'=>'Please select a theme to change the appearance of the order form.'),
                                                      'form_color' => array(
                                                          'id' => 'form_color',
                                                          'label' => 'Form color',
                                                          'type' => 'input',
                                                          'help' => 'Enter the form color.',
                                                          'default' => '#3e80fa'), 
                                                      'title_background_color' => array(
                                                            'id' => 'title_background_color',
                                                            'label' => 'Titles background color',
                                                            'type' => 'input',
                                                            'help' => 'Select the color for titles background.',
                                                            'default' => '#e8e8e8'), 
                                                      'form_background_color' => array(
                                                              'id' => 'form_background_color',
                                                              'label' => 'Form background color',
                                                              'type' => 'input',
                                                              'help' => 'Select the form background color.',
                                                              'default' => '#cccccc'), 
                                                     'time_interval'=>array(
                                                        'id'=>'time_interval',
                                                        'label'=>'Time Picker Interval (min)',
                                                        'type'=>'select',
                                                        'options'=>array( 15, 30, 45, 60),
                                                        'default'=> 30,
                                                        'help'=>'Please select time interval for timepicker.'),

                                                      'booking_start_time' => array(
                                                          'id' => 'booking_start_time',
                                                          'label' => 'Booking Start Time (HH:MM AM)',
                                                          'type' => 'input',
                                                          'help' => 'Please enter the start time for booking.',
                                                          'default' => '07:00 AM'
                                                      ),

                                                      'booking_end_time' => array(
                                                          'id' => 'booking_end_time',
                                                          'label' => 'Booking End Time (HH:MM AM)',
                                                          'type' => 'input',
                                                          'help' => 'Please enter the end time for booking.',
                                                          'default' => '09:00 PM'
                                                      ), 

                                                      'form_section_order'=>array(
                                                        'id'=>'form_section_order',
                                                        'label'=>'Form Section Order',
                                                        'type'=>'select',
                                                        'options'=>array( 'Delivery Information', 'Customer Information', 'Quote Only'),
                                                        'default'=>'Delivery Information',
                                                        'help'=>'Please select the information that the customer will enter first.<br/>If you ask for Delivery Information first the customer will see their quote before having to enter their contact details. ,<br/>Quote Only will provide an on screen quote only with no booking section'),

                                                      'ask_for_postcode'=>array(
                                                        'id'=>'ask_for_postcode',
                                                        'label'=>'Ask For Postcode',
                                                        'type'=>'checkbox',
                                                        'default'=>1,
                                                        'help'=>'Ask the customer for a postal code in the order form.'),

                                                      'ask_for_unit_no'=>array(
                                                        'id'=>'ask_for_unit_no',
                                                        'label'=>'Ask For Unit No',
                                                        'type'=>'checkbox',
                                                        'default'=>1,
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
                                                        'default'=>0),

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
                                                        'default'=>0),
														
                          														'show_contact_name'=>array(
                          															'id'=>'show_contact_name',
                          															'label'=>'Show Contact Name',
                          															'type'=>'checkbox',
                          															'help'=>'If enabled, this option will display a Contact Name for destination',
                          															'default'=>0),
                        														
                          													   'show_contact_number'=>array(
                          															'id'=>'show_contact_number',
                          															'label'=>'Show Contact Number',
                          															'type'=>'checkbox',
                          															'help'=>'If enabled, this option will display a Contact Number for destination',
                          															'default'=>0),

                                                       'ask_for_date'=>array(
                                                        'id'=>'ask_for_date',
                                                        'label'=>'Ask For Date',
                                                        'type'=>'checkbox',
                                                        'help'=>'If enabled, the customer will be able to request a particular collection date in the main form.',
                                                        'default'=>1),

                                                        'ask_for_time'=>array(
                                                        'id'=>'ask_for_time',
                                                        'label'=>'Ask For Time',
                                                        'type'=>'checkbox',
                                                        'help'=>'If enabled, the customer will be able to request a particular collection time in the main form.',
                                                        'default'=>1)
                                                      )
                                                ),
                                                'pro_settings_form_labels'=>array(
                                                'id'=>'pro_settings_form_labels',
                                                'title'=>'Labels and Text',
                                                'fields'=>array(
                                                              'search_section_title'=>array(
                                                                  'id'=>'search_section_title',
                                                                  'label'=>'Search Section Title',
                                                                  'type'=>'input',
                                                                  'default'=>'Delivery Addresses',
                                                                  'help'=>'This will appear as a title above the address search boxes.'
                                                                ),

                                                                'collection_address_label'=>array(
                                                                  'id'=>'collection_address_label',
                                                                  'label'=>'Collection Address Label',
                                                                  'type'=>'input',
                                                                  'default'=>'Collection Address',
                                                                  'help'=>'This label will appears next to the first address search box.'
                                                                ),
                                                                
                                                                'destination_address_label'=>array(
                                                                    'id'=>'destination_address_label',
                                                                    'label'=>'Destination Address Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Destination Address',
                                                                    'help'=>'This label will appears next to the destination address search boxes.'
                                                                  
                                                                ),
                                                                  
                                                                'insert_destination_link'=>array(
                                                                    'id'=>'insert_destination_link',
                                                                    'label'=>'Insert Destination Link Text',
                                                                    'type'=>'input',
                                                                    'default'=>'Insert Destination...',
                                                                    'help'=>'This is the link text for inserting a new destination address picker.'
                                                                  
                                                                ),

                                                                'remove_destination_link'=>array(
                                                                    'id'=>'remove_destination_link',
                                                                    'label'=>'Remove Destination Link Text',
                                                                    'type'=>'input',
                                                                    'default'=>'Remove This Destination',
                                                                    'help'=>'This is the link text for removing a new destination address picker.'
                                                                ),


                                                                'cant_find_address_text'=>array(
                                                                    'id'=>'cant_find_address_text',
                                                                    'label'=>'I can&#39;t find my address Link Text',
                                                                    'type'=>'input',
                                                                    'default'=>'I can&#39;t find my address',
                                                                    'help'=>'This is the link for customers to click if Google does not have the address.'
                                                                ),

                                                              'appartment_no_label '=>array(
                                                                    'id'=>'appartment_no_label',
                                                                    'label'=>'Apartment/Unit No Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Unit No',
                                                                    'help'=>'This will be the label for Apartment/Unit No in address.'
                                                                ),

                                                              'postal_code_label'=>array(
                                                                    'id'=>'postal_code_label',
                                                                    'label'=>'Postal Code Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Postal Code',
                                                                    'help'=>'This will be the label for postal code in address.'
                                                                ),

                                                               'contact_name_label'=>array(
                                                                    'id'=>'contact_name_label',
                                                                    'label'=>'Contact Name Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Contact Name',
                                                                    'help'=>'This will be the label for contact name in location details.'
                                                                ),

                                                                'contact_phone_label'=>array(
                                                                    'id'=>'contact_phone_label',
                                                                    'label'=>'Contact Phone Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Contact Phone',
                                                                    'help'=>'This will be the label for contact phone in location details.'
                                                                ),                                                                
                                                
                                                                'collection_date_label'=>array(
                                                                  'id'=>'collection_date_label',
                                                                  'label'=>'Collection Date Label',
                                                                  'type'=>'input',
                                                                  'default'=>'Collection Date',
                                                                  'help'=>'This label will appears next to the date field.'
                                                                ),
                                                                
                                                                'collection_time_label'=>array(
                                                                  'id'=>'collection_time_label',
                                                                  'label'=>'Collection Time Label',
                                                                  'type'=>'input',
                                                                  'default'=>'Collection Time',
                                                                  'help'=>'This label will appears next to the time field.'
                                                                ),


                                                                'service_label'=>array(
                                                                    'id'=>'service_label',
                                                                    'label'=>'Service Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Service',
                                                                    'help'=>'This will be the label for the service drop down.'
                                                                ),

                                                                'view_service_link_text'=>array(
                                                                    'id'=>'view_service_link_text',
                                                                    'label'=>'View Service Link Text',
                                                                    'type'=>'input',
                                                                    'default'=>'View Service Details..',
                                                                    'help'=>'This will be the label for the view service link when service descriptions are enabled.'
                                                                  
                                                                ),

                                                                'vehicle_label'=>array(
                                                                    'id'=>'vehicle_label',
                                                                    'label'=>'Vehicle Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Vehicle',
                                                                    'help'=>'This will be the label for the vehicle drop down.'
                                                                  
                                                                ),

                                                                'view_vehicle_link_text'=>array(
                                                                    'id'=>'view_vehicle_link_text',
                                                                    'label'=>'View Vehicle Link Text',
                                                                    'type'=>'input',
                                                                    'default'=>'View Vehicle Details..',
                                                                    'help'=>'This will be the label for the view vehicle link when vehicle descriptions are enabled.'
                                                                  
                                                                ),

                                                                'map_title'=>array(
                                                                    'id'=>'map_title',
                                                                    'label'=>'Map Title',
                                                                    'type'=>'input',
                                                                    'default'=>'Address Locations',
                                                                    'help'=>'This will appear as a title above the map.'
                                                                  
                                                                ),                                                               

                                                                'contact_section_title'=>array(
                                                                    'id'=>'contact_section_title',
                                                                    'label'=>'Contact Section Title',
                                                                    'type'=>'input',
                                                                    'default'=>'Your Contact Information',
                                                                    'help'=>'This will appear as a title above the customer contact information fields.'
                                                                  
                                                                ),

                                                                'first_name_label'=>array(
                                                                    'id'=>'first_name_label',
                                                                    'label'=>'First Name Label',
                                                                    'type'=>'input',
                                                                    'default'=>'First Name',
                                                                    'help'=>'This will be the label for the customer first name form field.'
                                                                  
                                                                ),

                                                                'last_name_label'=>array(
                                                                    'id'=>'last_name_label',
                                                                    'label'=>'Last Name Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Last Name',
                                                                    'help'=>'This will be the label for the customer last name form field.'
                                                                  
                                                                ),

                                                                'phone_label'=>array(
                                                                    'id'=>'phone_label',
                                                                    'label'=>'Phone Number Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Phone Number',
                                                                    'help'=>'This will be the label for the customer telephone number form field.'
                                                                  
                                                                ),
                                                                'email_label'=>array(
                                                                    'id'=>'email_label',
                                                                    'label'=>'Email Address Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Email Address',
                                                                    'help'=>'This will be the label for the customer email address form field.'
                                                                  
                                                                ),

                                                                'job_info_label'=>array(
                                                                    'id'=>'job_info_label',
                                                                    'label'=>'Job Information Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Delivery Details',
                                                                    'help'=>'This will be the label for the large field for additional information.'
                                                                  
                                                                ),

                                                                'quote_section_title'=>array(
                                                                  'id'=>'quote_section_title',
                                                                  'label'=>'Quote Section Title',
                                                                  'type'=>'input',
                                                                  'default'=>'Quote',
                                                                  'help'=>'This will appear as a title above the quote section.'
                                                                ),

                                                                'quote_label'=>array(
                                                                  'id'=>'quote_label',
                                                                  'label'=>'Quote Label',
                                                                  'type'=>'input',
                                                                  'default'=>'Your Quote',
                                                                  'help'=>'This will appear above the qutoe in the quote section.'
                                                                ),                                                          

                                                                'sub_total_label'=>array(
                                                                    'id'=>'sub_total_label',
                                                                    'label'=>'Subtotal Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Subtotal',
                                                                    'help'=>'This will be the label for the cost before tax in the quote section.'
                                                                  
                                                                ),                                                                

                                                                'total_cost_label'=>array(
                                                                    'id'=>'total_cost_label',
                                                                    'label'=>'Total Cost Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Total Cost',
                                                                    'help'=>'This will be the label for the total cost in the quote sections.'
                                                                  
                                                                ),                                                        

                                                               'distance_label'=>array(
                                                                    'id'=>'distance_label',
                                                                    'label'=>'Distance Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Distance',
                                                                    'help'=>'This will be the label for the total journey distance.'
                                                                  
                                                                ),

                                                               'time_label'=>array(
                                                                    'id'=>'time_label',
                                                                    'label'=>'Estimated Travel Time Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Estimated Travel Time',
                                                                    'help'=>'This will be the label for the estimated travel time.'
                                                                  
                                                                ),  

                                                                'short_notice_cost_label'=>array(
                                                                    'id'=>'short_notice_cost_label',
                                                                    'label'=>'Short Notice Cost Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Short Notice Cost',
                                                                    'help'=>'This will be the label for short notice cost.'
                                                                )                                                               

                                                          /*     
                                                                'route_heading_label'=>array(
                                                                    'id'=>'route_heading_label',
                                                                    'label'=>'Route Title',
                                                                    'type'=>'input',
                                                                    'default'=>'Route',
                                                                    'help'=>'This will be the title for the route list.'
                                                                  
                                                                ),     

                                                                'payment_info_header'=>array(
                                                                    'id'=>'payment_info_header',
                                                                    'label'=>'Payment Information Title',
                                                                    'type'=>'input',
                                                                    'default'=>'Payment Information',
                                                                    'help'=>'This will be the title for the Payment Information section.'
                                                                  
                                                                ),

                                                               'journey_title'=>array(
                                                                    'id'=>'journey_title',
                                                                    'label'=>'journey Information Title',
                                                                    'type'=>'input',
                                                                    'default'=>'Date and Time',
                                                                    'help'=>'This will be the label for the journey information section.'
                                                                  
                                                                ),      

                                                               'optimize_route_label '=>array(
                                                                    'id'=>'optimize_route_label',
                                                                    'label'=>'Optimize Route Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Fastest Route',
                                                                    'help'=>'This will be the label for the fastest or direct route (Yes = route has been optmized by Google Directions)'
                                                                ),

                                                               'deliver_and_return_label '=>array(
                                                                    'id'=>'deliver_and_return_label',
                                                                    'label'=>'Return Journey Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Return Journey',
                                                                    'help'=>'This will be the label for return journey (Yes = quote includes journey back to start location)'
                                                                ),                                                                

                                                               'address_label '=>array(
                                                                    'id'=>'address_label',
                                                                    'label'=>'Address Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Address',
                                                                    'help'=>'This will be the label for full formatted address'
                                                                ),

                                                              'street_number_label '=>array(
                                                                    'id'=>'street_number_label',
                                                                    'label'=>'Building No Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Building No',
                                                                    'help'=>'This will be the label for Building Number in address.'
                                                                ),

                                                              'route_label'=>array(
                                                                    'id'=>'route_label',
                                                                    'label'=>'Street Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Street',
                                                                    'help'=>'This will be the label for Street in address.'
                                                                ),                                                              

                                                              'postal_town_label'=>array(
                                                                    'id'=>'postal_town_label',
                                                                    'label'=>'Postal Town Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Postal Town',
                                                                    'help'=>'This will be the label for postal town in address.'
                                                                ),                                                              

                                                              'administrative_area_level_2_label'=>array(
                                                                    'id'=>'administrative_area_level_2_label',
                                                                    'label'=>'Area Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Area',
                                                                    'help'=>'This will be the label for area in address.'
                                                                ),                                                              

                                                              'administrative_area_level_1_label'=>array(
                                                                    'id'=>'administrative_area_level_1_label',
                                                                    'label'=>'Region Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Region',
                                                                    'help'=>'This will be the label for region in address.'
                                                                ),

                                                              'country_label'=>array(
                                                                    'id'=>'country_label',
                                                                    'label'=>'Country Label',
                                                                    'type'=>'input',
                                                                    'default'=>'Country',
                                                                    'help'=>'This will be the label for country in address.'
                                                                ),
                                                               'date_and_time_title'=>array(
                                                                    'id'=>'date_and_time_title',
                                                                    'label'=>'Date and Time Title',
                                                                    'type'=>'input',
                                                                    'default'=>'Date and Time',
                                                                    'help'=>'This will be the label for the date and time section.'
                                                                  
                                                                )*/
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
                                                      'label'=>'Google Maps API Key',
                                                      'type'=>'input'),
                                                    'distance_unit'=>array(
                                                      'id'=>'distance_unit',
                                                      'label'=>'Distance Unit',
                                                      'type'=>'select',
                                                      'options'=>array('Kilometer', 'Mile'),
                                                      'default'=>'Kilometer'),
                                                    'transportation_mode'=>array(
                                                      'id'=>'transportation_mode',
                                                      'label'=>'Transportation Mode',
                                                      'type'=>'select',
                                                      'options'=>array('Driving', 'Walking', 'Cycling'),
                                                      'default'=>'Driving'),                                                    
                                                    'start_location'=>array(
                                                      'id'=>'start_location',
                                                      'label'=>'Business Address',
                                                      'type'=>'addresspicker',
                                                      'help'=>'The selected place should be your business address or the center of your operating area. The place search results that your customers recieve will be places closest to your business address. You can further restrict this by setting a search radius.'),
                                                    'restrict_to_country'=>array(
                                                      'id'=>'restrict_to_country',
                                                      'label'=>'Restrict To Country',
                                                      'type'=>'checkbox',
                                                      'default'=>0,
                                                      'help'=>'When this box is checked, customers will only be able to choose addresses in the same country as your Business Address'),                                              
                                                    'search_radius'=>array(
                                                      'id'=>'search_radius',
                                                      'label'=>'Search Radius',
                                                      'type'=>'input',
                                                      'help'=>'Restrict search results to within a radius of your business address.'),
                                                    'pick_start_address'=>array(
                                                      'id'=>'pick_start_address',
                                                      'label'=>'Allow customer to choose collection location',
                                                      'type'=>'checkbox',
                                                      'help'=>'When this box is ticked the customer can choose the collection address. Untick to use the same starting address for all jobs. For example: Untick if you are always delivering from your start address to the customers address.',
                                                      'default'=>1),
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
                                                        'help'=>'Please select the currency used for quotes and payments.'),

                                                      'custom_currency_code'=>array(
                                                        'id'=>'custom_currency_code',
                                                        'label'=>'Custom Currency Code',
                                                        'type'=>'input',
                                                        'help'=>'If your currency is not in the above list but you know it is accepted by WooCommerce you can enter the currency code (for example GBP or USD) here and it will be used instead.'),

                                                      'custom_currency_symbol'=>array(
                                                        'id'=>'custom_currency_symbol',
                                                        'label'=>'Custom Currency Symbol',
                                                        'type'=>'input',
                                                        'help'=>'If your currency is not in the above list but you know it is accepted by WooCommerce you can enter the currency symbol (for example $ or £) here and it will be used instead.'),

                                                      'tax_rate'=>array(
                                                        'id'=>'tax_rate',
                                                        'label'=>'Tax Rate',
                                                        'type'=>'input',
                                                        'default'=>0,
                                                        'help'=>'Please enter the percentage to add for tax. Leave this as 0 if you do not wish to add tax to the quote.'),

                                                      'tax_name'=>array(
                                                        'id'=>'tax_name',
                                                        'label'=>'Tax Name',
                                                        'type'=>'input',
                                                        'default'=>'VAT',
                                                        'help'=>'Please enter name of the tax to display.'),


                                                      'max_address_pickers'=>array(
                                                        'id'=>'max_address_pickers',
                                                        'label'=>'Maximum Destinations',
                                                        'type'=>'input',
                                                        'help'=>'Customers can request one or more destinations as part of the same job. If multiple destinations are allowed you can enter a number to limit the number of stops on one route.',
                                                        'default'=>3),
                                                  
                                                      'show_deliver_and_return'=>array(
                                                        'id'=>'show_deliver_and_return',
                                                        'label'=>'Charge for  Return Journey',
                                                        'type'=>'select',
                                                        'options'=>array('Always', 'Never', 'Ask'),
                                                        'help'=>'Choose whether or not to include the return journey from the final drop off address back to the collection address. If Ask is selected customers see deliver and return as an option.',
                                                        'default'=>'Never'),

                                                      'return_journey_adjustment'=>array(
                                                        'id'=>'return_journey_adjustment',
                                                        'label'=>'Return Journey Adjustment',
                                                        'type'=>'input',
                                                        'help'=>'Enter a percentage to apply to the return journey cost',
                                                        'default'=>100),

                                                      'show_driving_time'=>array(
                                                        'id'=>'show_driving_time',
                                                        'label'=>'Show Estimated Travel Time',
                                                        'type'=>'checkbox',
                                                        'help'=>'If enabled, this option will show the driving time for the delivery route as estimated by Google.',
                                                        'default'=>1),
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
                                                        'default'=>'Sorry, we are unable to accept jobs below our minimum price.'),
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
                                                        'default'=>'Sorry, we are unable to accept jobs below our minimum distance.'
                                                      ),
                                                      'max_distance'=>array(
                                                        'id'=>'max_distance',
                                                        'label'=>'Maximum Distance Accepted',
                                                        'type'=>'input',
                                                        'help'=>'If you do not wish to accept jobs longer than a specific distance, enter the distance here and the customer will not be able to make a booking.',
                                                        'default'=>0
                                                      ),
                                                      'max_distance_message'=>array(
                                                        'id'=>'max_distance_message',
                                                        'label'=>'Maximum Distance Message',
                                                        'type'=>'textarea',
                                                        'help'=>'This message will be displyed when a customer attempts to book a job longer than the maximum distance.',
                                                        'default'=>'Sorry, we are unable to accept jobs over our maximum distance.'
                                                      ),
                                                       'min_travel_time'=>array(
                                                        'id'=>'min_travel_time',
                                                        'label'=>'Minimum Travel Time Accepted (hours)',
                                                        'type'=>'input',
                                                        'help'=>'If you do not wish to accept jobs that take less than a specific time, enter the number of hours here and the customer will not be able to make a booking.',
                                                        'default'=>0
                                                      ),
                                                      'min_travel_time_message'=>array(
                                                        'id'=>'min_travel_time_message',
                                                        'label'=>'Minimum Travel Time Message',
                                                        'type'=>'textarea',
                                                        'help'=>'This message will be displyed when a customer attempts to book a job where the estimated travel time is less than the minimum travel time allowed.',
                                                        'default'=>'Sorry, we are unable to accept jobs that will take less than our minimum travel time.'
                                                      ),
                                                      'max_travel_time'=>array(
                                                        'id'=>'max_travel_time',
                                                        'label'=>'Maximum Travel Time Accepted (hours)',
                                                        'type'=>'input',
                                                        'help'=>'If you do not wish to accept jobs longer than a specific distance, enter the distance here and the customer will not be able to make a booking.',
                                                        'default'=>0
                                                      ),
                                                      'max_travel_time_message'=>array(
                                                        'id'=>'max_travel_time_message',
                                                        'label'=>'Maximum Travel Time Message',
                                                        'type'=>'textarea',
                                                        'help'=>'This message will be displyed when a customer attempts to book a job where the estimated travel time is longer than the maximum travel time allowed.',
                                                        'default'=>'Sorry, we are unable to accept jobs that will take longer than our maximum travel time.'
                                                      ),
                                                      'success_message'=>array(
                                                        'id'=>'success_message',
                                                        'label'=>'Success Message',
                                                        'type'=>'textarea',
                                                        'help'=>'Please enter the message that will be displayed to the customer after their quote has been saved and displayed on screen. This should explain any next steps they must take to confirm their booking.',
                                                        'default'=>'Thank you for your order. We will be in touch to confirm your order as soon as possible.'
                                                      ),
                                                      'quote_element'=>array(
                                                        'id'=>'quote_element',
                                                        'label'=>'Quote Display Element',
                                                        'help'=>'Please enter the class or id of the html element in which to display the final quote.<br/>Note that by specifying a class you can have the quote amount appear in multiple elements such as a visible element for displaying to the customer and a hidden form element for saving the amount.',
                                                        'type'=>'input',
                                                        'default'=>'quote'
													  ),
													  'round_of_currency'=>array(
                                                        'id'=>'round_of_currency',
                                                        'label'=>'Round off Currency',
                                                        'type'=>'select',
                                                        'options'=>array('Round to 2 decimal points','Round to 1 decimal points','Round to integer','Round to nearest 10','Round to nearest 100'),
                                                        'help'=>'Option to choose how much to round the currency.Default is 2 decimal points',
                                                        'default'=>'Round to 2 decimal points'
                                                      ),
													   'select_page_my_quotes'=>array(
															'id'=>'select_page_my_quotes',
															'label'=>'Select My Quote Page',
															'type'=>'select',
															'options'=> self::redirect_page_after_payment_list(),
															'id_field'=>'ID',
															'display_field'=>'post_title'
													 )
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
                              'title'=>'Payment Options',
                              'sections'=>array('tq_pro_paypal_options'=>array(
                                                  'id'=>'pro_settings_paypal_options',
                                                  'title'=>'Payment Options',
                                                  'fields'=>array(
                                                    'payment_types'=>array(
                                                        'id'=>'payment_types',
                                                        'label'=>'Accepted Payment Methods',
                                                        'type'=>'select',
                                                        'table'=>'payment_types',
                                                        'display_field'=>'name',
                                                        'id_field'=>'id',
                                                        'query'=>array('available'=>1),
                                                        'type'=>'checkgroup',
                                                        'help'=>'Your customers will only be able to select the payment methods that are selected above.'
                                                     ),
                                                   
                                                    'sales_item_description'=>array(
                                                        'id'=>'sales_item_description',
                                                        'label'=>'Invoice Item Name',
                                                        'type'=>'input',
                                                        'help'=>'This is the item name that will be be listed against the payment in your customers PayPal account or in WooCommerce.',
                                                        'default'=>'Delivery'
                                                     ),
													 
												                          	'disable_cart'=>array(
                                                        'id'=>'disable_cart',
                                                        'label'=>'Disable Cart for Checkout',
                                                        'type'=>'checkbox',
                                                        'help'=>'When this is checked cart will be disabled for users (userful for non ecommerce site).',
                                                        'default'=>1
                                                     ),
													 
                          													 'redirect_page_after_payment'=>array(
                          															'id'=>'redirect_page_after_payment',
                          															'label'=>'Woocommerce Success Redirect',
                          															'type'=>'select',
                          															'options'=> self::redirect_page_after_payment_list(),
                          															'id_field'=>'ID',
                          															'display_field'=>'post_title'
                          													 ),

                                                    'woocommerce_include_tax'=>array(
                                                      'id'=>'woocommerce_include_tax',
                                                      'label'=>'Include Tax In WooCommerce Price',
                                                      'type'=>'checkbox',
                                                      'help'=>'When this box is ticked, the quote total inclusive of tax is provided to the WooCommerce checkout as the transportation price. If you would like WooCommerce to calculate tax instead of TransitQuote, untick this box.',
                                                      'default'=>1),

                                                     'woo_product_id'=>array(
                                                        'id'=>'woo_product_id',
                                                        'label'=>'WooCommerce Product ID',
                                                        'type'=>'input',
                                                        'help'=>'This is the WooCommerce product id that will be used to bill your customers. Changing this setting manually is not recommended.'
                                                     ),
                          													 
													 'payment_button_name'=>array(
                                                        'id'=>'payment_button_name',
                                                        'label'=>'Woocommerce Payment Button Name',
                                                        'type'=>'input',
                                                        'default'=>'Pay Online'
                                                     ),
													 'payment_button_on_delivery_name'=>array(
                                                        'id'=>'payment_button_on_delivery_name',
                                                        'label'=>'On Delivery Payment Button Name',
                                                        'type'=>'input',
                                                        'default'=>'Book Now'
                                                     ),
                                                     )
                                                  )
                                          )
                              )

      );
  }

  public static function redirect_page_after_payment_list(){
  $page_value = array();
  $page = get_pages();
  foreach( $page as $key => $value ){
    $page_value[$key] = array();
    $page_value[$key]['ID'] = $value->ID;
    $page_value[$key]['post_title'] = $value->post_title;
  }
  return $page_value;
  }
 
}?>