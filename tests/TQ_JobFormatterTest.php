<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_JobFormatterTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

        $this->test_services_1 = json_decode('{"1":{"id":"1","name":"Standard","description":"Standard rates and turnaround apply.","amount":"0.00","created":"0000-00-00 00:00:00","modified":"2019-07-31 10:24:37"}}',true);

        $this->test_vehicles_1 = json_decode('{"1":{"id":"1","name":"Van","description":"Standard delivery vehicle.","amount":"0.00","created":"0000-00-00 00:00:00","modified":"2019-07-31 10:24:37"}}',true);

        $this->example_labels = json_decode('{"contact_section_title":"Your Contact Information","search_section_title":"Delivery Addresses","map_title":"Address Locations","quote_section_title":"Quote","quote_label":"Your Quote","description":"Delivery Details","collection_date_label":"Collection Date","collection_time_label":"Collection Time","collection_address_label":"Collection Address","destination_address_label":"Destination Address","cant_find_address_text":"I can\'t find my address","first_name":"First Name","last_name":"Last Name","phone":"Phone Number","email":"Email Address","service_id":"Service","view_service_link_text":"View Service Details..","vehicle_id":"Vehicle","view_vehicle_link_text":"View Vehicle Details..","journey_title":"","payment_info_header":"","distance_label":"Distance","time_label":"Estimated Travel Time","optimize_route_label":"","deliver_and_return_label":"","appartment_no":"Unit No","street_number_label":"","route_label":"","postal_town_label":"","administrative_area_level_2_label":"","administrative_area_level_1_label":"","country_label":"","postal_code_label":"Postal Code","date_and_time_title":"Date and Time","hourly_hire_rate_label":"","hourly_rate_label":"","hourly_cost_label":"","contact_name":"Contact Name","contact_phone":"Contact Phone","short_notice_cost_label":"Short Notice Cost","extra_destination_surcharge_label":"Extra Destination Surcharge","sub_total_label":"Subtotal","days_hired_label":"Days Hired","hours_hired_label":"Hours Hired","route_heading_label":"Route","delivery_cost_label":"Delivery Cost","total_cost_label":"Total Cost","tax_name":"VAT","distance_cost":"Distance Cost","rate_hour":"Hourly Rate (GBP)","time_cost":"Time Cost (GBP)","basic_cost":"Subtotal (GBP)","rate_tax":"VAT Rate (%)","tax_cost":"VAT (GBP)","total":"Total (GBP)","rates":"Rates"}', true);

        $this->example_job = json_decode('{"id":"13","delivery_contact_name":"","delivery_time":"2019-08-09 11:30:00","description":"test","dimensions":"","customer_id":"1","accepted_quote_id":"13","payment_type_id":"0","payment_status_id":"0","status_type_id":"1","vehicle_id":"1","service_id":"1","move_size_id":"0","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13","customer":{"id":"1","wp_user_id":"1","first_name":"Andrew","last_name":"Test","email":"test@test.com","phone":"4234324234","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13"},"journey":{"id":"13","job_id":"13","distance":"665.0500","time":"6.81","deliver_and_return":null,"optimize_route":null,"created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13"},"stops":[{"id":"5","address":"385 Dumbarton Road, Glasgow, UK","appartment_no":"2\/1","street_number":"385","postal_town":"Glasgow","route":"Dumbarton Road","administrative_area_level_2":"Glasgow City","administrative_area_level_1":"Scotland","country":"United Kingdom","postal_code":"G11 6BE","lat":"55.87069900000000000000","lng":"-4.30828000000000000000","place_id":"ChIJORdf39xFiEgRJAAllCRtufc","created":"2019-08-07 10:00:05","modified":"2019-08-07 10:00:05","contact_name":"","contact_phone":""},{"id":"8","address":"100 New Oxford Street, London, UK","appartment_no":"","street_number":"100","postal_town":"London","route":"New Oxford Street","administrative_area_level_2":"Greater London","administrative_area_level_1":"England","country":"United Kingdom","postal_code":"WC1A 1HB","lat":"51.51684200000000000000","lng":"-0.12840200000000000000","place_id":"ChIJvd7DmjIbdkgR0y0vQBMUfbE","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13","contact_name":"","contact_phone":""}],"quote":{"rates":"standard","total":"1330.10","basic_cost":"1330.10","distance_cost":"1330.10","breakdown":"[{\"distance\":\"0.00\",\"distance_cost\":0,\"type\":\"set amount\",\"rate\":\"0.00\",\"cost\":\"0.00\"},{\"distance\":665.05,\"distance_cost\":1330.1,\"type\":\"per distance unit\",\"rate\":\"2.00\",\"cost\":1330.1},{\"distance\":0,\"distance_cost\":1330.1,\"type\":\"per distance unit\",\"rate\":\"2.00\",\"return_percentage\":\"100\",\"cost\":0}]","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13","id":13},"job_date":[{"label":"Pick Up Date","value":"August 9, 2019"},{"label":"Pick Up Time","value":"11:30 am"}],"payment":[]}', true);


        $this->example_job_2 = json_decode('{"id":"13","delivery_contact_name":"","delivery_time":"2019-08-09 11:30:00","description":"","dimensions":"","customer_id":"1","accepted_quote_id":"13","payment_type_id":"0","payment_status_id":"0","status_type_id":"1","vehicle_id":"1","service_id":"1","move_size_id":"0","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13","customer":{"id":"1","wp_user_id":"1","first_name":"Andrew","last_name":"Test","email":"test@test.com","phone":"4234324234","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13"},"journey":{"id":"13","job_id":"13","distance":"665.0500","time":"6.81","deliver_and_return":null,"optimize_route":null,"created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13"},"stops":[{"id":"5","address":"385 Dumbarton Road, Glasgow, UK","appartment_no":"2\/1","street_number":"385","postal_town":"Glasgow","route":"Dumbarton Road","administrative_area_level_2":"Glasgow City","administrative_area_level_1":"Scotland","country":"United Kingdom","postal_code":"G11 6BE","lat":"55.87069900000000000000","lng":"-4.30828000000000000000","place_id":"ChIJORdf39xFiEgRJAAllCRtufc","created":"2019-08-07 10:00:05","modified":"2019-08-07 10:00:05","contact_name":"","contact_phone":""},{"id":"8","address":"100 New Oxford Street, London, UK","appartment_no":"","street_number":"100","postal_town":"London","route":"New Oxford Street","administrative_area_level_2":"Greater London","administrative_area_level_1":"England","country":"United Kingdom","postal_code":"WC1A 1HB","lat":"51.51684200000000000000","lng":"-0.12840200000000000000","place_id":"ChIJvd7DmjIbdkgR0y0vQBMUfbE","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13","contact_name":"","contact_phone":""}],"quote":{"rates":"standard","total":"1330.10","basic_cost":"1330.10","distance_cost":"1330.10","breakdown":"[{\"distance\":\"0.00\",\"distance_cost\":0,\"type\":\"set amount\",\"rate\":\"0.00\",\"cost\":\"0.00\"},{\"distance\":665.05,\"distance_cost\":1330.1,\"type\":\"per distance unit\",\"rate\":\"2.00\",\"cost\":1330.1},{\"distance\":0,\"distance_cost\":1330.1,\"type\":\"per distance unit\",\"rate\":\"2.00\",\"return_percentage\":\"100\",\"cost\":0}]","created":"2019-08-09 10:16:13","modified":"2019-08-09 10:16:13","id":13},"job_date":[{"label":"Pick Up Date","value":"August 9, 2019"},{"label":"Pick Up Time","value":"11:30 am"}],"payment":[]}', true);        

        $this->expected_output_1 = json_decode('[{"label":"Delivery Details","name":"description","value":"test","type":"text"},{"label":"Service","name":"service_id","value":"Standard","type":"text"},{"label":"Vehicle","name":"vehicle_id","value":"Van","type":"text"}]', true);   

        $this->expected_output_1_not_empty = json_decode('[{"label":"Service","name":"service_id","value":"Standard","type":"text"},{"label":"Vehicle","name":"vehicle_id","value":"Van","type":"text"}]', true);        

        $this->admin_config = json_decode('{"job":{"id":"17","delivery_contact_name":"","delivery_time":"2019-08-12 17:00:00","description":"54ew5","dimensions":"","customer_id":"4","accepted_quote_id":"17","payment_type_id":"1","payment_status_id":"1","status_type_id":"1","vehicle_id":"1","service_id":"1","move_size_id":"0","created":"2019-08-12 16:47:41","modified":"2019-08-12 16:47:41","customer":{"id":"4","wp_user_id":"0","first_name":"sdfdsf","last_name":"dsfdsfd","email":"sdfdsf@dsfdsf.com","phone":"435345345","created":"2019-08-12 16:47:41","modified":"2019-08-12 16:47:41"},"journey":{"id":"17","job_id":"17","distance":"75.0200","time":"1.09","deliver_and_return":null,"optimize_route":null,"created":"2019-08-12 16:47:41","modified":"2019-08-12 16:47:41"},"stops":[{"id":"7","address":"Edinburgh, UK","appartment_no":"","street_number":"","postal_town":"","route":"","administrative_area_level_2":"Edinburgh","administrative_area_level_1":"Scotland","country":"United Kingdom","postal_code":"","lat":"55.95325200000000000000","lng":"-3.18826700000000000000","place_id":"ChIJIyaYpQC4h0gRJxfnfHsU8mQ","created":"2019-08-08 14:42:35","modified":"2019-08-08 14:42:35","contact_name":"","contact_phone":""},{"id":"1","address":"Glasgow, UK","appartment_no":"","street_number":"","postal_town":"Glasgow","route":"","administrative_area_level_2":"Glasgow City","administrative_area_level_1":"Scotland","country":"United Kingdom","postal_code":"","lat":"55.86423700000000000000","lng":"-4.25180600000000000000","place_id":"ChIJ685WIFYViEgRHlHvBbiD5nE","created":"2019-08-05 10:05:20","modified":"2019-08-05 10:05:20","contact_name":"","contact_phone":""}],"quote":{"id":"17","total":"150.04","rate_unit":"0.00","rate_hour":"0.00","rate_tax":"0.00","basic_cost":"150.04","distance_cost":"150.04","time_cost":"0.00","notice_cost":"0.00","tax_cost":"0.00","rates":"standard","created":"2019-08-12 16:47:41","modified":"2019-08-12 16:47:41"},"job_date":[{"label":"Pick Up Date","value":"August 12, 2019"},{"label":"Pick Up Time","value":"5:00 pm"}],"payment":[{"label":"Payment Method","value":"On Delivery"},{"label":"Payment Status","value":"Due"}]},"labels":{"contact_section_title":"Your Contact Information","search_section_title":"Delivery Addresses","map_title":"Address Locations","quote_section_title":"Quote","quote_label":"Your Quote","description":"Delivery Details","collection_date_label":"Collection Date","collection_time_label":"Collection Time","collection_address_label":"Collection Address","destination_address_label":"Destination Address","cant_find_address_text":"I cant find my address","first_name":"First Name","last_name":"Last Name","phone":"Phone Number","email":"Email Address","service_id":"Service","view_service_link_text":"View Service Details..","vehicle_id":"Vehicle","view_vehicle_link_text":"View Vehicle Details..","journey_title":"","payment_info_header":"","distance":"Distance","time":"Estimated Travel Time","optimize_route_label":"","deliver_and_return_label":"","appartment_no":"Unit No","street_number_label":"","route_label":"Route","postal_town_label":"","administrative_area_level_2_label":"","administrative_area_level_1_label":"","country_label":"","postal_code_label":"Postal Code","date_and_time_title":"Date and Time","hourly_hire_rate_label":"","hourly_rate_label":"","hourly_cost_label":"","contact_name":"Contact Name","contact_phone_label":"Contact Phone","short_notice_cost_label":"Short Notice Cost","extra_destination_surcharge_label":"Extra Destination Surcharge","sub_total_label":"Subtotal","days_hired_label":"Days Hired","hours_hired_label":"Hours Hired","route_heading_label":"Route","delivery_cost_label":"Delivery Cost","total_cost_label":"Total Cost","tax_name":"VAT","distance_cost":"Distance Cost","rate_hour":"Hourly Rate (GBP)","time_cost":"Time Cost (GBP)","basic_cost":"Subtotal (GBP)","rate_tax":"VAT Rate (%)","tax_cost":"VAT (GBP)","total":"Total (GBP)","rates":"Rates"},"services":{"1":{"id":"1","name":"Standard","description":"Standard rates and turnaround apply.","amount":"0.00","created":"0000-00-00 00:00:00","modified":"2019-07-31 10:24:37"}},"vehicles":{"1":{"id":"1","name":"Van","description":"Standard delivery vehicle.","amount":"0.00","created":"0000-00-00 00:00:00","modified":"2019-07-31 10:24:37"}}}',true);

        $this->expected_admin_out = json_decode('[{"label":"Delivery Details","name":"description","value":"54ew5","type":"text"},{"label":"Service","name":"service_id","value":"Standard","type":"text"},{"label":"Vehicle","name":"vehicle_id","value":"Van","type":"text"}]', true);
    }
   
    public function test_format() {

    	$formatter_config = array( 'job'=>$this->example_job,
                                    'labels'=>$this->example_labels,
                                    'services'=>$this->test_services_1,
                                    'vehicles'=>$this->test_vehicles_1);
                                                    
        $this->formatter = new TransitQuote_Pro4\TQ_JobFormatter($formatter_config);

        $output = $this->formatter->format();
        $this->assertTrue(is_array($output), ' not an array');


        $this->assertCount(3, $output, ' not 3 elements');

        foreach ($output as $field) {
        	$this->assertArrayHasKey('name' ,$field);
        	$this->assertArrayHasKey('type' ,$field);
        	$this->assertArrayHasKey('value' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };
        
        $this->assertEquals('Service',$output[1]['label']);
        $this->assertEquals('Standard',$output[1]['value']);

        $this->assertEquals('Vehicle',$output[2]['label']);
        $this->assertEquals('Van',$output[2]['value']);



        $this->assertEquals($output, $this->expected_output_1);

    }

    public function test_format_not_empty_only() {

        $formatter_config = array( 'job'=>$this->example_job_2,
                                    'labels'=>$this->example_labels,
                                    'services'=>$this->test_services_1,
                                    'vehicles'=>$this->test_vehicles_1);

        $this->formatter = new TransitQuote_Pro4\TQ_JobFormatter($formatter_config);

        $output = $this->formatter->format_not_empty_only();
        $this->assertTrue(is_array($output), ' not an array');

        $this->assertCount(2, $output, ' not 2 elements');


        foreach ($output as $field) {
            $this->assertArrayHasKey('name' ,$field);
            $this->assertArrayHasKey('type' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };
        

        
        $this->assertEquals($output, $this->expected_output_1_not_empty);
    }    

    public function test_format_admin_config() {

        $formatter_config = $this->admin_config;
                                                    
        $this->formatter = new TransitQuote_Pro4\TQ_JobFormatter($formatter_config);

        $output = $this->formatter->format();
        $this->assertTrue(is_array($output), ' not an array');


        $this->assertCount(3, $output, ' not 3 elements');

        foreach ($output as $field) {
            $this->assertArrayHasKey('name' ,$field);
            $this->assertArrayHasKey('type' ,$field);
            $this->assertArrayHasKey('value' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };
        
        $this->assertEquals('Service',$output[1]['label']);
        $this->assertEquals('Standard',$output[1]['value']);

        $this->assertEquals('Vehicle',$output[2]['label']);
        $this->assertEquals('Van',$output[2]['value']);

        $this->assertEquals($output, $this->expected_admin_out);

    }    
}
?>