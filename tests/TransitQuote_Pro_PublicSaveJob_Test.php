<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TransitQuote_Pro_PublicTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
      
        $this->test_get_quote_job_post_data = json_decode('{"address_1_address":"Aberdeen,+MD,+USA","address_1_appartment_no":"","address_1_postal_code":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"","address_1_administrative_area_level_2":"Harford+County","address_1_administrative_area_level_1":"Maryland","address_1_country":"United+States","address_1_lat":"39.5095556","address_1_lng":"-76.16411970000001","address_1_place_id":"ChIJAeMIvYXBx4kRdLSNqBgdFj4","address_1_journey_order":"1","address_2_address":"Westfield+Valley+Fair,+Stevens+Creek+Boulevard,+Santa+Clara,+CA,+USA","address_2_appartment_no":"","address_2_postal_code":"","address_2_street_number":"2855","address_2_route":"Stevens+Creek+Boulevard","address_2_postal_town":"","address_2_administrative_area_level_2":"","address_2_administrative_area_level_1":"California","address_2_country":"United+States","address_2_lat":"37.3255657","address_2_lng":"-121.94500019999998","address_2_place_id":"ChIJgexMlR_Lj4ARSvwSxukOgys","address_2_journey_order":"2","date":"25+November,+2019","delivery_date":"25-11-2019","delivery_time":"5:00+PM","delivery_time_submit":"17:00","weight":"","deliver_and_return":"0","first_name":"Andrew","last_name":"testjourney","phone":"349578349587","email":"testjourney@test.com","description":"test","job_id":"","rate_hour":"","distance":"3017.81","time":"44.37","return_distance":"","return_time":"","time_cost":"0","notice_cost":"","distance_cost":"6854.06","total":"8224.87","basic_cost":"6854.06","action":"tq_pro4_save_job","rate_tax":"","tax_cost":"1370.81","breakdown":"","surcharge_areas":"","vehicle_id":"1","service_id":"1","submit_type":"pay_method_1","quote_id":"47","journey_id":"72"}', true);

    }
   
    public function test_save_new_job(){
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.4.1');

        $_POST = $_REQUEST = $this->test_get_quote_job_post_data;
        $public->get_plugin_settings();
        $job_id = $public->save_new_job();
        $this->assertTrue(is_numeric($job_id), ' saved job id is not numeric');
        $this->assertTrue(is_numeric($public->job['customer_id']), ' saved job customer_id is not numeric');
        $this->assertTrue(is_numeric($public->job['accepted_quote_id']), ' saved job accepted_quote_id is not numeric');
        $this->assertTrue(is_numeric($public->journey['job_id']), ' saved journeys job id is not numeric');
        $this->assertEquals($public->job['id' ], $public->journey['job_id'], ' saved journeys job id is not numeric');


        $public = null;

    }
 
 /*   public function test_save_job_callback() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.4.1');

        $_POST = $_REQUEST = $this->test_get_quote_job_post_data;
        $public->get_plugin_settings();
        $response = $public->tq_pro_save_job_callback();
        $this->assertTrue(is_array($response), ' Callback response is not array');
        $this->assertArrayHasKey('success', $response, ' no success status in save job  response');
        $this->assertArrayHasKey('data', $response, ' no data json in save job  response');

        $data = $response['data'];
        $this->assertArrayHasKey('job_id', $data, ' no job_id in response data');
        $this->assertArrayHasKey('quote_id', $data, ' no quote_id in response');
        $this->assertArrayHasKey('customer_id', $data, ' no customer_id in response');
        $this->assertArrayHasKey('email', $data, ' no email in response');

        $public = null;

    }*/

}