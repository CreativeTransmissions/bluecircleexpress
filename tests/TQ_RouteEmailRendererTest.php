<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_RouteEmailRendererTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();



        $this->route_renderer = new TransitQuote_Pro4\TQ_RouteEmailRenderer();

        $this->test_params = json_decode('{"labels":{"contact_section_title":"Your Contact Information","search_section_title":"Delivery Addresses","map_title":"Address Locations","quote_section_title":"Quote","quote_label":"Your Quote","job_info_label":"Delivery Details","collection_date_label":"Collection Date","collection_time_label":"Collection Time","collection_address_label":"Collection Address","destination_address_label":"Destination Address","cant_find_address_text":"I can\'t find my address","first_name_label":"First Name","last_name_label":"Last Name","phone_label":"Phone Number","email_label":"Email Address","service_label":"Service","view_service_link_text":"View Service Details..","vehicle_label":"Vehicle","view_vehicle_link_text":"View Vehicle Details..","journey_title":"","payment_info_header":"","distance_label":"Distance","time_label":"Estimated Travel Time","optimize_route_label":"","deliver_and_return_label":"","appartment_no":"Unit No","street_number_label":"","route_label":"","postal_town_label":"","administrative_area_level_2_label":"","administrative_area_level_1_label":"","country_label":"","postal_code_label":"Postal Code","date_and_time_title":"Date and Time","hourly_hire_rate_label":"","hourly_rate_label":"","hourly_cost_label":"","contact_name":"Contact Name","contact_phone":"Contact Phone","short_notice_cost_label":"Short Notice Cost","extra_destination_surcharge_label":"Extra Destination Surcharge","sub_total_label":"Subtotal","days_hired_label":"Days Hired","hours_hired_label":"Hours Hired","route_heading_label":"Route","delivery_cost_label":"Delivery Cost","total_cost_label":"Total Cost","tax_name":"VAT","distance_cost":"Distance Cost","rate_hour":"Hourly Rate (GBP)","time_cost":"Time Cost (GBP)","basic_cost":"Subtotal (GBP)","rate_tax":"VAT Rate (%)","tax_cost":"VAT (GBP)","total":"Total (GBP)","rates":"Rates"},"header":"Route","data":[[{"name":"address","value":"385 Dumbarton Road, Glasgow, UK","type":"text"},{"name":"appartment_no","value":"2\/1","type":"text","label":"Unit No"},{"name":"postal_code","value":"G11 6BE","type":"text"},{"name":"contact_name","value":"Andrew","type":"text","label":"Contact Name"},{"name":"contact_phone","value":"123123123123","type":"text","label":"Contact Phone"}],[{"name":"address","value":"CeX, Union Street, Glasgow, UK","type":"text"},{"name":"appartment_no","value":"1","type":"text","label":"Unit No"},{"name":"postal_code","value":"G1 3QX","type":"text"},{"name":"contact_name","value":"Dude","type":"text","label":"Contact Name"},{"name":"contact_phone","value":"93478534957","type":"text","label":"Contact Phone"}]]}', true);

        $this->expected_html = urldecode('Route%0D%0A%0D%0ACollection+Address%0D%0A%0D%0A385+Dumbarton+Road%2C+Glasgow%2C+UK%0D%0AUnit+No%3A+2%2F1%0D%0AG11+6BE%0D%0AContact+Name%3A+Andrew%0D%0AContact+Phone%3A+123123123123%0D%0A%0D%0A%0D%0ADestination+Address%0D%0A%0D%0ACeX%2C+Union+Street%2C+Glasgow%2C+UK%0D%0AUnit+No%3A+1%0D%0AG1+3QX%0D%0AContact+Name%3A+Dude%0D%0AContact+Phone%3A+93478534957%0D%0A%0D%0A%0D%0A%0D%0A');
    }
   
    public function test_generate_list_for_each_waypoint(){
        $this->route_renderer->data = $this->test_params['data'];

        $array_of_lists = $this->route_renderer->generate_list_for_each_waypoint(); 

        $this->assertTrue(is_array($array_of_lists), ' not an array');
        $this->assertCount(2, $array_of_lists);

    }

    public function test_render() {

        $html = $this->route_renderer->render($this->test_params); 
        $this->assertTrue(is_string($html), 'output not a string');

        $this->assertEquals($this->expected_html, $html);
    }
}
?>