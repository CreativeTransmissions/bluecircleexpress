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
class TQ_LabelFetcher {

 	private $default_config = array('public'=>null);
 								

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
		$this->public = $this->config['public'];
		$this->currency = $this->public->get_currency_code();
        $this->tax_name = $this->public->get_setting('', 'tax_name', 'VAT');
	}


	public function fetch_labels_for_view($view = null){
		switch ($view) {
			case 'dashboard':			
				return $this->fetch_dashboard_view_labels();
				break;					
			case 'tq-pro-inline-display':			
				return $this->fetch_booking_view_labels();
				break;
			case 'email_customer':			
				return $this->fetch_customer_email_labels();
				break;
			case 'email_job_details':			
				return $this->fetch_booking_view_labels();
				break;					
			default:
				return $this->fetch_booking_view_labels();
			break;
		}
	}

	private function fetch_dashboard_view_labels(){
	return array(		'contact_section_title' => $this->public->get_setting('tq_pro_form_options','contact_section_title', 'Your Contact Information'),
						'search_section_title' => $this->public->get_setting('tq_pro_form_options','search_section_title', 'Enter Addresses'),
						'map_title' => $this->public->get_setting('tq_pro_form_options','map_title', 'Address Locations'),
						'quote_section_title' => $this->public->get_setting('tq_pro_form_options','quote_section_title', 'Cost'),
						
						'quote_label' => $this->public->get_setting('tq_pro_form_options','quote_label', 'Cost'),

        				'description' => $this->public->get_setting('tq_pro_form_options','job_info_label', 'Delivery Details'),
        				'collection_date_label' => $this->public->get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'),
        				'collection_time_label' => $this->public->get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'),
        				'collection_address_label' => $this->public->get_setting('tq_pro_form_options','collection_address_label', 'Collection Address'),
        				'destination_address_label' => $this->public->get_setting('tq_pro_form_options','destination_address_label', 'Destination Details'),
        				'cant_find_address_text'=> $this->public->get_setting('tq_pro_form_options', 'cant_find_address_text','I can&#39;t find my address.'),
        				'first_name' => $this->public->get_setting('tq_pro_form_options','first_name_label', 'First Name'),
        				'last_name' => $this->public->get_setting('tq_pro_form_options','last_name_label', 'Last Name'),
        				'phone' => $this->public->get_setting('tq_pro_form_options','phone_label', 'Phone Number'),
        				'email' => $this->public->get_setting('tq_pro_form_options','email_label', 'Email Address'),
						'service_id' => $this->public->get_setting('tq_pro_form_options','service_label', 'Service'),
						'view_service_link_text' => $this->public->get_setting('tq_pro_form_options','view_service_link_text', 'View Service Details...'),						
						'vehicle_id' => $this->public->get_setting('tq_pro_form_options','vehicle_label', 'Vehicle'),
						'view_vehicle_link_text' => $this->public->get_setting('tq_pro_form_options','view_vehicle_link_text', 'View Vehicle Details...'),						

						'journey_title' => $this->public->get_setting('tq_pro_form_options','journey_title', ''),
						'payment_info_header' => $this->public->get_setting('tq_pro_form_options','payment_info_header', ''),
						'distance' => $this->public->get_setting('tq_pro_form_options','distance_label', ''),						
						'time' => $this->public->get_setting('tq_pro_form_options','time_label', ''),
						'optimize_route_label' => $this->public->get_setting('tq_pro_form_options','optimize_route_label', ''),
						'deliver_and_return_label' => $this->public->get_setting('tq_pro_form_options','deliver_and_return_label', ''),
						'appartment_no' => $this->public->get_setting('tq_pro_form_options','appartment_no_label', ''),
						'street_number_label' => $this->public->get_setting('tq_pro_form_options','street_number_label', ''),
						'route_label' => $this->public->get_setting('tq_pro_form_options','route_label', 'Route'),
						'postal_town_label' => $this->public->get_setting('tq_pro_form_options','postal_town_label', ''),
						'administrative_area_level_2_label' => $this->public->get_setting('tq_pro_form_options','administrative_area_level_2_label', ''),
						'administrative_area_level_1_label' => $this->public->get_setting('tq_pro_form_options','administrative_area_level_1_label', ''),
						'country_label' => $this->public->get_setting('tq_pro_form_options','country_label', ''),
						'postal_code_label' => $this->public->get_setting('tq_pro_form_options','postal_code_label', ''),
						'date_and_time_title' => $this->public->get_setting('tq_pro_form_options','date_and_time_title', ''),
						'hourly_hire_rate_label' => $this->public->get_setting('tq_pro_form_options','hourly_hire_rate_label', ''),
						'hourly_rate_label' => $this->public->get_setting('tq_pro_form_options','hourly_rate_label', ''),
						'hourly_cost_label' => $this->public->get_setting('tq_pro_form_options','hourly_cost_label', ''),
						'contact_name' => $this->public->get_setting('tq_pro_form_options','contact_name_label', ''),
						'contact_phone_label' => $this->public->get_setting('tq_pro_form_options','contact_phone_label', ''),
						'short_notice_cost_label' => $this->public->get_setting('tq_pro_form_options','short_notice_cost_label', ''),
						'extra_destination_surcharge_label' => $this->public->get_setting('tq_pro_form_options','extra_destination_surcharge_label', 'Extra Destination Surcharge'),
						'sub_total_label'=>$this->public->get_setting('tq_pro_form_options','sub_total_label', 'Subtotal'),
						'days_hired_label' => $this->public->get_setting('tq_pro_form_options','days_hired_label', 'Days Hired'),
						'hours_hired_label' => $this->public->get_setting('tq_pro_form_options','hours_hired_label', 'Hours Hired'),
						'route_heading_label' => $this->public->get_setting('tq_pro_form_options','route_heading_label', 'Route'),
						'date_and_time_title' => $this->public->get_setting('tq_pro_form_options','date_and_time_title', 'Date and Time'),
						'delivery_cost_label' => $this->public->get_setting('tq_pro_form_options','delivery_cost_label', 'Delivery Cost'),
						'total_cost_label' => $this->public->get_setting('tq_pro_form_options','total_cost_label', 'Total Cost'),
						'tax_name' => $this->public->get_setting('tq_pro_form_options','tax_name', 'VAT'),
						'distance_cost'=> $this->public->get_setting('tq_pro_form_options','distance_cost_label', 'Distance Cost'),
 						'rate_hour'=>'Hourly Rate (' . $this->currency . ')',
                        'time_cost'=>'Time Cost (' . $this->currency . ')',
                        'basic_cost'=>'Subtotal (' . $this->currency . ')',
                        'rate_tax'=>$this->tax_name.' Rate (%)',
                        'tax_cost'=>$this->tax_name.' (' . $this->currency . ')',
                        'total'=>'Total (' . $this->currency . ')',
                        'rates'=>'Rates',
                    	'dispatch_stage_label'=>'Dispatch',
                    	'standard_stage_label'=>'Standard');
	}	

	private function fetch_booking_view_labels(){
	return array(		'contact_section_title' => $this->public->get_setting('tq_pro_form_options','contact_section_title', 'Your Contact Information'),
						'search_section_title' => $this->public->get_setting('tq_pro_form_options','search_section_title', 'Enter Addresses'),
						'map_title' => $this->public->get_setting('tq_pro_form_options','map_title', 'Address Locations'),
						'quote_section_title' => $this->public->get_setting('tq_pro_form_options','quote_section_title', 'Cost'),
						
						'quote_label' => $this->public->get_setting('tq_pro_form_options','quote_label', 'Cost'),

        				'description' => $this->public->get_setting('tq_pro_form_options','job_info_label', 'Delivery Details'),
        				'collection_date_label' => $this->public->get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'),
        				'collection_time_label' => $this->public->get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'),
        				'collection_address_label' => $this->public->get_setting('tq_pro_form_options','collection_address_label', 'Collection Address'),
        				'destination_address_label' => $this->public->get_setting('tq_pro_form_options','destination_address_label', 'Destination Details'),
        				'cant_find_address_text'=> $this->public->get_setting('tq_pro_form_options', 'cant_find_address_text','I can&#39;t find my address.'),
        				'first_name' => $this->public->get_setting('tq_pro_form_options','first_name_label', 'First Name'),
        				'last_name' => $this->public->get_setting('tq_pro_form_options','last_name_label', 'Last Name'),
        				'phone' => $this->public->get_setting('tq_pro_form_options','phone_label', 'Phone Number'),
        				'email' => $this->public->get_setting('tq_pro_form_options','email_label', 'Email Address'),
						'service_id' => $this->public->get_setting('tq_pro_form_options','service_label', 'Service'),
						'view_service_link_text' => $this->public->get_setting('tq_pro_form_options','view_service_link_text', 'View Service Details...'),						
						'vehicle_id' => $this->public->get_setting('tq_pro_form_options','vehicle_label', 'Vehicle'),
						'view_vehicle_link_text' => $this->public->get_setting('tq_pro_form_options','view_vehicle_link_text', 'View Vehicle Details...'),						

						'journey_title' => $this->public->get_setting('tq_pro_form_options','journey_title', ''),
						'payment_info_header' => $this->public->get_setting('tq_pro_form_options','payment_info_header', ''),
						'distance' => $this->public->get_setting('tq_pro_form_options','distance_label', ''),						
						'time' => $this->public->get_setting('tq_pro_form_options','time_label', ''),
						'optimize_route_label' => $this->public->get_setting('tq_pro_form_options','optimize_route_label', ''),
						'deliver_and_return_label' => $this->public->get_setting('tq_pro_form_options','deliver_and_return_label', ''),
						'address_label' => $this->public->get_setting('tq_pro_form_options','address_label', ''),
						'appartment_no_label' => $this->public->get_setting('tq_pro_form_options','appartment_no_label', ''),
						'street_number_label' => $this->public->get_setting('tq_pro_form_options','street_number_label', ''),
						'route_label' => $this->public->get_setting('tq_pro_form_options','route_label', 'Route'),
						'postal_town_label' => $this->public->get_setting('tq_pro_form_options','postal_town_label', ''),
						'administrative_area_level_2_label' => $this->public->get_setting('tq_pro_form_options','administrative_area_level_2_label', ''),
						'administrative_area_level_1_label' => $this->public->get_setting('tq_pro_form_options','administrative_area_level_1_label', ''),
						'country_label' => $this->public->get_setting('tq_pro_form_options','country_label', ''),
						'postal_code_label' => $this->public->get_setting('tq_pro_form_options','postal_code_label', ''),
						'date_and_time_title' => $this->public->get_setting('tq_pro_form_options','date_and_time_title', ''),
						'hourly_hire_rate_label' => $this->public->get_setting('tq_pro_form_options','hourly_hire_rate_label', ''),
						'hourly_rate_label' => $this->public->get_setting('tq_pro_form_options','hourly_rate_label', ''),
						'hourly_cost_label' => $this->public->get_setting('tq_pro_form_options','hourly_cost_label', ''),
						'contact_name_label' => $this->public->get_setting('tq_pro_form_options','contact_name_label', ''),
						'contact_phone_label' => $this->public->get_setting('tq_pro_form_options','contact_phone_label', ''),
						'short_notice_cost_label' => $this->public->get_setting('tq_pro_form_options','short_notice_cost_label', ''),
						'extra_destination_surcharge_label' => $this->public->get_setting('tq_pro_form_options','extra_destination_surcharge_label', 'Extra Destination Surcharge'),
						'sub_total_label'=>$this->public->get_setting('tq_pro_form_options','sub_total_label', 'Subtotal'),
						'days_hired_label' => $this->public->get_setting('tq_pro_form_options','days_hired_label', 'Days Hired'),
						'hours_hired_label' => $this->public->get_setting('tq_pro_form_options','hours_hired_label', 'Hours Hired'),
						'route_heading_label' => $this->public->get_setting('tq_pro_form_options','route_heading_label', 'Route'),
						'date_and_time_title' => $this->public->get_setting('tq_pro_form_options','date_and_time_title', 'Date and Time'),
						'delivery_cost_label' => $this->public->get_setting('tq_pro_form_options','delivery_cost_label', 'Delivery Cost'),
						'total_cost_label' => $this->public->get_setting('tq_pro_form_options','total_cost_label', 'Total Cost'),
						'tax_name' => $this->public->get_setting('tq_pro_form_options','tax_name', 'VAT'),
						'distance_cost'=> $this->public->get_setting('tq_pro_form_options','distance_cost_label', 'Distance Cost'),
 						'rate_hour'=>'Hourly Rate (' . $this->currency . ')',
                        'time_cost'=>'Time Cost (' . $this->currency . ')',
                        'basic_cost'=>'Subtotal (' . $this->currency . ')',
                        'rate_tax'=>$this->tax_name.' Rate (%)',
                        'tax_cost'=>$this->tax_name.' (' . $this->currency . ')',
                        'total'=>'Total (' . $this->currency . ')',
                        'rates'=>'Rates',
                    	'dispatch_stage_label'=>'Dispatch',
                    	'standard_stage_label'=>'Standard');
	}

	private function fetch_customer_email_labels(){
		return array(	'contact_details_header' => $this->public->get_setting('tq_pro_form_options','contact_section_title', 'Your Contact Information'),
						'quote_section_title' => $this->public->get_setting('tq_pro_form_options','quote_section_title', 'Cost'),
        				'description' => $this->public->get_setting('tq_pro_form_options','job_info_label', 'Delivery Details'),
        				'collection_date_label' => $this->public->get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'),
        				'collection_time_label' => $this->public->get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'),
        				'collection_address_label' => $this->public->get_setting('tq_pro_form_options','collection_address_label', 'Collection Address'),
        				'destination_address_label' => $this->public->get_setting('tq_pro_form_options','destination_address_label', 'Destination Details'),
        				'cant_find_address_text'=> $this->public->get_setting('tq_pro_form_options', 'cant_find_address_text','I can&#39;t find my address.'),
        				'first_name' => $this->public->get_setting('tq_pro_form_options','first_name_label', 'First Name'),
        				'last_name' => $this->public->get_setting('tq_pro_form_options','last_name_label', 'Last Name'),
        				'phone' => $this->public->get_setting('tq_pro_form_options','phone_label', 'Phone Number'),
        				'email' => $this->public->get_setting('tq_pro_form_options','email_label', 'Email Address'),
						'service_id' => $this->public->get_setting('tq_pro_form_options','service_label', 'Service'),
						'vehicle_id' => $this->public->get_setting('tq_pro_form_options','vehicle_label', 'Vehicle'),
						'journey_title' => $this->public->get_setting('tq_pro_form_options','journey_title', ''),
						'payment_info_header' => $this->public->get_setting('tq_pro_form_options','payment_info_header', ''),
						'distance' => $this->public->get_setting('tq_pro_form_options','distance_label', ''),						
						'time' => $this->public->get_setting('tq_pro_form_options','time_label', ''),
						'optimize_route_label' => $this->public->get_setting('tq_pro_form_options','optimize_route_label', ''),
						'deliver_and_return_label' => $this->public->get_setting('tq_pro_form_options','deliver_and_return_label', ''),
						'address_label' => $this->public->get_setting('tq_pro_form_options','address_label', ''),
						'appartment_no_label' => $this->public->get_setting('tq_pro_form_options','appartment_no_label', ''),
						'street_number_label' => $this->public->get_setting('tq_pro_form_options','street_number_label', ''),
						'route_label' => $this->public->get_setting('tq_pro_form_options','route_label', 'Route'),
						'postal_town_label' => $this->public->get_setting('tq_pro_form_options','postal_town_label', ''),
						'administrative_area_level_2_label' => $this->public->get_setting('tq_pro_form_options','administrative_area_level_2_label', ''),
						'administrative_area_level_1_label' => $this->public->get_setting('tq_pro_form_options','administrative_area_level_1_label', ''),
						'country_label' => $this->public->get_setting('tq_pro_form_options','country_label', ''),
						'postal_code_label' => $this->public->get_setting('tq_pro_form_options','postal_code_label', ''),
						'date_and_time_title' => $this->public->get_setting('tq_pro_form_options','date_and_time_title', ''),
						'hourly_hire_rate_label' => $this->public->get_setting('tq_pro_form_options','hourly_hire_rate_label', ''),
						'hourly_rate_label' => $this->public->get_setting('tq_pro_form_options','hourly_rate_label', ''),
						'hourly_cost_label' => $this->public->get_setting('tq_pro_form_options','hourly_cost_label', ''),
						'contact_name_label' => $this->public->get_setting('tq_pro_form_options','contact_name_label', ''),
						'contact_phone_label' => $this->public->get_setting('tq_pro_form_options','contact_phone_label', ''),
						'short_notice_cost_label' => $this->public->get_setting('tq_pro_form_options','short_notice_cost_label', ''),
						'extra_destination_surcharge_label' => $this->public->get_setting('tq_pro_form_options','extra_destination_surcharge_label', 'Extra Destination Surcharge'),
						'sub_total_label'=>$this->public->get_setting('tq_pro_form_options','sub_total_label', 'Subtotal'),
						'days_hired_label' => $this->public->get_setting('tq_pro_form_options','days_hired_label', 'Days Hired'),
						'hours_hired_label' => $this->public->get_setting('tq_pro_form_options','hours_hired_label', 'Hours Hired'),
						'route_heading_label' => $this->public->get_setting('tq_pro_form_options','route_heading_label', 'Route'),
						'date_and_time_title' => $this->public->get_setting('tq_pro_form_options','date_and_time_title', 'Date and Time'),
						'delivery_cost_label' => $this->public->get_setting('tq_pro_form_options','delivery_cost_label', 'Delivery Cost'),
						'total_cost_label' => $this->public->get_setting('tq_pro_form_options','total_cost_label', 'Total Cost'),
						'tax_name' => $this->public->get_setting('tq_pro_form_options','tax_name', 'VAT'),
						'distance_cost'=> $this->public->get_setting('tq_pro_form_options','distance_cost_label', 'Distance Cost'),
 						'rate_hour'=>'Hourly Rate (' . $this->currency . ')',
                        'time_cost'=>'Time Cost (' . $this->currency . ')',
                        'basic_cost'=>'Subtotal (' . $this->currency . ')',
                        'rate_tax'=>$this->tax_name.' Rate (%)',
                        'tax_cost'=>$this->tax_name.' (' . $this->currency . ')',
                        'total'=>'Total (' . $this->currency . ')',
                        'rates'=>'Rates',
                    	'dispatch_stage_label'=>'Dispatch',
                    	'standard_stage_label'=>'Standard');
	}	
}

