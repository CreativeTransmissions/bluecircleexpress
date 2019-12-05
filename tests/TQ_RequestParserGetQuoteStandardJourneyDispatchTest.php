<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_RequestParserGetQuoteStandardJourneyDispatchTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        //standard journey fixed start dispatch rates
        $this->test_request_parser_config = json_decode('{"debugging":false,"location_fields":["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"],"journey_fields":["id","job_id","distance","time","created","modified"],"journeys_locations_fields":["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"],"post_data":{"address_1_address":"Brookfield Place, Vesey Street, New York, NY, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"230","address_1_route":"Vesey Street","address_1_postal_town":"","address_1_administrative_area_level_2":"New York County","address_1_administrative_area_level_1":"New York","address_1_country":"United States","address_1_lat":"40.7127168","address_1_lng":"-74.01528239999999","address_1_place_id":"ChIJy8jTDBtawokRB9wNyxemSw8","address_1_journey_order":"1","address_2_address":"Brooklyn Museum, Eastern Parkway, Brooklyn, NY, USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"200","address_2_route":"Eastern Parkway","address_2_postal_town":"","address_2_administrative_area_level_2":"Kings County","address_2_administrative_area_level_1":"New York","address_2_country":"United States","address_2_lat":"40.6712062","address_2_lng":"-73.96363059999999","address_2_place_id":"ChIJyTmcRApbwokR-oXJRqpVI8Y","address_2_journey_order":"2","date":"5 December, 2019","delivery_date":"5-12-2019","delivery_time":"1:30 PM","delivery_time_submit":"13:30","weight":"","deliver_and_return":"0","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"41.84","time":"1.17","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"1","journey_type":"StandardJourneyFixedStart","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"56.4 km\",\"value\":56408},\"duration\":{\"text\":\"50 mins\",\"value\":3025},\"end_address\":\"225 Liberty St, New York, NY 10281, USA\",\"end_location\":{\"lat\":40.71256520000001,\"lng\":-74.01430929999998},\"start_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"10.9 km\",\"value\":10910},\"duration\":{\"text\":\"20 mins\",\"value\":1199},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"225 Liberty St, New York, NY 10281, USA\",\"start_location\":{\"lat\":40.71256520000001,\"lng\":-74.01430929999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":true,"use_return_to_base_rates":false}', true);


      
        $this->request_parser_get_quote_standard_journey = new TransitQuote_Pro4\TQ_RequestParserGetQuoteDispatch($this->test_request_parser_config);    
    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }

    public function test_get_stage_data_fixed_start_dispatch() {  
        
        $stage_data = $this->request_parser_get_quote_standard_journey->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');
        $this->assertCount(2, $stage_data, ' stage_data does not have 2 stages');

        $this->assertEquals('dispatch', $stage_data[0]['leg_type'], ' stage_data 0 is not dispatch');
        $this->assertEquals(35.057799875699196, $stage_data[0]['distance'], ' stage_data 0 incorrect distance');
        $this->assertEquals(0.8402777777777778, $stage_data[0]['hours'], ' stage_data 0 incorrect hours');

        $this->assertEquals('standard', $stage_data[1]['leg_type'], ' stage_data 1 is not standard');
        $this->assertEquals(6.780609073958981, $stage_data[1]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.33305555555555555, $stage_data[1]['hours'], ' stage_data 1 incorrect hours');

    }
  
}
