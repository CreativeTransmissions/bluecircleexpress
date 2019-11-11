<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_QuoteRepositoryTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

		$this->test_quote_with_area_surcharge = json_decode('{"total":"219.95","total_before_rounding":207.9515,"distance":"88.49","distance_cost_before_rounding":207.9515,"distance_cost":"207.95","outward_distance":"88.49","return_distance":0,"outward_cost":207.9515,"return_cost":0,"basic_cost":219.95,"stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":88.49,"distance_cost":207.9515,"type":"per distance unit","rate":"2.35","cost":207.9515},{"distance":0,"distance_cost":207.9515,"type":"per distance unit","rate":"2.35","return_percentage":"100","cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":"0","tax_cost":"0.00","job_rate":"standard","weight_cost":0,"congestion_charge":"12.00","area_surcharges_cost":12,"tax_name":"","tax_rate":"0","subtotal":"219.95","total_cost":219.95}',true);

        $this->test_surcharge_area_data = json_decode('[{"surcharge_id":"1","amount":"12.00"}]', true);

        $this->multi_stage_quote_response = json_decode('{"quote":{"total":"682.72","total_before_rounding":682.722,"distance":"290.52","distance_cost_before_rounding":682.722,"distance_cost":"682.72","outward_distance":"290.52","return_distance":0,"outward_cost":682.722,"return_cost":0,"basic_cost":682.72,"stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":290.52,"distance_cost":682.722,"type":"per distance unit","rate":"2.35","cost":682.722},{"distance":0,"distance_cost":682.722,"type":"per distance unit","rate":"2.35","return_percentage":"100","cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":"0","tax_cost":"0.00","job_rate":"standard","weight_cost":0,"area_surcharges_cost":0,"tax_name":"","tax_rate":"0","subtotal":"682.72","total_cost":682.72},"journey":{"distance":467.448,"duration":0,"deliver_and_return":0,"optimize_route":0,"id":256},"rates":null,"rate_options":{"holiday_dates":[],"use_out_of_hours_rates":false,"use_weekend_rates":false,"use_holiday_rates":false,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","weight_unit_name":"lbs","cost_per_weight_unit":"0","ask_for_weight":false,"tax_name":"","tax_rate":"0","leg_type":"standard","date_list":["30-10-2019"],"time_list":["12:00"],"delivery_date":"30-10-2019","delivery_time":"12:00","vehicle_id":"1","service_id":"1","distance":"290.52","return_time":0,"deliver_and_return":0,"return_distance":0,"no_destinations":1,"hours":0,"weight":0,"surcharge_ids":[""]},"html":"<table><tr><th>Item<\/th><th>Price<\/th><tr><tr><td>Weight Cost<\/td><td>0<\/td><tr><tr><td>Area Surcharge<\/td><td>0<\/td><tr><tr><td>Subtotal<\/td><td>682.72<\/td><tr><tr><td>Tax Rate<\/td><td>0<\/td><tr><tr><td>Tax Cost<\/td><td>0.00<\/td><tr><tr><td>Total<\/td><td>682.72<\/td><tr>"}',true);


        $this->multi_stage_quote = json_decode('{"total":"682.72","total_before_rounding":682.722,"distance":"290.52","distance_cost_before_rounding":682.722,"distance_cost":"682.72","outward_distance":"290.52","return_distance":0,"outward_cost":682.722,"return_cost":0,"basic_cost":682.72,"stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":290.52,"distance_cost":682.722,"type":"per distance unit","rate":"2.35","cost":682.722},{"distance":0,"distance_cost":682.722,"type":"per distance unit","rate":"2.35","return_percentage":"100","cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":"0","tax_cost":"0.00","job_rate":"standard","weight_cost":0,"area_surcharges_cost":0,"tax_name":"","tax_rate":"0","subtotal":"682.72","total_cost":682.72}',true);


        $this->quote_data_2_dispatch_and_standard = json_decode('{"basic_cost":2835.7200000000003,"tax_cost":"567.14","total":"3402.86","distance_cost":2835.7200000000003,"time_cost":0,"weight_cost":0,"area_surcharges_cost":0,"tax_name":"","tax_rate":"20","subtotal":"2835.72","total_cost":3402.8599999999997,"id":4}', true);

        $this->stage_data_2_dispatch_and_standard = json_decode('[{"journey_id":8,"stage_order":0,"id":1,"distance":927.9173399627098,"hours":13.856388888888889,"leg_type":"dispatch","quote":{"total":"603.15","total_before_rounding":603.1462709757614,"distance":927.9173399627098,"distance_cost_before_rounding":603.1462709757614,"distance_cost":"603.15","outward_distance":927.9173399627098,"return_distance":0,"outward_cost":603.1462709757614,"return_cost":0,"basic_cost":"603.15","stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":927.9173399627098,"distance_cost":603.1462709757614,"type":"per distance unit","rate":"0.65","cost":603.1462709757614},{"distance":0,"distance_cost":603.1462709757614,"type":"per distance unit","rate":"0.65","return_percentage":100,"cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":0,"tax_cost":0}},{"journey_id":8,"stage_order":1,"id":2,"distance":950.0298321939092,"hours":14.360277777777778,"leg_type":"standard","quote":{"total":"2232.57","total_before_rounding":2232.570105655687,"distance":950.0298321939092,"distance_cost_before_rounding":2232.570105655687,"distance_cost":"2232.57","outward_distance":950.0298321939092,"return_distance":0,"outward_cost":2232.570105655687,"return_cost":0,"basic_cost":"2232.57","stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":950.0298321939092,"distance_cost":2232.570105655687,"type":"per distance unit","rate":"2.35","cost":2232.570105655687},{"distance":0,"distance_cost":2232.570105655687,"type":"per distance unit","rate":"2.35","return_percentage":100,"cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":0,"tax_cost":0}}]', true);

        $this->example_stage_data_rec_dispatch_stage = json_decode('{"journey_id":8,"stage_order":0,"id":1,"distance":927.9173399627098,"hours":13.856388888888889,"leg_type":"dispatch","quote":{"total":"603.15","total_before_rounding":603.1462709757614,"distance":927.9173399627098,"distance_cost_before_rounding":603.1462709757614,"distance_cost":"603.15","outward_distance":927.9173399627098,"return_distance":0,"outward_cost":603.1462709757614,"return_cost":0,"basic_cost":"603.15","stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":927.9173399627098,"distance_cost":603.1462709757614,"type":"per distance unit","rate":"0.65","cost":603.1462709757614},{"distance":0,"distance_cost":603.1462709757614,"type":"per distance unit","rate":"0.65","return_percentage":100,"cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":0,"tax_cost":0}}, true');

        $this->example_stage_data_rec_standared_stage = json_decode('{"journey_id":8,"stage_order":1,"id":2,"distance":950.0298321939092,"hours":14.360277777777778,"leg_type":"standard","quote":{"total":"2232.57","total_before_rounding":2232.570105655687,"distance":950.0298321939092,"distance_cost_before_rounding":2232.570105655687,"distance_cost":"2232.57","outward_distance":950.0298321939092,"return_distance":0,"outward_cost":2232.570105655687,"return_cost":0,"basic_cost":"2232.57","stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":950.0298321939092,"distance_cost":2232.570105655687,"type":"per distance unit","rate":"2.35","cost":2232.570105655687},{"distance":0,"distance_cost":2232.570105655687,"type":"per distance unit","rate":"2.35","return_percentage":100,"cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":0,"tax_cost":0}}, true');

        $this->cdb = TransitQuote_Pro4::get_custom_db();
        $repo_config = array('cdb' => $this->cdb, 'debugging' =>true);
        $this->quote_repo = new TQ_QuoteRepository($repo_config);        
    
    }

    protected function tearDown(){
         $this->cdb  = null;
         $this->quote_repo = null;
    }
    
    public function test_save_quote(){

        $quote = $this->quote_repo->save($this->test_quote_with_area_surcharge);
        $this->assertTrue(is_array($quote));
        $this->assertTrue(is_numeric($quote['id']));
        $this->assertTrue(!empty($quote['id']), ' saved quote id empty');

        $quote_surcharge_ids = $this->quote_repo->save_quote_surcharges($this->test_surcharge_area_data);
        $this->assertTrue(is_array($quote_surcharge_ids));
        $this->assertTrue(is_numeric($quote_surcharge_ids[0]));
         
    }

    public function test_save_quote_stage_data_2_dispatch_and_standard(){

        $quote = $this->quote_repo->save($this->quote_data_2_dispatch_and_standard);
        $this->assertTrue(is_array($quote));
        $this->assertTrue(is_numeric($quote['id']));
        $this->assertTrue(!empty($quote['id']), ' saved quote id empty');

        $quote_surcharge_ids = $this->quote_repo->save_quote_surcharges($this->test_surcharge_area_data);
        $this->assertTrue(is_array($quote_surcharge_ids));
        $this->assertTrue(is_numeric($quote_surcharge_ids[0]));

        $quote_stage_ids = $this->quote_repo->save_quote_stages($this->stage_data_2_dispatch_and_standard);
        $this->assertTrue(is_array($quote_stage_ids));
        $this->assertTrue(is_numeric($quote_stage_ids[0]));
        $this->assertTrue(is_numeric($quote_stage_ids[1]));
         
    }

}    

?>