<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_RequestParserGetQuoteReturnJourneyDispatchReturnTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->test_request_parser_config = json_decode('{"debugging":false,"location_fields":["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"],"journey_fields":["id","job_id","distance","time","created","modified"],"journeys_locations_fields":["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"],"post_data":{"address_1_address":"Newark Liberty International Airport (EWR), Brewster Road, Newark, NJ, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"3","address_1_route":"Brewster Road","address_1_postal_town":"","address_1_administrative_area_level_2":"","address_1_administrative_area_level_1":"New Jersey","address_1_country":"United States","address_1_lat":"40.68953140000001","address_1_lng":"-74.17446239999998","address_1_place_id":"ChIJ7wzsxeFSwokRhvLXxTe087M","address_1_journey_order":"1","address_2_address":"Brooklyn Museum, Eastern Parkway, Brooklyn, NY, USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"200","address_2_route":"Eastern Parkway","address_2_postal_town":"","address_2_administrative_area_level_2":"Kings County","address_2_administrative_area_level_1":"New York","address_2_country":"United States","address_2_lat":"40.6712062","address_2_lng":"-73.96363059999999","address_2_place_id":"ChIJyTmcRApbwokR-oXJRqpVI8Y","address_2_journey_order":"2","date":"5 December, 2019","delivery_date":"5-12-2019","delivery_time":"4:30 PM","delivery_time_submit":"16:30","weight":"","deliver_and_return":"1","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"65.51","time":"1.98","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"1","journey_type":"ReturnJourneyFixedStart","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"38.6 km\",\"value\":38628},\"duration\":{\"text\":\"32 mins\",\"value\":1904},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"39.7 km\",\"value\":39706},\"duration\":{\"text\":\"44 mins\",\"value\":2646},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"start_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"27.1 km\",\"value\":27073},\"duration\":{\"text\":\"43 mins\",\"value\":2566},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"start_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":true,"use_return_to_collection_rates":true,"use_return_to_base_rates":false}', true);

      
        $this->request_parser_get_quote_return_journey = new TransitQuote_Pro4\TQ_RequestParserGetQuoteDispatchCollection($this->test_request_parser_config);        

        $this->test_request_parser_two_drops_config = json_decode('{"debugging":false,"location_fields":["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"],"journey_fields":["id","job_id","distance","time","created","modified"],"journeys_locations_fields":["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"],"post_data":{"address_1_address":"Newark Liberty International Airport (EWR), Brewster Road, Newark, NJ, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"3","address_1_route":"Brewster Road","address_1_postal_town":"","address_1_administrative_area_level_2":"","address_1_administrative_area_level_1":"New Jersey","address_1_country":"United States","address_1_lat":"40.68953140000001","address_1_lng":"-74.17446239999998","address_1_place_id":"ChIJ7wzsxeFSwokRhvLXxTe087M","address_1_journey_order":"0","address_3_address":"Staten Island Ferry, South Street, New York, NY, USA","address_3_appartment_no":"","address_3_postal_code":"","address_3_street_number":"4","address_3_route":"South Street","address_3_postal_town":"","address_3_administrative_area_level_2":"New York County","address_3_administrative_area_level_1":"New York","address_3_country":"United States","address_3_lat":"40.7013706","address_3_lng":"-74.01336909999998","address_3_place_id":"ChIJv_qqfBNawokRYPA81lwyeI0","address_3_journey_order":"1","address_2_address":"Brooklyn Museum, Eastern Parkway, Brooklyn, NY, USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"200","address_2_route":"Eastern Parkway","address_2_postal_town":"","address_2_administrative_area_level_2":"Kings County","address_2_administrative_area_level_1":"New York","address_2_country":"United States","address_2_lat":"40.6712062","address_2_lng":"-73.96363059999999","address_2_place_id":"ChIJyTmcRApbwokR-oXJRqpVI8Y","address_2_journey_order":"2","date":"5 December, 2019","delivery_date":"5-12-2019","delivery_time":"4:30 PM","delivery_time_submit":"16:30","weight":"","deliver_and_return":"1","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"62.45","time":"2.11","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"1","journey_type":"ReturnJourneyFixedStart","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"38.6 km\",\"value\":38628},\"duration\":{\"text\":\"32 mins\",\"value\":1904},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"23.7 km\",\"value\":23687},\"duration\":{\"text\":\"32 mins\",\"value\":1900},\"end_address\":\"4 South St, New York, NY 10004, USA\",\"end_location\":{\"lat\":40.7012533,\"lng\":-74.01335460000001},\"start_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"start_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"11.1 km\",\"value\":11097},\"duration\":{\"text\":\"20 mins\",\"value\":1210},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"4 South St, New York, NY 10004, USA\",\"start_location\":{\"lat\":40.7012533,\"lng\":-74.01335460000001},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"27.1 km\",\"value\":27073},\"duration\":{\"text\":\"43 mins\",\"value\":2566},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"start_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":true,"use_return_to_collection_rates":true,"use_return_to_base_rates":false}', true);
      
        $this->request_parser_get_quote_return_journey_two_drops = new TransitQuote_Pro4\TQ_RequestParserGetQuoteDispatchCollection($this->test_request_parser_two_drops_config);        

    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }

    public function test_get_stage_data() {  
        
        $stage_data = $this->request_parser_get_quote_return_journey->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');
        $this->assertCount(3, $this->request_parser_get_quote_return_journey->legs, ' not 3 legs');
        $this->assertCount(3, $stage_data, ' stage_data does not have 3 stages');

        $this->assertEquals('dispatch', $stage_data[0]['leg_type'], ' stage_data 0 is not dispatch');
        $this->assertEquals(24.007458048477, $stage_data[0]['distance'], ' stage_data 0 incorrect distance');
        $this->assertEquals(0.52888888888889, $stage_data[0]['hours'], ' stage_data 0 incorrect hours');

        $this->assertEquals('standard', $stage_data[1]['leg_type'], ' stage_data 1 is not standard');
        $this->assertEquals(24.677439403356, $stage_data[1]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.735, $stage_data[1]['hours'], ' stage_data 1 incorrect hours');

        $this->assertEquals('return_to_collection', $stage_data[2]['leg_type'], ' stage_data 2 is not standard');
        $this->assertEquals(16.825978868863, $stage_data[2]['distance'], ' stage_data 2 incorrect distance');
        $this->assertEquals(0.71277777777778, $stage_data[2]['hours'], ' stage_data 2 incorrect hours');        
    }

    public function test_get_stage_data_two_drops() {  
        
        $stage_data = $this->request_parser_get_quote_return_journey_two_drops->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');
        var_dump($stage_data);

        $this->assertCount(4, $this->request_parser_get_quote_return_journey_two_drops->legs, ' not 4 legs');        ;
        $this->assertCount(3, $stage_data, ' stage_data does not have 2 stages');

        $this->assertEquals('dispatch', $stage_data[0]['leg_type'], ' stage_data 0 is not dispatch');
        $this->assertEquals(24.007458048477, $stage_data[0]['distance'], ' stage_data 0 incorrect distance');
        $this->assertEquals(0.52888888888889, $stage_data[0]['hours'], ' stage_data 0 incorrect hours');

        $this->assertEquals('standard', $stage_data[1]['leg_type'], ' stage_data 1 is not standard');
        $this->assertEquals(6.8968303293971, $stage_data[1]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.33611111111111, $stage_data[1]['hours'], ' stage_data 1 incorrect hours');

        $this->assertEquals('return_to_collection', $stage_data[2]['leg_type'], ' stage_data 1 is not return_to_collection');
        $this->assertEquals(16.825978868863, $stage_data[2]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.71277777777778, $stage_data[2]['hours'], ' stage_data 1 incorrect hours'); 

    }
  
}
