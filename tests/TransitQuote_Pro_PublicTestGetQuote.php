<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TransitQuote_Pro_PublicTestGetQuote extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
      
        $this->test_get_quote = json_decode('{"Form data":{"address_0_address":"New+York,+NY,+USA","address_0_appartment_no":"","address_0_postal_code":"","address_0_street_number":"","address_0_route":"","address_0_postal_town":"","address_0_administrative_area_level_2":"","address_0_administrative_area_level_1":"New+York","address_0_country":"United+States","address_0_lat":"40.7127753","address_0_lng":"-74.0059728","address_0_place_id":"ChIJOwg_06VPwokRYv534QaPC8g","address_0_journey_order":"0","address_1_address":"Philadelphia,+PA,+USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"","address_1_administrative_area_level_2":"Philadelphia+County","address_1_administrative_area_level_1":"Pennsylvania","address_1_country":"United+States","address_1_lat":"39.9525839","address_1_lng":"-75.16522150000003","address_1_place_id":"ChIJ60u11Ni3xokRwVg-jNgU9Yk","address_1_journey_order":"1","date":"2+October,+2019","delivery_date":"2-10-2019","delivery_time":"12:00+PM","delivery_time_submit":"12:00","weight":"","deliver_and_return":"1","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"188.69","time":"3.48","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"152 km\",\"value\":152180},\"duration\":{\"text\":\"1 hour 45 mins\",\"value\":6312},\"end_address\":\"1598-1500 Market St, Philadelphia, PA 19102, USA\",\"end_location\":{\"lat\":39.9525837,\"lng\":-75.16520079999998},\"start_address\":\"11 Centre St, New York, NY 10007, USA\",\"start_location\":{\"lat\":40.7124773,\"lng\":-74.00620070000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"151 km\",\"value\":151420},\"duration\":{\"text\":\"1 hour 43 mins\",\"value\":6206},\"end_address\":\"11 Centre St, New York, NY 10007, USA\",\"end_location\":{\"lat\":40.7124773,\"lng\":-74.00620070000002},\"start_address\":\"1598-1500 Market St, Philadelphia, PA 19102, USA\",\"start_location\":{\"lat\":39.9525837,\"lng\":-75.16520079999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"}}', true);
    }
   

    public function test_get_quote() {

        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.4.1');

        $_REQUEST = $this->test_get_quote;
        $response = $public->get_quote();
        $this->assertTrue(is_array($public->quote),  'quote is not an array');

        $this->assertTrue(is_array($response));
        $this->assertEquals('true',$response['success']);

        $public = null;

    }

}