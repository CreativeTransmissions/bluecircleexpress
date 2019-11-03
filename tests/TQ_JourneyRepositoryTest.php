<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_JourneyRepositoryTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

		$this->journey_data_1_leg = json_decode('{"journey":{"distance":668.537,"duration":0,"deliver_and_return":0,"optimize_route":0},"legs":[{"distance":668.537,"time":7.011111111111111,"leg_order":0,"leg_type_id":2,"directions_response":"{\"distance\":{\"text\":\"669 km\",\"value\":668537},\"duration\":{\"text\":\"7 hours 1 min\",\"value\":25240},\"end_address\":\"789 Dumbarton Rd, Glasgow G11 6NA, UK\",\"end_location\":{\"lat\":55.8720377,\"lng\":-4.3269688000000315},\"start_address\":\"125 London Wall, 125 London Wall, Barbican, London, UK\",\"start_location\":{\"lat\":51.5175545,\"lng\":-0.09374769999999444},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}"}]}',true);


		$this->journey_data_2_leg = json_decode('{"journey":{"distance":336.168,"duration":0,"deliver_and_return":"1","optimize_route":0},"legs":[{"distance":167.949,"time":2.527222222222222,"leg_order":0,"leg_type_id":2,"directions_response":"{\"distance\":{\"text\":\"168 km\",\"value\":167949},\"duration\":{\"text\":\"2 hours 32 mins\",\"value\":9098},\"end_address\":\"19 High St, Inverness IV1 1HY, UK\",\"end_location\":{\"lat\":57.47761209999999,\"lng\":-4.2248508999999785},\"start_address\":\"79 Queen St, Aberdeen AB10 1AN, UK\",\"start_location\":{\"lat\":57.1499123,\"lng\":-2.0941688999999997},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}"},{"distance":168.219,"time":2.560277777777778,"leg_order":1,"leg_type_id":1,"directions_response":"{\"distance\":{\"text\":\"168 km\",\"value\":168219},\"duration\":{\"text\":\"2 hours 34 mins\",\"value\":9217},\"end_address\":\"79 Queen St, Aberdeen AB10 1AN, UK\",\"end_location\":{\"lat\":57.1499123,\"lng\":-2.0941688999999997},\"start_address\":\"19 High St, Inverness IV1 1HY, UK\",\"start_location\":{\"lat\":57.47761209999999,\"lng\":-4.2248508999999785},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}"}]}',true);

        $this->cdb = TransitQuote_Pro4::get_custom_db();
        $repo_config = array('cdb' => $this->cdb, 'debugging' =>true);
        $this->journey_repo = new TQ_JourneyRepository($repo_config);        
    
    }

    protected function tearDown(){
         $this->cdb  = null;
         $this->journey_repo = null;
    }
    
    public function test_save_journey(){
  		$this->cdb = TransitQuote_Pro4::get_custom_db();

        $repo_config = array('cdb' => $this->cdb, 'debugging' =>true);

        $this->journey_repo = new TQ_JourneyRepository($repo_config);           
        $journey = $this->journey_repo->save($this->journey_data_1_leg['journey']);
        $this->assertTrue(is_array($journey));
        $this->assertTrue(is_numeric($journey['id']));


    }

    public function test_create_leg_record(){
        $leg = json_decode('{"distance":668.537,"time":7.011111111111111,"leg_order":0,"leg_type_id":2,"directions_response":"{\"distance\":{\"text\":\"669 km\",\"value\":668537},\"duration\":{\"text\":\"7 hours 1 min\",\"value\":25240},\"end_address\":\"789 Dumbarton Rd, Glasgow G11 6NA, UK\",\"end_location\":{\"lat\":55.8720377,\"lng\":-4.3269688000000315},\"start_address\":\"125 London Wall, 125 London Wall, Barbican, London, UK\",\"start_location\":{\"lat\":51.5175545,\"lng\":-0.09374769999999444},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}"}', true);

        $this->journey_repo->current_stage = array('id'=>5);
        $leg_data = $this->journey_repo->create_leg_record(0, $leg); 
        $this->assertTrue(is_array($leg_data));
        $this->assertArrayHasKey('leg_type_id', $leg_data);
        $this->assertEquals(2,$leg_data['leg_type_id']);

    }

    public function test_save_journey_legs(){
      
        $this->journey = $this->journey_repo->save($this->journey_data_1_leg['journey']);
        $this->journey_repo->save_journey_legs($this->journey['id'], $this->journey_data_1_leg['legs']);
        $this->assertTrue(is_array($this->journey_repo->stage_recs));
        $this->assertTrue(is_array($this->journey_repo->leg_recs));

        $this->assertCount(1, $this->journey_repo->stage_recs);
        $this->assertCount(1, $this->journey_repo->leg_recs);

    }

    public function test_save_journey_2_legs(){
         
        $this->journey = $this->journey_repo->save($this->journey_data_2_leg['journey']);
        $this->journey_repo->save_journey_legs($this->journey['id'], $this->journey_data_2_leg['legs']);
        $this->assertTrue(is_array($this->journey_repo->stage_recs));
        $this->assertTrue(is_array($this->journey_repo->leg_recs));

        $this->assertCount(2, $this->journey_repo->stage_recs);
        $this->assertCount(2, $this->journey_repo->leg_recs);

    }    

    public function test_save_journeys_locations(){
        $journeys_locations_data= json_decode('[{"location_id":"79","journey_order":0,"created":"2019-11-03 16:25:52","modified":"2019-11-03 16:25:52"},{"location_id":"80","journey_order":1,"created":"2019-11-03 16:25:52","modified":"2019-11-03 16:25:52"}]', true);
        $saved_journeys_locations = $this->journey_repo->save_journeys_locations(999, $journeys_locations_data);        
        $this->assertTrue(is_array($saved_journeys_locations));
        $this->assertCount(2, $saved_journeys_locations);
        $this->assertArrayHasKey('id', $saved_journeys_locations[0]);
        $this->assertArrayHasKey('id', $saved_journeys_locations[1]);


    }
}    

?>