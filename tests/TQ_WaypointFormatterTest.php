<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_WaypointFormatterTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

        $this->example_waypoint_1 = json_decode('{"id":"5","address":"385 Dumbarton Road, Glasgow, UK","appartment_no":"2\/1","street_number":"385","postal_town":"Glasgow","route":"Dumbarton Road","administrative_area_level_2":"Glasgow City","administrative_area_level_1":"Scotland","country":"United Kingdom","postal_code":"G11 6BE","lat":"55.87069900000000000000","lng":"-4.30828000000000000000","place_id":"ChIJORdf39xFiEgRJAAllCRtufc","created":"2019-08-07 10:00:05","modified":"2019-08-07 10:00:05","contact_name":"Andrew","contact_phone":"123123123123"}', true);

        $this->example_waypoint_2 = json_decode('{"id":"6","address":"CeX, Union Street, Glasgow, UK","appartment_no":"","street_number":"28 - 40","postal_town":"Glasgow","route":"Union Street","administrative_area_level_2":"","administrative_area_level_1":"Scotland","country":"United Kingdom","postal_code":"G1 3QX","lat":"55.85886300000000000000","lng":"-4.25660400000000000000","place_id":"ChIJtd1djZ5GiEgRHQ0WFQ1lxd4","created":"2019-08-07 10:00:05","modified":"2019-08-07 10:00:05","contact_name":"","contact_phone":"93478534957"}', true);


        $this->expected_output_1 = json_decode('[{"name":"appartment_no","value":"2\/1","type":"text"},{"name":"street_number","value":"385","type":"text"},{"name":"postal_town","value":"Glasgow","type":"text"},{"name":"route","value":"Dumbarton Road","type":"text"},{"name":"administrative_area_level_2","value":"Glasgow City","type":"text"},{"name":"administrative_area_level_1","value":"Scotland","type":"text"},{"name":"country","value":"United Kingdom","type":"text"},{"name":"postal_code","value":"G11 6BE","type":"text"},{"name":"lat","value":"55.87069900000000000000","type":"number"},{"name":"lng","value":"-4.30828000000000000000","type":"number"},{"name":"contact_name","value":"Andrew","type":"text"},{"name":"contact_phone","value":"123123123123","type":"text"}]', true);

        $this->expected_output_2_not_empty = json_decode('[{"name":"street_number","value":"28 - 40","type":"text"},{"name":"postal_town","value":"Glasgow","type":"text"},{"name":"route","value":"Union Street","type":"text"},{"name":"administrative_area_level_1","value":"Scotland","type":"text"},{"name":"country","value":"United Kingdom","type":"text"},{"name":"postal_code","value":"G1 3QX","type":"text"},{"name":"lat","value":"55.85886300000000000000","type":"number"},{"name":"lng","value":"-4.25660400000000000000","type":"number"},{"name":"contact_phone","value":"93478534957","type":"text"}]', true);        
    }
   
    public function test_format() {

    	$formatter_config = array( 'waypoint'=>$this->example_waypoint_1,
								    'output_def'=>array('appartment_no',
                                                        'street_number',
                                                        'postal_town',
                                                        'route',
                                                        'administrative_area_level_2',
                                                        'administrative_area_level_1',
                                                        'country',
                                                        'postal_code',
                                                        'lat',
                                                        'lng',
                                                        'contact_name',
                                                        'contact_phone')
                                                    );

        $this->formatter = new TransitQuote_Pro4\TQ_WaypointFormatter($formatter_config);

        $output = $this->formatter->format();
        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(12, $output, ' not 12 elements');

        foreach ($output as $field) {
        	$this->assertArrayHasKey('name' ,$field);
        	$this->assertArrayHasKey('type' ,$field);
        	$this->assertArrayHasKey('value' ,$field);
        };

        $this->assertEquals($output, $this->expected_output_1);

    }

    public function test_format_not_empty_only() {

        $formatter_config = array( 'waypoint'=>$this->example_waypoint_2,
                                    'output_def'=>array('appartment_no',
                                                        'street_number',
                                                        'postal_town',
                                                        'route',
                                                        'administrative_area_level_2',
                                                        'administrative_area_level_1',
                                                        'country',
                                                        'postal_code',
                                                        'lat',
                                                        'lng',
                                                        'contact_name',
                                                        'contact_phone')
                                );

        $this->formatter = new TransitQuote_Pro4\TQ_WaypointFormatter($formatter_config);

        $output = $this->formatter->format_not_empty_only();

        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(9, $output, ' not 9 elements');

        foreach ($output as $field) {
            $this->assertArrayHasKey('name' ,$field);
            $this->assertArrayHasKey('type' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };

        $this->assertEquals($output, $this->expected_output_2_not_empty);

    }    
}
?>