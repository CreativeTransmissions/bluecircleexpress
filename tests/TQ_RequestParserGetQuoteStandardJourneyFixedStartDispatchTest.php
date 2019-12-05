<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_RequestParserGetQuoteStandardJourneyFixedStartDispatchTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        //standard journey fixed start using dispatch rates
        $this->test_request_parser_config = json_decode('{"debugging":false,"location_fields":["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"],"journey_fields":["id","job_id","distance","time","created","modified"],"journeys_locations_fields":["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"],"post_data":{"address_1_address":"Newark Liberty International Airport (EWR), Brewster Road, Newark, NJ, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"3","address_1_route":"Brewster Road","address_1_postal_town":"","address_1_administrative_area_level_2":"","address_1_administrative_area_level_1":"New Jersey","address_1_country":"United States","address_1_lat":"40.68953140000001","address_1_lng":"-74.17446239999998","address_1_place_id":"ChIJ7wzsxeFSwokRhvLXxTe087M","address_1_journey_order":"1","address_2_address":"Staten Island Mall, Richmond Avenue, Staten Island, NY, USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"2655","address_2_route":"Richmond Avenue","address_2_postal_town":"","address_2_administrative_area_level_2":"Richmond County","address_2_administrative_area_level_1":"New York","address_2_country":"United States","address_2_lat":"40.582489","address_2_lng":"-74.1645633","address_2_place_id":"ChIJMQW5NIdLwokR8jmOUJsxtso","address_2_journey_order":"2","date":"5 December, 2019","delivery_date":"5-12-2019","delivery_time":"10:00 AM","delivery_time_submit":"10:00","weight":"","deliver_and_return":"0","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"36.23","time":"0.96","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"","journey_type":"StandardJourneyFixedStart","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"38.6 km\",\"value\":38628},\"duration\":{\"text\":\"32 mins\",\"value\":1904},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"19.7 km\",\"value\":19662},\"duration\":{\"text\":\"26 mins\",\"value\":1537},\"end_address\":\"2655 Richmond Ave, Staten Island, NY 10314, USA\",\"end_location\":{\"lat\":40.5825687,\"lng\":-74.164534},\"start_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"start_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":true,"use_return_to_base_rates":false}', true);

      
        $this->request_parser_get_quote_standard_journey_dispatch = new TransitQuote_Pro4\TQ_RequestParserGetQuoteDispatch($this->test_request_parser_config);                

    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }

    public function test_get_stage_data_fixed_start_with_dispatch() {  
        
        $stage_data = $this->request_parser_get_quote_standard_journey_dispatch->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');
        $this->assertCount(2, $this->request_parser_get_quote_standard_journey_dispatch->legs, ' not 2 legs');

        $this->assertCount(2, $stage_data, ' stage_data does not have 2 stages');

        $this->assertEquals('dispatch', $stage_data[0]['leg_type'], ' stage_data 0 is not dispatch');
        $this->assertEquals(24.007458048477314, $stage_data[0]['distance'], ' stage_data 0 incorrect distance');
        $this->assertEquals(0.5288888888888889, $stage_data[0]['hours'], ' stage_data 0 incorrect hours');

        $this->assertEquals('standard', $stage_data[1]['leg_type'], ' stage_data 1 is not standard');
        $this->assertEquals(12.220012430081, $stage_data[1]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.42694444444444, $stage_data[1]['hours'], ' stage_data 1 incorrect hours');

    }
  
}
