<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TQ_LocationRepositoryTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

        $this->test_location_data_records = json_decode('[{"address":"125 London Wall, London, UK","appartment_no":"","street_number":"125","postal_town":"London","route":"London Wall","administrative_area_level_2":"Greater London","administrative_area_level_1":"England","country":"United Kingdom","postal_code":"EC2Y 5AJ","lat":"51.51757019999999","lng":"-0.09374779999996008","place_id":"ChIJKSv0f6ocdkgR8kEi1NgkK2w","created":"2019-10-21 13:17:39","modified":"2019-10-21 13:17:39"},{"address":"789 Dumbarton Road, Glasgow, UK","appartment_no":"","street_number":"789","postal_town":"Glasgow","route":"Dumbarton Road","administrative_area_level_2":"Glasgow City","administrative_area_level_1":"Scotland","country":"United Kingdom","postal_code":"G11 6NA","lat":"55.87193809999999","lng":"-4.327030100000002","place_id":"ChIJFQIi4-9FiEgR1CQQGZVRA50","created":"2019-10-21 13:17:39","modified":"2019-10-21 13:17:39"}]',true);

    }
   
    public function test_save_locations(){

        $this->cdb = TransitQuote_Pro4::get_custom_db();

        $repo_config = array('cdb' => $this->cdb, 'debugging' =>true);

        $this->location_repository = new TQ_LocationRepository($repo_config);           
        $saved_locations = $this->location_repository->save($this->test_location_data_records);
        $this->assertTrue(is_array($saved_locations));
        $this->assertTrue(is_array($this->location_repository->saved_locations_in_order));
        $this->assertCount(2, $this->location_repository->saved_locations_in_order); 
        $this->assertTrue(is_numeric($saved_locations[0]['id']),' id is not numeric');
        $this->assertTrue(is_numeric($saved_locations[1]['id']),' id is not numeric');
    }

}    

?>