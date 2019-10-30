<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TransitQuote_Pro_PublicTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
      
        $this->test_get_qupte_job_post_data = json_decode('{"address_1_address":"120-55+Queens+Boulevard,+Jamaica,+NY,+USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"120-55","address_1_route":"Queens+Boulevard","address_1_postal_town":"","address_1_administrative_area_level_2":"Queens+County","address_1_administrative_area_level_1":"New+York","address_1_country":"United+States","address_1_lat":"40.7137004","address_1_lng":"-73.8281571","address_1_place_id":"ChIJOWaDw5dgwokRZ_BRb-LVG_o","address_1_journey_order":"1","address_2_address":"4445+Willard+Avenue,+Chevy+Chase,+MD,+USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"4445","address_2_route":"Willard+Avenue","address_2_postal_town":"","address_2_administrative_area_level_2":"Montgomery+County","address_2_administrative_area_level_1":"Maryland","address_2_country":"United+States","address_2_lat":"38.9620431","address_2_lng":"-77.08748209999999","address_2_place_id":"ChIJ90fA8pDJt4kRUiKNVvpTM_E","address_2_journey_order":"2","date":"30+October,+2019","delivery_date":"30-10-2019","delivery_time":"12:00+PM","delivery_time_submit":"12:00","weight":"","deliver_and_return":"0","first_name":"","last_name":"","phone":"","email":"","description":"","job_id":"","rate_hour":"","distance":"290.52","time":"5.22","return_distance":"","return_time":"","time_cost":"","notice_cost":"","distance_cost":"","total":"","basic_cost":"","action":"tq_pro4_get_quote","rate_tax":"","tax_cost":"","breakdown":"","surcharge_areas":"","vehicle_id":"1","service_id":"1","submit_type":"get_quote","directions":"[{\"distance\":{\"text\":\"79.6 km\",\"value\":79555},\"duration\":{\"text\":\"1 hour 8 mins\",\"value\":4062},\"end_address\":\"120-55 Queens Blvd, Jamaica, NY 11424, USA\",\"end_location\":{\"lat\":40.7133033,\"lng\":-73.82832359999998},\"start_address\":\"1713 Hamilton Blvd, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.568286,\"lng\":-74.41747950000001},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]},{\"distance\":{\"text\":\"388 km\",\"value\":387893},\"duration\":{\"text\":\"4 hours 5 mins\",\"value\":14718},\"end_address\":\"4445 Willard Ave suite 800, Chevy Chase, MD 20815, USA\",\"end_location\":{\"lat\":38.9617812,\"lng\":-77.0874609},\"start_address\":\"120-55 Queens Blvd, Jamaica, NY 11424, USA\",\"start_location\":{\"lat\":40.7133033,\"lng\":-73.82832359999998},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}]"}', true);

    }
   

    public function test_get_qutoe_callback() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.4.1');

        $_POST = $_REQUEST = $this->test_get_qupte_job_post_data;
        $public->get_plugin_settings();
        $response = $public->get_quote();
        $this->assertTrue(is_array($response));
        $this->assertArrayHasKey('success', $response, ' no success status in get quote response');
        $this->assertArrayHasKey('data', $response, ' no data json in get quote response');

        $data = $response['data'];
        $this->assertArrayHasKey('quote', $data, ' no quote in response data');

        $quote = $data['quote'];        
        $this->assertArrayHasKey('id', $quote, ' quote has no id');

        $public = null;

    }

}