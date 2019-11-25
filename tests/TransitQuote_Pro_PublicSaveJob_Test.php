<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TransitQuote_Pro_PublicTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
      
        $this->test_get_quote_job_post_data = json_decode('{"address_1_address":"1211+6th+Avenue,+New+York,+NY,+USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"1211","address_1_route":"6th+Avenue","address_1_postal_town":"","address_1_administrative_area_level_2":"New+York+County","address_1_administrative_area_level_1":"New+York","address_1_country":"United+States","address_1_lat":"40.7586113","address_1_lng":"-73.98220889999999","address_1_place_id":"ChIJBQb6aP9YwokRbGl86D_BJM0","address_1_journey_order":"1","address_2_address":"456+University+Avenue,+Palo+Alto,+CA,+USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"456","address_2_route":"University+Avenue","address_2_postal_town":"","address_2_administrative_area_level_2":"Santa+Clara+County","address_2_administrative_area_level_1":"California","address_2_country":"United+States","address_2_lat":"37.4476314","address_2_lng":"-122.15957739999999","address_2_place_id":"ChIJ8Ub-_Di7j4AR82fn0uoy1_8","address_2_journey_order":"2","date":"25+November,+2019","delivery_date":"25-11-2019","delivery_time":"3:30+PM","delivery_time_submit":"15:30","weight":"","deliver_and_return":"0","first_name":"test","last_name":"test2","phone":"32432432432","email":"dsafdfds@dsafdad.com","description":"test","job_id":"","rate_hour":"","distance":"2967.84","time":"44.06","return_distance":"","return_time":"","time_cost":"0","notice_cost":"","distance_cost":"6913.08","total":"8295.70","basic_cost":"6913.08","action":"tq_pro4_save_job","rate_tax":"","tax_cost":"1382.62","breakdown":"","surcharge_areas":"","vehicle_id":"1","service_id":"1","submit_type":"pay_method_1","quote_id":"46"}', true);

    }
   

    public function test_save_job_callback() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.4.1');

        $_POST = $_REQUEST = $this->test_get_quote_job_post_data;
        $public->get_plugin_settings();
        $response = $public->tq_pro_save_job_callback();
        $this->assertTrue(is_array($response));
        $this->assertArrayHasKey('success', $response, ' no success status in save job  response');
        $this->assertArrayHasKey('data', $response, ' no data json in save job  response');

        $data = $response['data'];
        $this->assertArrayHasKey('job_id', $data, ' no job_id in response data');
        $this->assertArrayHasKey('quote_id', $data, ' no quote_id in response');
        $this->assertArrayHasKey('customer_id', $data, ' no customer_id in response');
        $this->assertArrayHasKey('email', $data, ' no email in response');

        $public = null;

    }

}