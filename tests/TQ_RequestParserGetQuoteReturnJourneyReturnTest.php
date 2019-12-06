<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_RequestParserGetQuoteReturnJourneyReturnTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->test_request_parser_config = json_decode('{"debugging":false,"location_fields":["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"],"journey_fields":["id","job_id","distance","time","created","modified"],"journeys_locations_fields":["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"],"post_data":{"address_0_address":"Newark Liberty International Airport (EWR), Brewster Road, Newark, NJ, USA","address_0_appartment_no":"","address_0_postal_code":"","address_0_street_number":"3","address_0_route":"Brewster Road","address_0_postal_town":"","address_0_administrative_area_level_2":"","address_0_administrative_area_level_1":"New Jersey","address_0_country":"United States","address_0_lat":"40.68953140000001","address_0_lng":"-74.17446239999998","address_0_place_id":"ChIJ7wzsxeFSwokRhvLXxTe087M","address_0_journey_order":"0","address_1_address":"Brooklyn Museum, Eastern Parkway, Brooklyn, NY, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"200","address_1_route":"Eastern Parkway","address_1_postal_town":"","address_1_administrative_area_level_2":"Kings County","address_1_administrative_area_level_1":"New York","address_1_country":"United States","address_1_lat":"40.6712062","address_1_lng":"-73.96363059999999","address_1_place_id":"ChIJyTmcRApbwokR-oXJRqpVI8Y","address_1_journey_order":"1","date":"6 December, 2019","delivery_date":"6-12-2019","delivery_time":"8:30 AM","delivery_time_submit":"08:30","weight":"","deliver_and_return":"1","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"41.50","time":"1.45","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"1","journey_type":"ReturnJourney","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"39.7 km\",\"value\":39706},\"duration\":{\"text\":\"44 mins\",\"value\":2646},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"start_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"27.1 km\",\"value\":27073},\"duration\":{\"text\":\"43 mins\",\"value\":2566},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"start_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":false,"use_return_to_collection_rates":true,"use_return_to_base_rates":false}', true);

      
        $this->request_parser_get_quote_return_journey = new TransitQuote_Pro4\TQ_RequestParserGetQuoteReturnJourneyReturn($this->test_request_parser_config);        

        $this->test_request_parser_two_drops_config = json_decode('{"debugging":false,"location_fields":["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"],"journey_fields":["id","job_id","distance","time","created","modified"],"journeys_locations_fields":["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"],"post_data":{"address_0_address":"Newark Liberty International Airport (EWR), Brewster Road, Newark, NJ, USA","address_0_appartment_no":"","address_0_postal_code":"","address_0_street_number":"3","address_0_route":"Brewster Road","address_0_postal_town":"","address_0_administrative_area_level_2":"","address_0_administrative_area_level_1":"New Jersey","address_0_country":"United States","address_0_lat":"40.68953140000001","address_0_lng":"-74.17446239999998","address_0_place_id":"ChIJ7wzsxeFSwokRhvLXxTe087M","address_0_journey_order":"0","address_2_address":"Staten Island University Hospital, Seaview Avenue, Staten Island, NY, USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"475","address_2_route":"Seaview Avenue","address_2_postal_town":"","address_2_administrative_area_level_2":"Richmond County","address_2_administrative_area_level_1":"New York","address_2_country":"United States","address_2_lat":"40.5851337","address_2_lng":"-74.08527649999996","address_2_place_id":"ChIJtd7iqdtOwokR1DKZRzBoriI","address_2_journey_order":"1","address_1_address":"Brooklyn Museum, Eastern Parkway, Brooklyn, NY, USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"200","address_1_route":"Eastern Parkway","address_1_postal_town":"","address_1_administrative_area_level_2":"Kings County","address_1_administrative_area_level_1":"New York","address_1_country":"United States","address_1_lat":"40.6712062","address_1_lng":"-73.96363059999999","address_1_place_id":"ChIJyTmcRApbwokR-oXJRqpVI8Y","address_1_journey_order":"2","date":"6 December, 2019","delivery_date":"6-12-2019","delivery_time":"8:30 AM","delivery_time_submit":"08:30","weight":"","deliver_and_return":"1","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"44.88","time":"1.75","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"1","journey_type":"ReturnJourney","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"25.2 km\",\"value\":25221},\"duration\":{\"text\":\"29 mins\",\"value\":1758},\"end_address\":\"475 Seaview Ave, Staten Island, NY 10305, USA\",\"end_location\":{\"lat\":40.584902,\"lng\":-74.0851202},\"start_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"start_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"19.9 km\",\"value\":19923},\"duration\":{\"text\":\"33 mins\",\"value\":1966},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"475 Seaview Ave, Staten Island, NY 10305, USA\",\"start_location\":{\"lat\":40.584902,\"lng\":-74.0851202},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"27.1 km\",\"value\":27073},\"duration\":{\"text\":\"43 mins\",\"value\":2566},\"end_address\":\"Newark Liberty International Airport (EWR), 3 Brewster Rd, Newark, NJ 07114, USA\",\"end_location\":{\"lat\":40.6906708,\"lng\":-74.17753399999998},\"start_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"start_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"},"distance_unit":"Mile","use_dispatch_rates":false,"use_return_to_collection_rates":true,"use_return_to_base_rates":false}', true);
      
        $this->request_parser_get_quote_return_journey_two_drops = new TransitQuote_Pro4\TQ_RequestParserGetQuoteReturnJourneyReturn($this->test_request_parser_two_drops_config);        

    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }

    public function test_get_stage_data() {  
        
        $stage_data = $this->request_parser_get_quote_return_journey->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');

        $this->assertCount(2, $this->request_parser_get_quote_return_journey->legs, ' not 2 legs');
        $this->assertCount(2, $stage_data, ' stage_data does not have 2 stages');

        $this->assertEquals('standard', $stage_data[1]['leg_type'], ' stage_data 1 is not standard');
        $this->assertEquals(24.677439403356, $stage_data[1]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.735, $stage_data[1]['hours'], ' stage_data 1 incorrect hours');

        $this->assertEquals('return_to_collection', $stage_data[2]['leg_type'], ' stage_data 2 is not return_to_collection');
        $this->assertEquals(16.825978868863, $stage_data[2]['distance'], ' stage_data 2 incorrect distance');
        $this->assertEquals(0.71277777777778, $stage_data[2]['hours'], ' stage_data 2 incorrect hours');

    }

    public function test_get_stage_data_two_drops() {  
        
        $stage_data = $this->request_parser_get_quote_return_journey_two_drops->get_stage_data();

        $this->assertTrue(is_array($stage_data), ' stage_data is not array');

        $this->assertCount(3, $this->request_parser_get_quote_return_journey_two_drops->legs, ' not 3 legs');        ;
        $this->assertCount(2, $stage_data, ' stage_data does not have 2 stages');

        $this->assertEquals('dispatch', $stage_data[0]['leg_type'], ' stage_data 0 is not dispatch');
        $this->assertEquals(24.007458048477, $stage_data[0]['distance'], ' stage_data 0 incorrect distance');
        $this->assertEquals(0.52888888888889, $stage_data[0]['hours'], ' stage_data 0 incorrect hours');

        $this->assertEquals('standard', $stage_data[1]['leg_type'], ' stage_data 1 is not standard');
        $this->assertEquals(6.8968303293971, $stage_data[1]['distance'], ' stage_data 1 incorrect distance');
        $this->assertEquals(0.33611111111111, $stage_data[1]['hours'], ' stage_data 1 incorrect hours');

        $this->assertEquals('return_to_collection', $stage_data[2]['leg_type'], ' stage_data 2 is not return_to_collection');
        $this->assertEquals(16.825978868863, $stage_data[2]['distance'], ' stage_data 2 incorrect distance');
        $this->assertEquals(0.71277777777778, $stage_data[2]['hours'], ' stage_data 2 incorrect hours');

    }
  
}
