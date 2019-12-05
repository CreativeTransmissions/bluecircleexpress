<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_RequestParserGetQuoteStandardJourneyFixedStartTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        //standard journey fixed start no dispatch rates
        $this->test_request_parser_config = json_decode('{"debugging":false,"location_fields":["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"],"journey_fields":["id","job_id","distance","time","created","modified"],"journeys_locations_fields":["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"],"post_data":{"address_1_address":"Brooklyn Museum, Eastern Parkway, Brooklyn, NY, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"200","address_1_route":"Eastern Parkway","address_1_postal_town":"","address_1_administrative_area_level_2":"Kings County","address_1_administrative_area_level_1":"New York","address_1_country":"United States","address_1_lat":"40.6712062","address_1_lng":"-73.96363059999999","address_1_place_id":"ChIJyTmcRApbwokR-oXJRqpVI8Y","address_1_journey_order":"1","address_2_address":"Newark Liberty International Airport (EWR), Brewster Road, Newark, NJ, USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"3","address_2_route":"Brewster Road","address_2_postal_town":"","address_2_administrative_area_level_2":"","address_2_administrative_area_level_1":"New Jersey","address_2_country":"United States","address_2_lat":"40.68953140000001","address_2_lng":"-74.17446239999998","address_2_place_id":"ChIJ7wzsxeFSwokRhvLXxTe087M","address_2_journey_order":"2","date":"5 December, 2019","delivery_date":"5-12-2019","delivery_time":"10:00 AM","delivery_time_submit":"10:00","weight":"","deliver_and_return":"0","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"53.90","time":"1.69","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"1","journey_type":"StandardJourneyFixedStart","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"59.6 km\",\"value\":59648},\"duration\":{\"text\":\"58 mins\",\"value\":3507},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"27.1 km\",\"value\":27073},\"duration\":{\"text\":\"43 mins\",\"value\":2566},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"start_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":false,"use_return_to_base_rates":false}', true);

      
        $this->request_parser_get_quote_standard_journey = new TransitQuote_Pro4\TQ_RequestParserGetQuote($this->test_request_parser_config);    
    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }

    public function test_get_stage_data_fixed_start_no_dispatch() {  
        
        $stage_data = $this->request_parser_get_quote_standard_journey->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');
        $this->assertCount(1, $stage_data, ' stage_data does not have 1 stages');

        $this->assertEquals('standard', $stage_data[0]['leg_type'], ' stage_data 0 is not standard');
        $this->assertEquals(53.89745183343692, $stage_data[0]['distance'], ' stage_data 0 incorrect distance');
        $this->assertEquals(1.6869444444444444, $stage_data[0]['hours'], ' stage_data 0 incorrect hours');

    }
  
}
