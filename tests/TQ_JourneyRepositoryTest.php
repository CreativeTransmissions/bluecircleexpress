<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_JourneyRepositoryTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

    
    }
    
    public function test_create_record_data_journeys_locations(){
        $journeys_locations = $this->journey_repository->create_record_data_journeys_locations();
        $this->assertTrue(is_array($journeys_locations));
        $this->assertCount(2, $journeys_locations);        
    }    
}    

?>