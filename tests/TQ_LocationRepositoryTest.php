<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_LocationRepositoryTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

        $this->test_locations_1 = json_decode('',true);
        $this->test_journey_order_1 = json_decode('',true);

    }
    
    public function test_save(){
        $success = $this->journey_repository->save($this->test_locations_1, $this->test_journey_order_1);
        $this->assertTrue($success);
        $this->assertTrue(is_array($this->journey_repository->saved_locations_in_order));
        $this->assertCount(1 $this->journey_repository->saved_locations_in_order);        
    }    
  /*  public function test_create_record_data_journeys_locations(){
        $journeys_locations = $this->journey_repository->create_record_data_journeys_locations();
        $this->assertTrue(is_array($journeys_locations));
        $this->assertCount(2, $journeys_locations);        
    }    */
}    

?>