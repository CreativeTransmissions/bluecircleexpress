<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_RequestParserGetQuoteReturnToBaseTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->test_request_parser_config = json_decode('{"debugging":false,"location_fields":null,"journey_fields":null,"journeys_locations_fields":null,"post_data":{"address_1_address":"Newark, NJ, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"","address_1_administrative_area_level_2":"Essex County","address_1_administrative_area_level_1":"New Jersey","address_1_country":"United States","address_1_lat":"40.735657","address_1_lng":"-74.1723667","address_1_place_id":"ChIJHQ6aMnBTwokRc-T-3CrcvOE","address_1_journey_order":"1","address_2_address":"Brooklyn Museum, Eastern Parkway, Brooklyn, NY, USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"200","address_2_route":"Eastern Parkway","address_2_postal_town":"","address_2_administrative_area_level_2":"Kings County","address_2_administrative_area_level_1":"New York","address_2_country":"United States","address_2_lat":"40.6712062","address_2_lng":"-73.96363059999999","address_2_place_id":"ChIJyTmcRApbwokR-oXJRqpVI8Y","address_2_journey_order":"2","date":"3 December, 2019","delivery_date":"3-12-2019","delivery_time":"11:00 AM","delivery_time_submit":"11:00","weight":"","deliver_and_return":"0","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"71.36","time":"2.43","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"1","journey_type":"ReturnToBaseFixedStart","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"34.0 km\",\"value\":33957},\"duration\":{\"text\":\"37 mins\",\"value\":2225},\"end_address\":\"EWR, Newark, NJ 07102, USA\",\"end_location\":{\"lat\":40.73565,\"lng\":-74.17237},\"start_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"22.8 km\",\"value\":22836},\"duration\":{\"text\":\"51 mins\",\"value\":3086},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"EWR, Newark, NJ 07102, USA\",\"start_location\":{\"lat\":40.73565,\"lng\":-74.17237},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"58.0 km\",\"value\":58026},\"duration\":{\"text\":\"57 mins\",\"value\":3431},\"end_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"end_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"start_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"start_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":true,"use_return_to_base_rates":true}', true);

      
        $this->request_parser_get_quote_newark_brooklyn = new TransitQuote_Pro4\TQ_RequestParserGetQuoteReturnToBase($this->test_request_parser_config);        

    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }

    public function test_get_stage_data() {  
        
        $stage_data = $this->request_parser_get_quote_newark_brooklyn->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');
        var_dump($stage_data);
        $this->assertCount(3, $stage_data, ' stage_data does not have 3 stages');
        $this->assertEquals('dispatch', $stage_data[0]['leg_type'], ' stage_data 0 is not dispatch');
        $this->assertEquals(21.104412678682, $stage_data[0]['distance'], ' stage_data 0 incorrect distance');
        $this->assertEquals(0.61805555555556, $stage_data[0]['hours'], ' stage_data 0 incorrect hours');



        $this->assertEquals('standard', $stage_data[1]['leg_type'], ' stage_data 1 is not standard');
        $this->assertEquals(14.192666252331, $stage_data[1]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.85722222222222, $stage_data[1]['hours'], ' stage_data  0 incorrect hours');

        $this->assertEquals('return_to_base', $stage_data[2]['leg_type'], ' stage_data 2 is not return_to_base');
        $this->assertEquals(36.063393412057, $stage_data[2]['distance'], ' stage_data 2 incorrect distance');
        $this->assertEquals(0.95305555555556, $stage_data[2]['hours'], ' stage_data 2  0 incorrect hours');

    }

  
}
