<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;


final class TQ_RequestParserGetQuoteTest extends TestCase
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
                                                                                                'use_out_of_hours_rates'=>false));        


        $this->request_parser_get_quote_return_to_pickup = new TransitQuote_Pro4\TQ_RequestParserGetQuote(array('debugging'=>true,
                                                                                                'post_data'=>$this->test_post_data_two_legs,
                                                                                                'use_weekend_rates'=>false,
                                                                                                'use_holiday_rates'=>false,
                                                                                                'use_out_of_hours_rates'=>false));         
    }
   
    protected function tearDown(){
        $this->request_parser_get_quote = null;
    }


    public function test_get_rate_affecting_options() {

        $options = $this->request_parser_get_quote->get_rate_affecting_options();
        $this->assertTrue(is_array($options));

        $this->assertArrayHasKey('delivery_date', $options);
        $this->assertArrayHasKey('delivery_time', $options);
        $this->assertArrayHasKey('vehicle_id', $options);
        $this->assertArrayHasKey('service_id', $options);
        $this->assertArrayHasKey('distance', $options);
        $this->assertArrayHasKey('return_time', $options);
        $this->assertArrayHasKey('deliver_and_return', $options);
        $this->assertArrayHasKey('return_distance', $options);
        $this->assertArrayHasKey('no_destinations', $options);
        $this->assertArrayHasKey('hours', $options);

    }

    public function test_parse_legs() {

        $this->request_parser_get_quote->parse_legs();
        $this->assertTrue(is_array($this->request_parser_get_quote->legs));
        $this->assertCount(1, $this->request_parser_get_quote->legs);

        $this->request_parser_get_quote_return_to_pickup->parse_legs();
        $this->assertTrue(is_array($this->request_parser_get_quote_return_to_pickup->legs));
        $this->assertCount(2, $this->request_parser_get_quote_return_to_pickup->legs);        
    }

    public function test_leg_count() {

        $no_legs = $this->request_parser_get_quote->leg_count();
        $this->assertTrue(is_numeric($no_legs));
        $this->assertEquals(1, $no_legs);

        $no_legs = $this->request_parser_get_quote_return_to_pickup->leg_count();
        $this->assertTrue(is_numeric($no_legs));
        $this->assertEquals(2, $no_legs);        
    }

    public function test_get_leg() {

        $leg = $this->request_parser_get_quote->get_leg(0);
        $this->assertTrue(is_array($leg));

        $leg = $this->request_parser_get_quote->get_leg(9);
        $this->assertFalse($leg);

        $leg = $this->request_parser_get_quote_return_to_pickup->get_leg(1);
        $this->assertTrue(is_array($leg));        

    }    

    public function test_get_leg_distance_meters(){

        $leg_distance = $this->request_parser_get_quote->get_leg_distance_meters(0);
        $this->assertTrue(is_numeric($leg_distance));
        $this->assertEquals(668537, $leg_distance);

    }

    public function test_get_leg_distance_kilometers(){

        $leg_distance = $this->request_parser_get_quote->get_leg_distance_kilometers(0);
        $this->assertTrue(is_numeric($leg_distance));
        $this->assertEquals(668.537, $leg_distance);

        $leg_distance_0 = $this->request_parser_get_quote_return_to_pickup->get_leg_distance_kilometers(0);
        $leg_distance_1 = $this->request_parser_get_quote_return_to_pickup->get_leg_distance_kilometers(1);

        $leg_0_meters = 167949/1000;
        $leg_1_meters = 168219/1000;

        $this->assertEquals($leg_0_meters, $leg_distance_0);
        $this->assertEquals($leg_1_meters, $leg_distance_1);


    }

    public function test_get_leg_distance_miles(){

        $leg_distance = $this->request_parser_get_quote->get_leg_distance_miles(0);
        $this->assertTrue(is_numeric($leg_distance));
        $this->assertEquals(415.4984462399006, $leg_distance);

    }    

    public function test_get_leg_distance_text(){

        $leg_distance = $this->request_parser_get_quote->get_leg_distance_text(0);
        $this->assertEquals('669 km', $leg_distance);

    }

    public function test_get_journey_distance_miles(){

        $journey_distance = $this->request_parser_get_quote->get_journey_distance_miles();
        $this->assertTrue(is_numeric($journey_distance));
        $this->assertEquals(415.4984462399006, $journey_distance);

        $journey_distance = $this->request_parser_get_quote_return_to_pickup->get_journey_distance_miles();
        $this->assertTrue(is_numeric($journey_distance));
        $this->assertEquals(208.9297700435053, $journey_distance);

        
    }


    public function test_get_journey_distance_kilometers(){

        $journey_distance = $this->request_parser_get_quote->get_journey_distance_kilometers();
        $this->assertTrue(is_numeric($journey_distance));
        $this->assertEquals(668.537, $journey_distance);

        $journey_distance = $this->request_parser_get_quote_return_to_pickup->get_journey_distance_kilometers();
        $this->assertTrue(is_numeric($journey_distance));

        $leg_0_km = 167949/1000;
        $leg_1_km = 168219/1000;        

        $journey_distance_km = $leg_0_km+$leg_1_km;

        $this->assertEquals($journey_distance_km, $journey_distance);        
        

    }

    public function test_using_location_dates(){
        $using_location_dates = $this->request_parser_get_quote->using_location_dates();
        $this->assertFalse($using_location_dates);

    }

}
