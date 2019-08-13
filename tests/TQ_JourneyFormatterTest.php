<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_JourneyFormatterTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

        $this->example_labels = json_decode('{"contact_section_title":"Your Contact Information","search_section_title":"Delivery Addresses","map_title":"Address Locations","quote_section_title":"Quote","quote_label":"Your Quote","job_info_label":"Delivery Details","collection_date_label":"Collection Date","collection_time_label":"Collection Time","collection_address_label":"Collection Address","destination_address_label":"Destination Address","cant_find_address_text":"I cant find my address","first_name":"First Name","last_name":"Last Name","phone":"Phone Number","email":"Email Address","service_label":"Service","view_service_link_text":"View Service Details..","vehicle_label":"Vehicle","view_vehicle_link_text":"View Vehicle Details..","journey_title":"","payment_info_header":"","distance":"Distance","time":"Estimated Travel Time","optimize_route_label":"","deliver_and_return_label":"","appartment_no":"Unit No","street_number_label":"","route_label":"","postal_town_label":"","administrative_area_level_2_label":"","administrative_area_level_1_label":"","country_label":"","postal_code_label":"Postal Code","date_and_time_title":"Date and Time","hourly_hire_rate_label":"","hourly_rate_label":"","hourly_cost_label":"","contact_name":"Contact Name","contact_phone":"Contact Phone","short_notice_cost_label":"Short Notice Cost","extra_destination_surcharge_label":"Extra Destination Surcharge","sub_total_label":"Subtotal","days_hired_label":"Days Hired","hours_hired_label":"Hours Hired","route_heading_label":"Route","delivery_cost_label":"Delivery Cost","total_cost_label":"Total Cost","tax_name":"VAT","distance_cost":"Distance Cost","rate_hour":"Hourly Rate (GBP)","time_cost":"Time Cost (GBP)","basic_cost":"Subtotal (GBP)","rate_tax":"VAT Rate (%)","tax_cost":"VAT (GBP)","total":"Total (GBP)","rates":"Rates"}', true);

        $this->example_journey = json_decode('{"id":"13","job_id":"13","distance":"665.0500","time":"6.81","deliver_and_return":null,"optimize_route":null,"created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13"}', true);

        $this->example_journey_2 = json_decode('{"id":"13","job_id":"13","distance":"665.0500","time":"","deliver_and_return":null,"optimize_route":null,"created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13"}', true);

        $this->expected_output_1 = json_decode('[{"name":"distance","label":"Distance (Miles)","value":"665.05","type":"number"},{"name":"time","label":"Estimated Travel Time (Hours)","value":"6.81","type":"number"}]', true);   

        $this->expected_output_1_not_empty = json_decode('[{"name":"distance","label":"Distance (Miles)","value":"665.05","type":"number"}]', true);     

        $this->example_config = json_decode('{"journey":{"id":"13","job_id":"13","distance":"665.0500","time":"6.81","deliver_and_return":null,"optimize_route":null,"created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13"},"labels":{"contact_details_header":"Your Contact Information","quote_section_title":"Quote","description":"Delivery Details","collection_date_label":"Collection Date","collection_time_label":"Collection Time","collection_address_label":"Collection Address","destination_address_label":"Destination Address","cant_find_address_text":"I cant find my address","first_name":"First Name","last_name":"Last Name","phone":"Phone Number","email":"Email Address","service_id":"Service","vehicle_id":"Vehicle","journey_title":"","payment_info_header":"","distance":"Distance","time":"Estimated Travel Time","optimize_route_label":"","deliver_and_return_label":"","address_label":"","appartment_no_label":"Unit No","street_number_label":"","route_label":"Route","postal_town_label":"","administrative_area_level_2_label":"","administrative_area_level_1_label":"","country_label":"","postal_code_label":"Postal Code","date_and_time_title":"Date and Time","hourly_hire_rate_label":"","hourly_rate_label":"","hourly_cost_label":"","contact_name_label":"Contact Name","contact_phone_label":"Contact Phone","short_notice_cost_label":"Short Notice Cost","extra_destination_surcharge_label":"Extra Destination Surcharge","sub_total_label":"Subtotal","days_hired_label":"Days Hired","hours_hired_label":"Hours Hired","route_heading_label":"Route","delivery_cost_label":"Delivery Cost","total_cost_label":"Total Cost","tax_name":"VAT","distance_cost":"Distance Cost","rate_hour":"Hourly Rate (GBP)","time_cost":"Time Cost (GBP)","basic_cost":"Subtotal (GBP)","rate_tax":"VAT Rate (%)","tax_cost":"VAT (GBP)","total":"Total (GBP)","rates":"Rates"},"distance_unit":"Mile"}', true);

        $this->example_config_expected_output = json_decode('[{"name":"distance","label":"Distance (Miles)","value":"665.05","type":"number"},{"name":"time","label":"Estimated Travel Time (Hours)","value":"6.81","type":"number"}]', true);
    }
   
    public function test_format() {

    	$formatter_config = array( 'journey'=>$this->example_journey,
                                    'labels'=>$this->example_labels,
                                    'distance_unit'=>'Mile');
                                                    
        $this->formatter = new TransitQuote_Pro4\TQ_JourneyFormatter($formatter_config);
        $output = $this->formatter->format();

        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(2, $output, ' not 2 elements');

        foreach ($output as $field) {
        	$this->assertArrayHasKey('name' ,$field);
        	$this->assertArrayHasKey('type' ,$field);
        	$this->assertArrayHasKey('value' ,$field);
        };
        $this->assertEquals($output, $this->expected_output_1);

    }

    public function test_format_not_empty_only() {

        $formatter_config = array( 'journey'=>$this->example_journey_2,
                                    'labels'=>$this->example_labels,
                                    'distance_unit'=>'Mile');

        $this->formatter = new TransitQuote_Pro4\TQ_JourneyFormatter($formatter_config);

        $output = $this->formatter->format_not_empty_only();
        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(1, $output, ' not 1 elements');


        foreach ($output as $field) {
            $this->assertArrayHasKey('name' ,$field);
            $this->assertArrayHasKey('type' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };
        
        $this->assertEquals($output, $this->expected_output_1_not_empty);
    }    

    public function test_format_2() {

        $formatter_config = $this->example_config;
   
        $this->formatter = new TransitQuote_Pro4\TQ_JourneyFormatter($formatter_config);

        $output = $this->formatter->format();
        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(2, $output, ' not 2 elements');


        foreach ($output as $field) {
            $this->assertArrayHasKey('name' ,$field);
            $this->assertArrayHasKey('type' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };
        
        $this->assertEquals($output, $this->example_config_expected_output);
    }    
}    

?>