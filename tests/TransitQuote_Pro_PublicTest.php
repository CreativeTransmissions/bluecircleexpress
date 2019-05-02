<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TransitQuote_Pro_PublicTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp();
      
        $this->test_job = json_decode('{"address_0_address":"Aberdeen, UK","address_0_street_number":"79","address_0_route":"Queen Street","address_0_postal_town":"Aberdeen","address_0_administrative_area_level_2":"Aberdeen City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United Kingdom","address_0_lat":"57.1497243","address_0_lng":"-2.094734600000038","address_0_place_id":"ChIJraJa2T0OhEgRfI9jqFoEWyg","address_0_journey_order":"0","address_0_appartment_no":"","address_0_postal_code":"AB10 1AN","address_0_contact_name":"","address_0_contact_phone":"","address_1_address":"Bristol, UK","address_1_appartment_no":"","address_1_postal_code":"","address_1_contact_name":"","address_1_contact_phone":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"","address_1_administrative_area_level_2":"City of Bristol","address_1_administrative_area_level_1":"England","address_1_country":"United Kingdom","address_1_lat":"51.454513","address_1_lng":"-2.5879099999999653","address_1_place_id":"ChIJYdizgWaDcUgRH9eaSy6y5I4","address_1_journey_order":"1","date":"9 May, 2019","delivery_date":"9-5-2019","delivery_time":"","delivery_time_submit":"","service_id":"1","vehicle_id":"1","deliver_and_return":"0","first_name":"Andrew","last_name":"Dev","phone":"12343214321434","email":"hq@transitquote.co.uk","description":"","job_id":"","rate_hour":"","distance":"505.73","hours":"8.56","return_distance":"","return_time":"","time_cost":"8.56","notice_cost":"","distance_cost":"1011.46","total":"1224.02","basic_cost":"1020.02","action":"tq_pro4_get_quote","rate_tax":"20","tax_cost":"204","breakdown":"[{"distance":"0.00","distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":505.73,"distance_cost":1011.46,"type":"per distance unit","rate":"2.00","cost":1011.46},{"distance":0,"distance_cost":1011.46,"type":"per distance unit","rate":"2.00","return_percentage":"85","cost":0},{"basic_cost":1020.02,"total":1224.02,"type":"VAT","rate":"20","cost":204}]","submit_type":"get_quote","woocommerce-login-nonce":null,"_wpnonce":null}{"address_0_address":"Aberdeen, UK","address_0_street_number":"79","address_0_route":"Queen Street","address_0_postal_town":"Aberdeen","address_0_administrative_area_level_2":"Aberdeen City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United Kingdom","address_0_lat":"57.1497243","address_0_lng":"-2.094734600000038","address_0_place_id":"ChIJraJa2T0OhEgRfI9jqFoEWyg","address_0_journey_order":"0","address_0_appartment_no":"","address_0_postal_code":"AB10 1AN","address_0_contact_name":"","address_0_contact_phone":"","address_1_address":"Bristol, UK","address_1_appartment_no":"","address_1_postal_code":"","address_1_contact_name":"","address_1_contact_phone":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"","address_1_administrative_area_level_2":"City of Bristol","address_1_administrative_area_level_1":"England","address_1_country":"United Kingdom","address_1_lat":"51.454513","address_1_lng":"-2.5879099999999653","address_1_place_id":"ChIJYdizgWaDcUgRH9eaSy6y5I4","address_1_journey_order":"1","date":"9 May, 2019","delivery_date":"9-5-2019","delivery_time":"","delivery_time_submit":"","service_id":"1","vehicle_id":"1","deliver_and_return":"0","first_name":"Andrew","last_name":"Dev","phone":"12343214321434","email":"hq@transitquote.co.uk","description":"","job_id":"","rate_hour":"","distance":"505.73","hours":"8.56","return_distance":"","return_time":"","time_cost":"8.56","notice_cost":"","distance_cost":"1011.46","total":"1224.02","basic_cost":"1020.02","action":"tq_pro4_get_quote","rate_tax":"20","tax_cost":"204","breakdown":"[{"distance":"0.00","distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":505.73,"distance_cost":1011.46,"type":"per distance unit","rate":"2.00","cost":1011.46},{"distance":0,"distance_cost":1011.46,"type":"per distance unit","rate":"2.00","return_percentage":"85","cost":0},{"basic_cost":1020.02,"total":1224.02,"type":"VAT","rate":"20","cost":204}]","submit_type":"get_quote","woocommerce-login-nonce":null,"_wpnonce":null}');


    }
   

    public function test_save_job() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.0');
        $_POST = $this->test_job;
        $success = $public->save_job();
        $this->assertGreaterThan(0,$public->job->journey['time']);
        $this->assertEquals(8.56,$public->job->journey['time']);
        $this->assertTrue($success);

    }
}