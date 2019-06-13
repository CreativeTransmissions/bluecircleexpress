<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TransitQuote_Pro_PublicTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp();
      
        $this->test_job = json_decode('{"address_0_address":"Aberdeen, UK","address_0_street_number":"79","address_0_route":"Queen Street","address_0_postal_town":"Aberdeen","address_0_administrative_area_level_2":"Aberdeen City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United Kingdom","address_0_lat":"57.1497243","address_0_lng":"-2.094734600000038","address_0_place_id":"ChIJraJa2T0OhEgRfI9jqFoEWyg","address_0_journey_order":"0","address_0_appartment_no":"","address_0_postal_code":"AB10 1AN","address_0_contact_name":"","address_0_contact_phone":"","address_1_address":"Bristol, UK","address_1_appartment_no":"","address_1_postal_code":"","address_1_contact_name":"","address_1_contact_phone":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"","address_1_administrative_area_level_2":"City of Bristol","address_1_administrative_area_level_1":"England","address_1_country":"United Kingdom","address_1_lat":"51.454513","address_1_lng":"-2.5879099999999653","address_1_place_id":"ChIJYdizgWaDcUgRH9eaSy6y5I4","address_1_journey_order":"1","date":"9 May, 2019","delivery_date":"9-5-2019","delivery_time":"","delivery_time_submit":"16:30","service_id":"1","vehicle_id":"1","deliver_and_return":"0","first_name":"Andrew","last_name":"Dev","phone":"12343214321434","email":"hq@transitquote.co.uk","description":"","job_id":"","rate_hour":"","distance":"505.73","time":"8.56","return_distance":"","return_time":"","time_cost":"8.56","notice_cost":"","distance_cost":"1011.46","total":"1224.02","basic_cost":"1020.02","action":"tq_pro4_get_quote","rate_tax":"20","tax_cost":"204","breakdown":[{"distance":"0.00","distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":505.73,"distance_cost":1011.46,"type":"per distance unit","rate":"2.00","cost":1011.46},{"distance":0,"distance_cost":1011.46,"type":"per distance unit","rate":"2.00","return_percentage":"85","cost":0},{"basic_cost":1020.02,"total":1224.02,"type":"VAT","rate":"20","cost":204}],"submit_type":"get_quote","woocommerce-login-nonce":null,"_wpnonce":null}', true);

        $this->test_job_multi_addresses = json_decode('{"address_0_address":"385 Dumbarton Road, Glasgow, UK","address_0_appartment_no":"","address_0_postal_code":"G11 6BE","address_0_street_number":"385","address_0_route":"Dumbarton Road","address_0_postal_town":"Glasgow","address_0_administrative_area_level_2":"Glasgow City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United Kingdom","address_0_lat":"55.87069899999999","address_0_lng":"-4.308279900000002","address_0_place_id":"ChIJORdf39xFiEgRJAAllCRtufc","address_0_journey_order":"0","address_2_address":"45 Union Street, Farnborough, UK","address_2_appartment_no":"","address_2_postal_code":"GU14 7PY","address_2_street_number":"45","address_2_route":"Union Street","address_2_postal_town":"Farnborough","address_2_administrative_area_level_2":"Hampshire","address_2_administrative_area_level_1":"England","address_2_country":"United Kingdom","address_2_lat":"51.29588529999999","address_2_lng":"-0.7622301999999763","address_2_place_id":"ChIJcdPbZS8rdEgREq04rXPkgcw","address_2_journey_order":"1","address_3_address":"600 Capability Green, Luton, UK","address_3_appartment_no":"","address_3_postal_code":"LU1 3LU","address_3_street_number":"600","address_3_route":"Capability Green","address_3_postal_town":"Luton","address_3_administrative_area_level_2":"Luton","address_3_administrative_area_level_1":"England","address_3_country":"United Kingdom","address_3_lat":"51.865285","address_3_lng":"-0.4066980999999714","address_3_place_id":"ChIJ-bI282xIdkgRDgiXg_gg9Oo","address_3_journey_order":"2","address_1_address":"125 Kingsway, London, UK","address_1_appartment_no":"","address_1_postal_code":"WC2B 6NH","address_1_street_number":"125","address_1_route":"Kingsway","address_1_postal_town":"London","address_1_administrative_area_level_2":"Greater London","address_1_administrative_area_level_1":"England","address_1_country":"United Kingdom","address_1_lat":"51.5172068","address_1_lng":"-0.12069050000002335","address_1_place_id":"ChIJLax2AjUbdkgReanoGvFzUkk","address_1_journey_order":"3","date":"28 May, 2019","delivery_date":"28-5-2019","delivery_time":"4:30 PM","delivery_time_submit":"16:30","deliver_and_return":"0","first_name":"Test","last_name":"Dude","phone":"34853485857","email":"testdude@test.co.uk","description":"some stuff","job_id":"","rate_hour":"","distance":"811.53","time":"8.64","return_distance":"","return_time":"","time_cost":"0","notice_cost":"","distance_cost":"1623.06","total":"1623.06","basic_cost":"1623.06","action":"tq_pro4_save_job","rate_tax":"0","tax_cost":"0","breakdown":"[{\"distance\":\"0.00\",\"distance_cost\":0,\"type\":\"set amount\",\"rate\":\"0.00\",\"cost\":\"0.00\"},{\"distance\":811.53,\"distance_cost\":1623.06,\"type\":\"per distance unit\",\"rate\":\"2.00\",\"cost\":1623.06},{\"distance\":0,\"distance_cost\":1623.06,\"type\":\"per distance unit\",\"rate\":\"2.00\",\"return_percentage\":\"100\",\"cost\":0}]","submit_type":"pay_method_1"}', true);


    }
   

    public function test_save_job() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.1');

        $_REQUEST = $this->test_job;
        $public->get_plugin_settings();
        $job_id = $public->save_job();
        $this->assertTrue(($job_id>0));
        $this->assertTrue(is_numeric($job_id));

        $this->assertEquals(8.56,$public->journey['time']);
        $this->assertEquals(true,is_array($public->job));
        $this->assertEquals(8.56,$public->job['journey']['time']);

        $public = null;

    }

    public function test_save_job_multiple_addresses() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.1');

        $_REQUEST = $this->test_job_multi_addresses;

        $public->get_plugin_settings();
        $job_id = $public->save_job();
        $this->assertEquals(8.64,$public->job['journey']['time']);
        $this->assertEquals(811.53,$public->job['journey']['distance']);
        $this->assertEquals(true, is_array($public->job['stops']));

        $this->assertEquals(4, count($public->job['stops']));
  /*      $this->assertEquals(0, $public->job['stops'][0]['journey_order']);
        $this->assertEquals(1, $public->job['stops'][1]['journey_order']);
        $this->assertEquals(2, $public->job['stops'][2]['journey_order']);
        $this->assertEquals(3, $public->job['stops'][3]['journey_order']);
*/
        $this->assertEquals('385 Dumbarton Road, Glasgow, UK', $public->job['stops'][0]['address']);
        $this->assertEquals('G11 6BE', $public->job['stops'][0]['postal_code']);
        $this->assertEquals('385', $public->job['stops'][0]['street_number']);
        $this->assertEquals('Dumbarton Road', $public->job['stops'][0]['route']);
        $this->assertEquals('Glasgow', $public->job['stops'][0]['postal_town']);
        $this->assertEquals('Glasgow City', $public->job['stops'][0]['administrative_area_level_2']);
        $this->assertEquals('Scotland', $public->job['stops'][0]['administrative_area_level_1']);
        $this->assertEquals('United Kingdom', $public->job['stops'][0]['country']);
    //    $this->assertEquals('55.87069899999999', $public->job['stops'][0]['lat']);
        //$this->assertEquals('-4.308279900000002', $public->job['stops'][0]['lng']);
        $this->assertEquals('ChIJORdf39xFiEgRJAAllCRtufc', $public->job['stops'][0]['place_id']);
     //   $this->assertEquals(0, $public->job['stops'][0]['journey_order']);

        $this->assertTrue(($job_id>0));
        $this->assertTrue(is_numeric($job_id));
        $public = null;


    }    
}