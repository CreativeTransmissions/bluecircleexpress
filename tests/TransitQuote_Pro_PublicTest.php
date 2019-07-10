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

        $this->test_save_job_collection_date_fields_post_data = json_decode('{"address_0_address":"Aberdeen,+UK","address_0_appartment_no":"1","address_0_postal_code":"","address_0_contact_name":"","address_0_contact_phone":"","address_0_collection_date":"30-06-2019","address_0_collection_time":"12:00+PM","address_0_collection_time_submit":"12:00","address_0_street_number":"","address_0_route":"","address_0_postal_town":"","address_0_administrative_area_level_2":"Aberdeen+City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United+Kingdom","address_0_lat":"57.149717","address_0_lng":"-2.094278000000031","address_0_place_id":"ChIJSXXXH0wFhEgRcsT0XNoFu-g","address_0_journey_order":"0","address_2_address":"Edinburgh,+UK","address_2_appartment_no":"","address_2_postal_code":"","address_2_contact_name":"","address_2_contact_phone":"","address_2_collection_date":"01-07-2019","address_2_collection_time":"12:15+PM","address_2_collection_time_submit":"12:15","address_2_street_number":"","address_2_route":"","address_2_postal_town":"","address_2_administrative_area_level_2":"Edinburgh","address_2_administrative_area_level_1":"Scotland","address_2_country":"United+Kingdom","address_2_lat":"55.953252","address_2_lng":"-3.188266999999996","address_2_place_id":"ChIJIyaYpQC4h0gRJxfnfHsU8mQ","address_2_journey_order":"1","address_1_address":"Glasgow,+UK","address_1_appartment_no":"","address_1_postal_code":"","address_1_contact_name":"","address_1_contact_phone":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"Glasgow","address_1_administrative_area_level_2":"Glasgow+City","address_1_administrative_area_level_1":"Scotland","address_1_country":"United+Kingdom","address_1_lat":"55.864237","address_1_lng":"-4.251805999999988","address_1_place_id":"ChIJ685WIFYViEgRHlHvBbiD5nE","address_1_journey_order":"2","delivery_date":"02-07-2019","delivery_time":"12:15+PM","delivery_time_submit":"12:15","service_id":"1","vehicle_id":"2","deliver_and_return":"0","first_name":"Test","last_name":"test","phone":"321654987","email":"test@test.com","description":"test","job_id":"","rate_hour":"","distance":"174.15","time":"3.65","return_distance":"","return_time":"","time_cost":"0","notice_cost":"","distance_cost":"140.61","total":"168.73","basic_cost":"140.61","action":"tq_pro4_pay_now","rate_tax":"20","tax_cost":"28.12","breakdown":"[{\"distance\":\"20.00\",\"distance_cost\":25,\"type\":\"set+amount\",\"rate\":\"25.00\",\"cost\":\"25.00\"},{\"distance\":154.15,\"distance_cost\":140.6125,\"type\":\"per+distance+unit\",\"rate\":\"0.75\",\"cost\":115.61250000000001},{\"distance\":0,\"distance_cost\":140.6125,\"type\":\"per+distance+unit\",\"rate\":\"0.75\",\"return_percentage\":true,\"cost\":0},{\"basic_cost\":140.6125,\"total\":168.73250000000002,\"type\":\"VAT\",\"rate\":\"20\",\"cost\":28.12}]","submit_type":"pay_method_3"}', true);

        $this->test_save_job_weight_customer_reference_post_data = json_decode('{"address_0_address":"Aberdeen,+UK","address_0_appartment_no":"","address_0_postal_code":"","address_0_contact_name":"","address_0_contact_phone":"","address_0_collection_date":"01-07-2019","address_0_collection_time":"1:30+PM","address_0_collection_time_submit":"13:30","address_0_street_number":"","address_0_route":"","address_0_postal_town":"","address_0_administrative_area_level_2":"Aberdeen+City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United+Kingdom","address_0_lat":"57.149717","address_0_lng":"-2.094278000000031","address_0_place_id":"ChIJSXXXH0wFhEgRcsT0XNoFu-g","address_0_journey_order":"0","address_2_address":"Edinburgh,+UK","address_2_appartment_no":"","address_2_postal_code":"","address_2_contact_name":"","address_2_contact_phone":"","address_2_collection_date":"01-07-2019","address_2_collection_time":"1:30+PM","address_2_collection_time_submit":"13:30","address_2_street_number":"","address_2_route":"","address_2_postal_town":"","address_2_administrative_area_level_2":"Edinburgh","address_2_administrative_area_level_1":"Scotland","address_2_country":"United+Kingdom","address_2_lat":"55.953252","address_2_lng":"-3.188266999999996","address_2_place_id":"ChIJIyaYpQC4h0gRJxfnfHsU8mQ","address_2_journey_order":"1","address_1_address":"London,+UK","address_1_appartment_no":"","address_1_postal_code":"","address_1_contact_name":"","address_1_contact_phone":"","address_1_street_number":"","address_1_route":"","address_1_postal_town":"London","address_1_administrative_area_level_2":"Greater+London","address_1_administrative_area_level_1":"England","address_1_country":"United+Kingdom","address_1_lat":"51.5073509","address_1_lng":"-0.12775829999998223","address_1_place_id":"ChIJdd4hrwug2EcRmSrV3Vo6llI","address_1_journey_order":"2","delivery_date":"01-07-2019","delivery_time":"1:30+PM","delivery_time_submit":"13:30","service_id":"1","vehicle_id":"2","deliver_and_return":"0","first_name":"Test","last_name":"Guy","phone":"123213123123","email":"test@testguy.com","description":"test","weight":"1925.38","customer_reference":"RTHJ45867","job_id":"","rate_hour":"","distance":"523.87","time":"9.95","return_distance":"","return_time":"","time_cost":"0","notice_cost":"","distance_cost":"402.90","total":"483.48","basic_cost":"402.90","action":"tq_pro4_pay_now","rate_tax":"20","tax_cost":"80.58","breakdown":"[{\"distance\":\"20.00\",\"distance_cost\":25,\"type\":\"set+amount\",\"rate\":\"25.00\",\"cost\":\"25.00\"},{\"distance\":503.87,\"distance_cost\":402.90250000000003,\"type\":\"per+distance+unit\",\"rate\":\"0.75\",\"cost\":377.90250000000003},{\"distance\":0,\"distance_cost\":402.90250000000003,\"type\":\"per+distance+unit\",\"rate\":\"0.75\",\"return_percentage\":true,\"cost\":0},{\"basic_cost\":402.90250000000003,\"total\":483.4825,\"type\":\"VAT\",\"rate\":\"20\",\"cost\":80.58}]","submit_type":"pay_method_3"}', true);


        $this->test_for_email_post_data = json_decode('{"address_0_address":"10+Union+Street,+Aberdeen,+UK","address_0_appartment_no":"1a","address_0_postal_code":"AB11+5BU","address_0_contact_name":"Contact1","address_0_contact_phone":"1111111","address_0_collection_date":"04-07-2019","address_0_collection_time":"8:30+AM","address_0_collection_time_submit":"08:30","address_0_street_number":"10","address_0_route":"Union+Street","address_0_postal_town":"Aberdeen","address_0_administrative_area_level_2":"Aberdeen+City","address_0_administrative_area_level_1":"Scotland","address_0_country":"United+Kingdom","address_0_lat":"57.14766989999999","address_0_lng":"-2.094782699999996","address_0_place_id":"EiIxMCBVbmlvbiBTdCwgQWJlcmRlZW4gQUIxMSA1QlUsIFVLIhoSGAoUChIJhXlVITwOhEgR325DCusvaPIQCg","address_0_journey_order":"0","address_2_address":"10+Academy+Street,+Inverness,+UK","address_2_appartment_no":"2b","address_2_postal_code":"IV2+3TL","address_2_contact_name":"Contact2","address_2_contact_phone":"2222222","address_2_collection_date":"05-07-2019","address_2_collection_time":"8:45+AM","address_2_collection_time_submit":"08:45","address_2_street_number":"10","address_2_route":"Academy+Street","address_2_postal_town":"Inverness","address_2_administrative_area_level_2":"Highland","address_2_administrative_area_level_1":"Scotland","address_2_country":"United+Kingdom","address_2_lat":"57.47903409999999","address_2_lng":"-4.222314099999949","address_2_place_id":"EiQxMCBBY2FkZW15IFN0LCBJbnZlcm5lc3MgSVYyIDNUTCwgVUsiGhIYChQKEgnvmROXTXGPSBGk4wUTAS6KTxAK","address_2_journey_order":"1","address_1_address":"100+Argyle+Street,+Glasgow,+UK","address_1_appartment_no":"3c","address_1_postal_code":"G2+8BH","address_1_contact_name":"contact3","address_1_contact_phone":"3333333","address_1_street_number":"100","address_1_route":"Argyle+Street","address_1_postal_town":"Glasgow","address_1_administrative_area_level_2":"Glasgow+City","address_1_administrative_area_level_1":"Scotland","address_1_country":"United+Kingdom","address_1_lat":"55.8580179","address_1_lng":"-4.25363619999996","address_1_place_id":"EiExMDAgQXJneWxlIFN0LCBHbGFzZ293IEcyIDhCSCwgVUsiGhIYChQKEgkNuJU8n0aISBEmrIuavtWmbRBk","address_1_journey_order":"2","delivery_date":"04-07-2019","delivery_time":"8:30+AM","delivery_time_submit":"08:30","service_id":"1","vehicle_id":"2","deliver_and_return":"0","first_name":"TestFirstName2","last_name":"TestLastName","phone":"9999999","email":"customer2@email.com","description":"Test+Description","weight":"100","customer_reference":"T8476593","job_id":"","rate_hour":"","distance":"272.14","time":"5.70","return_distance":"","return_time":"","time_cost":"0","notice_cost":"","distance_cost":"214.11","total":"256.93","basic_cost":"214.11","action":"tq_pro4_pay_now","rate_tax":"20","tax_cost":"42.82","breakdown":"[{\"distance\":\"20.00\",\"distance_cost\":25,\"type\":\"set+amount\",\"rate\":\"25.00\",\"cost\":\"25.00\"},{\"distance\":252.14,\"distance_cost\":214.105,\"type\":\"per+distance+unit\",\"rate\":\"0.75\",\"cost\":189.105},{\"distance\":0,\"distance_cost\":214.105,\"type\":\"per+distance+unit\",\"rate\":\"0.75\",\"return_percentage\":true,\"cost\":0},{\"basic_cost\":214.105,\"total\":256.925,\"type\":\"VAT\",\"rate\":\"20\",\"cost\":42.82}]","submit_type":"pay_method_3"}', true);

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

        $ref = $public->job['job_ref'];
        
        $this->assertTrue(is_string($ref), 'Ref is not a string');
        $this->assertTrue((strlen($ref) === 12), 'Ref is not 12 chars');
        $this->assertTrue(substr($ref, 0, 3)==='BCE');

        $this->assertFalse(empty($public->dispatch_email));
        $this->assertFalse(empty($public->customer_email));

        $public = null;

    }  

    public function test_save_job_collection_date_fields() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.1');

        $_REQUEST = $this->test_save_job_collection_date_fields_post_data;

        $public->get_plugin_settings();
        $job_id = $public->save_job();

        $this->assertEquals(true, is_array($public->job['stops']));

        $this->assertEquals(3, count($public->job['stops']));
        $this->assertEquals('2019-06-30 12:00:00', $public->job['stops'][0]['collection_date'], 'test_save_job_collection_date_fields: 2019-06-30 12:00:00');
        $this->assertEquals('2019-07-01 12:15:00', $public->job['stops'][2]['collection_date']);

        $this->assertTrue(($job_id>0));
        $this->assertTrue(is_numeric($job_id));

        $this->assertFalse(empty($public->dispatch_email));
        $this->assertFalse(empty($public->customer_email));

        // now load and check we have the right info
        $public->get_job_details_from_id($job_id);

        $this->assertEquals('2019-06-30 12:00:00', $public->job['stops'][0]['collection_date'], 'test_save_job_collection_date_fields: 2019-06-30 12:00:00');
        $this->assertEquals('2019-07-01 12:15:00', $public->job['stops'][2]['collection_date']);

        $public = null;

    }

    public function test_all_email_fields() {
        $this->public = $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.1');

        $_REQUEST = $this->test_for_email_post_data;

        $public->get_plugin_settings();

        $journey_order = $public->get_journey_order_from_request_data();

        $job_id = $public->save_job();
        $this->assertEquals(true, is_array($public->job['stops']));
        $this->assertEquals(true, is_array($public->job['customer']));

        $this->assertEquals(3, count($public->job['stops']));
        $this->assertTrue(($job_id>0));
        $this->assertTrue(is_numeric($job_id));

        $this->assertFalse(empty($public->dispatch_email));
        $this->assertFalse(empty($public->customer_email));

        // now load and check we have the right info
        $public->get_job_details_from_id($job_id);

        foreach ($this->test_for_email_post_data as $key => $value) {
            if($this->is_param_for_emmail($key)){
                $test_value = $this->format_param_for_email($key, $value);
                $this->assertContains($test_value, $public->html_email, $test_value.' is not in dipatch html_email');                
            };
        };

        foreach ($this->test_for_email_post_data as $key => $value) {
            if($this->is_param_for_emmail($key)){
                $test_value = $this->format_param_for_email($key, $value);
                $this->assertContains($test_value, $public->customer_html_email, $test_value.' is not in customer_html_email');                
            };
        };
        $public = null;

    }   

    public function is_param_for_emmail($key){
            switch ($key) {
                case 'address_0_collection_time':
                case 'address_1_collection_time':
                case 'address_2_collection_time':

                case 'address_0_administrative_area_level_1':
                case 'address_1_administrative_area_level_1':
                case 'address_2_administrative_area_level_1':

                case 'address_0_administrative_area_level_2':
                case 'address_1_administrative_area_level_2':
                case 'address_2_administrative_area_level_2':

                case 'address_0_country':                
                case 'address_1_country':
                case 'address_2_country':

                case 'address_0_lat':                
                case 'address_1_lat':
                case 'address_2_lat':

                case 'address_0_lng':                
                case 'address_1_lng':
                case 'address_2_lng':                

                case 'address_0_postal_town':                
                case 'address_0_route':                
                case 'address_0_street_number':                
                case 'address_0_postal_code':  
                case 'address_0_place_id': 
                case 'address_0_journey_order': 

                case 'address_1_postal_town':                
                case 'address_1_route':                
                case 'address_1_street_number':                
                case 'address_1_postal_code':                  
                case 'address_1_place_id': 
                case 'address_1_journey_order': 

                case 'address_2_postal_town':                
                case 'address_2_route':                
                case 'address_2_street_number':                
                case 'address_2_postal_code': 
                case 'address_2_place_id': 
                case 'address_2_journey_order': 

                case 'delivery_time';
                case 'return_time';
                case 'return_distance';

                case 'action':
                case 'breakdown';
                case 'submit_type';

                    return false;
                    break;
                default:            
                    return true;
                    break;
            };
        return $params;
    }

    public function format_param_for_email($key,$test_value){
         if(strrpos($key, 'date')>-1){
            $test_value = $this->public->dbui->format_date($test_value);
        };
        if((strrpos($key, 'time')>-1)&&($key!='time')&&($key!='time_cost')&&(strrpos($key, 'time_type')==-1)){
            $test_value = $this->public->dbui->format_time($test_value);
        };
        return $test_value;
    }

}