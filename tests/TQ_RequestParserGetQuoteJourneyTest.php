<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_RequestParserGetQuoteJourneyTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->test_post_data = json_decode('{"address_0_address":"125 London Wall, London, UK","address_0_appartment_no":"","address_0_postal_code":"EC2Y 5AJ","address_0_street_number":"125","address_0_route":"London Wall","address_0_postal_town":"London","address_0_administrative_area_level_2":"Greater London","address_0_administrative_area_level_1":"England","address_0_country":"United Kingdom","address_0_lat":"51.51757019999999","address_0_lng":"-0.09374779999996008","address_0_place_id":"ChIJKSv0f6ocdkgR8kEi1NgkK2w","address_0_journey_order":"0","address_1_address":"789 Dumbarton Road, Glasgow, UK","address_1_appartment_no":"","address_1_postal_code":"G11 6NA","address_1_street_number":"789","address_1_route":"Dumbarton Road","address_1_postal_town":"Glasgow","address_1_administrative_area_level_2":"Glasgow City","address_1_administrative_area_level_1":"Scotland","address_1_country":"United Kingdom","address_1_lat":"55.87193809999999","address_1_lng":"-4.327030100000002","address_1_place_id":"ChIJFQIi4-9FiEgR1CQQGZVRA50","address_1_journey_order":"1","date":"27 September, 2019","delivery_date":"27-9-2019","delivery_time":"12:30 PM","delivery_time_submit":"12:30","service_id":"1","vehicle_id":"1","deliver_and_return":"0","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"415.50","time":"7.01","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"669 km\",\"value\":668537},\"duration\":{\"text\":\"7 hours 1 min\",\"value\":25240},\"end_address\":\"789 Dumbarton Rd, Glasgow G11 6NA, UK\",\"end_location\":{\"lat\":55.8720377,\"lng\":-4.3269688000000315},\"start_address\":\"125 London Wall, 125 London Wall, Barbican, London, UK\",\"start_location\":{\"lat\":51.5175545,\"lng\":-0.09374769999999444},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"}',true);

        $this->test_post_data_two_legs = json_decode('{"address_0_address":"Aberdeen,+UK","address_0_appartment_no":"","address_0_postal_code":"","address_0_street_number":"","address_0_route":"","address_0_postal_town":"","address_0_administrative_area_level_2":"Aberdeen+City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United+Kingdom","address_0_lat":"57.149717","address_0_lng":"-2.094278000000031","address_0_place_id":"ChIJSXXXH0wFhEgRcsT0XNoFu-g","address_0_journey_order":"0","address_1_address":"Inverness,+UK","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"Inverness","address_1_administrative_area_level_2":"Highland+Council","address_1_administrative_area_level_1":"Scotland","address_1_country":"United+Kingdom","address_1_lat":"57.477773","address_1_lng":"-4.224721000000045","address_1_place_id":"ChIJK94XLVtxj0gRPcQ-LtEJQ2I","address_1_journey_order":"1","date":"30+September,+2019","delivery_date":"30-9-2019","delivery_time":"11:30+AM","delivery_time_submit":"11:30","service_id":"1","vehicle_id":"1","deliver_and_return":"1","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"208.93","time":"5.09","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"168 km\",\"value\":167949},\"duration\":{\"text\":\"2 hours 32 mins\",\"value\":9098},\"end_address\":\"19 High St, Inverness IV1 1HY, UK\",\"end_location\":{\"lat\":57.47761209999999,\"lng\":-4.2248508999999785},\"start_address\":\"79 Queen St, Aberdeen AB10 1AN, UK\",\"start_location\":{\"lat\":57.1499123,\"lng\":-2.0941688999999997},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"168 km\",\"value\":168219},\"duration\":{\"text\":\"2 hours 34 mins\",\"value\":9217},\"end_address\":\"79 Queen St, Aberdeen AB10 1AN, UK\",\"end_location\":{\"lat\":57.1499123,\"lng\":-2.0941688999999997},\"start_address\":\"19 High St, Inverness IV1 1HY, UK\",\"start_location\":{\"lat\":57.47761209999999,\"lng\":-4.2248508999999785},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"}', true);

        $this->request_parser_get_quote = new TransitQuote_Pro4\TQ_RequestParserGetQuote(array('debugging'=>true,
                                                                                                'post_data'=>$this->test_post_data,
                                                                                                'use_weekend_rates'=>false,
                                                                                                'use_holiday_rates'=>false,
                                                                                                'use_out_of_hours_rates'=>false,
                                                                                                'distance_unit'=>'Kilometer',

                                                                                                'location_fields'=>json_decode('["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"]',true),

                                                                                                'journey_fields'=>json_decode('["id","job_id","distance","time","created","modified"]',true),

                                                                                                'journeys_locations_fields'=>json_decode('["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"]',true)
                                                                                            ));        


        $this->request_parser_get_quote_return_to_pickup = new TransitQuote_Pro4\TQ_RequestParserGetQuote(array('debugging'=>true,
                                                                                                'post_data'=>$this->test_post_data_two_legs,
                                                                                                'use_weekend_rates'=>false,
                                                                                                'use_holiday_rates'=>false,
                                                                                                'use_out_of_hours_rates'=>false,
                                                                                                'distance_unit'=>'Kilometer',

                                                                                                'location_fields'=>json_decode('["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"]["id","job_id","distance","time","created","modified"]',true),

                                                                                                'journey_fields'=>json_decode('["id","job_id","distance","time","created","modified"]',true),

                                                                                                'journeys_locations_fields'=>json_decode('["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"]',true)
                                                                                            ));       

        $this->request_parser_get_quote_dispatch = new TransitQuote_Pro4\TQ_RequestParserGetQuote(array('debugging'=>true,
                                                                                                        'post_data'=>$this->test_post_data_two_legs,
                                                                                                        'use_weekend_rates'=>false,
                                                                                                        'use_holiday_rates'=>false,
                                                                                                        'use_out_of_hours_rates'=>false,
                                                                                                        'use_dispatch_rates'=>true,
                                                                                                        'distance_unit'=>'Mile',

                                                                                                'location_fields'=>json_decode('["id","address","appartment_no","street_number","postal_town","route","administrative_area_level_2","administrative_area_level_1","country","postal_code","lat","lng","place_id","created","modified"]["id","job_id","distance","time","created","modified"]',true),

                                                                                                'journey_fields'=>json_decode('["id","job_id","distance","time","created","modified"]',true),

                                                                                                'journeys_locations_fields'=>json_decode('["id","journey_id","location_id","journey_order","note","created","modified","contact_name","contact_phone"]',true)
                                                                                            ));   
    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }

    public function test_get_journey_distance() {  
        $journey_distance = $this->request_parser_get_quote->get_journey_distance();

        var_dump($journey_distance);
        $this->assertTrue(is_numeric($journey_distance));
        $this->assertEquals(668.537, $journey_distance);
    }

    
    public function test_get_journey_data_one_leg() {

        $journey_data = $this->request_parser_get_quote->get_journey_data();
        $this->assertTrue(is_array($journey_data));

        $this->assertArrayHasKey('journey', $journey_data);
       // $this->assertArrayHasKey('stages', $journey_data);        
        $this->assertArrayHasKey('legs', $journey_data);

        $this->assertTrue(is_array($journey_data['journey']), ' journey is not array');
        $this->assertTrue(is_array($journey_data['legs']), ' legs is not array');

        $this->assertCount(1, $journey_data['legs'], ' journey has wrong number of legs');

        $this->assertArrayHasKey('directions_response', $journey_data['legs'][0]);
        $this->assertArrayHasKey('distance', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['distance']),  'not numeric distance: '.$journey_data['legs'][0]['distance']);

        $this->assertArrayHasKey('time', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['time']),  'not numeric time: '.$journey_data['legs'][0]['time']);

        $this->assertArrayHasKey('leg_order', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['leg_order']),  'not numeric leg_order: '.$journey_data['legs'][0]['leg_order']);

        $this->assertArrayHasKey('leg_type_id', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['leg_type_id']),  'not numeric leg_type_id: '.$journey_data['legs'][0]['leg_type_id']);

    }


    public function test_get_leg_distance(){
        $this->request_parser_get_quote->parse_legs();        
        $leg_0_distance = $this->request_parser_get_quote->get_leg_distance(0, 'Kilometer');
        $this->assertTrue(is_numeric($leg_0_distance));

        $this->request_parser_get_quote_return_to_pickup->parse_legs();        
        $leg_0_distance = $this->request_parser_get_quote_return_to_pickup->get_leg_distance(0, 'Kilometer'); 
        $this->assertTrue(is_numeric($leg_0_distance));

    }
    public function test_get_leg_data(){
        $this->request_parser_get_quote->parse_legs();
        $no_legs = count($this->request_parser_get_quote->legs);

        $leg_data = $this->request_parser_get_quote->get_leg_data();
        $this->assertTrue(is_array($leg_data));
        $this->assertCount($no_legs, $leg_data);        

        $this->assertArrayHasKey('directions_response', $leg_data[0]);
        $this->assertArrayHasKey('distance', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['distance']),  'not numeric distance: '.$leg_data[0]['distance']);

        $this->assertArrayHasKey('time', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['time']),  'not numeric time: '.$leg_data[0]['time']);

        $this->assertArrayHasKey('leg_order', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['leg_order']),  'not numeric leg_order: '.$leg_data[0]['leg_order']);

        $this->assertArrayHasKey('leg_type_id', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['leg_type_id']),  'not numeric leg_type_id: '.$leg_data[0]['leg_type_id']);


    }

    public function test_get_leg_data_two_leg(){
        $this->request_parser_get_quote_return_to_pickup->parse_legs();

        $leg_data = $this->request_parser_get_quote_return_to_pickup->get_leg_data();
        $this->assertTrue(is_array($leg_data));
        $this->assertCount(2, $leg_data);        

        $this->assertArrayHasKey('directions_response', $leg_data[0]);
        $this->assertArrayHasKey('distance', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['distance']),  'not numeric distance: '.$leg_data[0]['distance']);

        $this->assertArrayHasKey('time', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['time']),  'not numeric time: '.$leg_data[0]['time']);

        $this->assertArrayHasKey('leg_order', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['leg_order']),  'not numeric leg_order: '.$leg_data[0]['leg_order']);

        $this->assertArrayHasKey('leg_type_id', $leg_data[0]);
        $this->assertTrue(is_numeric($leg_data[0]['leg_type_id']),  'not numeric leg_type_id: '.$leg_data[0]['leg_type_id']);


    }


    public function test_get_journey_data_two_leg() {

        $journey_data = $this->request_parser_get_quote_return_to_pickup->get_journey_data();
        $this->assertTrue(is_array($journey_data));

        $this->assertArrayHasKey('journey', $journey_data);
       // $this->assertArrayHasKey('stages', $journey_data);        
        $this->assertArrayHasKey('legs', $journey_data);

        $this->assertTrue(is_array($journey_data['journey']), ' journey is not array');
        $this->assertTrue(is_array($journey_data['legs']), ' legs is not array');
        $this->assertcount(2,$journey_data['legs'], ' journey has wrong number of legs');


        $this->assertArrayHasKey('directions_response', $journey_data['legs'][0]);
        $this->assertArrayHasKey('distance', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['distance']),  'not numeric distance: '.$journey_data['legs'][0]['distance']);

        $this->assertArrayHasKey('time', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['time']),  'not numeric time: '.$journey_data['legs'][0]['time']);

        $this->assertArrayHasKey('leg_order', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['leg_order']),  'not numeric leg_order: '.$journey_data['legs'][0]['leg_order']);

        $this->assertArrayHasKey('leg_type_id', $journey_data['legs'][0]);
        $this->assertTrue(is_numeric($journey_data['legs'][0]['leg_type_id']),  'not numeric leg_type_id: '.$journey_data['legs'][0]['leg_type_id']);

        $this->assertArrayHasKey('directions_response', $journey_data['legs'][1]);
        $this->assertArrayHasKey('distance', $journey_data['legs'][1]);
        $this->assertTrue(is_numeric($journey_data['legs'][1]['distance']),  'not numeric distance: '.$journey_data['legs'][1]['distance']);

        $this->assertArrayHasKey('time', $journey_data['legs'][1]);
        $this->assertTrue(is_numeric($journey_data['legs'][1]['time']),  'not numeric time: '.$journey_data['legs'][1]['time']);

        $this->assertArrayHasKey('leg_order', $journey_data['legs'][1]);
        $this->assertTrue(is_numeric($journey_data['legs'][1]['leg_order']),  'not numeric leg_order: '.$journey_data['legs'][1]['leg_order']);

        $this->assertArrayHasKey('leg_type_id', $journey_data['legs'][1]);
        $this->assertTrue(is_numeric($journey_data['legs'][1]['leg_type_id']),  'not numeric leg_type_id: '.$journey_data['legs'][1]['leg_type_id']);
    }    

    public function test_get_record_data_locations(){
        $locations = $this->request_parser_get_quote->get_record_data_locations();
        echo ' locations for testing:';
        echo json_encode($locations);
        $this->assertTrue(is_array($this->request_parser_get_quote->config['location_fields']));
        $this->assertTrue(is_array($locations));
        $this->assertCount(2, $locations);

        $this->assertArrayHasKey('address', $locations[0]);
        $this->assertArrayHasKey('appartment_no', $locations[0]);
        $this->assertArrayHasKey('street_number', $locations[0]);
        $this->assertArrayHasKey('postal_town', $locations[0]);
        $this->assertArrayHasKey('route', $locations[0]);
        $this->assertArrayHasKey('administrative_area_level_2', $locations[0]);
        $this->assertArrayHasKey('administrative_area_level_1', $locations[0]);
        $this->assertArrayHasKey('country', $locations[0]);
        $this->assertArrayHasKey('postal_code', $locations[0]);
        $this->assertArrayHasKey('lat', $locations[0]);
        $this->assertArrayHasKey('lng', $locations[0]);
        $this->assertArrayHasKey('place_id', $locations[0]);


        $this->assertArrayHasKey('address', $locations[1]);
        $this->assertArrayHasKey('appartment_no', $locations[1]);
        $this->assertArrayHasKey('street_number', $locations[1]);
        $this->assertArrayHasKey('postal_town', $locations[1]);
        $this->assertArrayHasKey('route', $locations[1]);
        $this->assertArrayHasKey('administrative_area_level_2', $locations[1]);
        $this->assertArrayHasKey('administrative_area_level_1', $locations[1]);
        $this->assertArrayHasKey('country', $locations[1]);
        $this->assertArrayHasKey('postal_code', $locations[1]);
        $this->assertArrayHasKey('lat', $locations[1]);
        $this->assertArrayHasKey('lng', $locations[1]);
        $this->assertArrayHasKey('place_id', $locations[1]);
    }

    public function test_get_record_data_journey(){
        $journey = $this->request_parser_get_quote->get_record_data_journey();
        $this->assertTrue(is_array($this->request_parser_get_quote->config['journey_fields']));
        $this->assertTrue(is_array($journey));
    

        $this->assertArrayHasKey('distance', $journey);
        $this->assertArrayHasKey('time', $journey);
        
    }
  
}
