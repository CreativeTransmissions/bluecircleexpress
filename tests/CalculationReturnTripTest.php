<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_CalculationReturnTripTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp();
        $this->default_config = array('distance'=>0,
                                    'return_distance'=>0,
                                    'return_percentage'=>100,
                                    'return_time'=>0,
                                    'time_mins'=>0,
                                    'rates'=>array(),
                                    'include_return_journey'=>false,
                                    'boundary_mode'=>'final',
                                    'rouunding_type'=>'Round to 2 decimal points',
                                    'tax_name'=>'',
                                    'tax_rate'=>0);

        $this->test_config = json_decode('{"debugging":true,"rates":[{"id":"69","service_id":"1","vehicle_id":"2","distance":"5.00","amount":"19.00","unit":"0.00","hour":"0.00"},{"id":"81","service_id":"1","vehicle_id":"2","distance":"0.00","amount":"10.00","unit":"0.85","hour":"0.00"}],"distance":"93.64","return_percentage":"50","hours":0,"return_distance":"46.87","return_time":"1.12","tax_rate":"20","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $this->test_config_no_percentage = json_decode('{"debugging":true,"rates":[{"id":"69","service_id":"1","vehicle_id":"2","distance":"5.00","amount":"19.00","unit":"0.00","hour":"0.00"},{"id":"81","service_id":"1","vehicle_id":"2","distance":"0.00","amount":"10.00","unit":"0.85","hour":"0.00"}],"distance":"93.64","return_percentage":"100","hours":0,"return_distance":"46.87","return_time":"1.12","tax_rate":"20","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);        

    }
   

    public function test_init_calculation() {
        $calculator = new TransitQuote_Pro4\TQ_CalculationReturnTrip($this->test_config);
        $calculator->init_calculation();
        $this->assertContains('rates', $calculator->config, 'test_calculation_50_percent error: config has no rates element');
        $this->assertContains('tax_name', $calculator->config, 'test_calculation_50_percent error: config tax_name not merged');        
        $this->assertContains('return_percentage', $calculator->config, 'test_calculation_50_percent error: return_percentage not merged');
        $this->assertEquals(50, $calculator->config['return_percentage'], 'test_calculation_50_percent error: return_percentage correct');              
    }

    public function test_calculation_50_percent() {
        $calculator = new TransitQuote_Pro4\TQ_CalculationReturnTrip($this->test_config);
        $calculator->init_calculation();
        $quote = $calculator->run();

        $this->assertContains('total', $quote, 'test_calculation_50_percent error: quote has no total element');
        $this->assertContains('total_before_rounding', $quote, 'test_calculation_50_percent error: quote has no total_before_rounding element');
        $this->assertContains('distance', $quote, 'test_calculation_50_percent error: quote has no distance element');
        $this->assertContains('distance_cost_before_rounding', $quote, 'test_calculation_50_percent error: quote has no distance_cost_before_rounding element');
        $this->assertContains('distance_cost', $quote, 'test_calculation_50_percent error: quote has no distance_cost element');
        $this->assertContains('outward_distance', $quote, 'test_calculation_50_percent error: quote has no total outward_distance');
        $this->assertContains('return_distance', $quote, 'test_calculation_50_percent error: quote has no return_distance element');
        $this->assertContains('outward_cost', $quote, 'test_calculation_50_percent error: quote has no outward_cost element');
        $this->assertContains('return_cost', $quote, 'test_calculation_50_percent error: quote has no return_cost element');
        $this->assertContains('basic_cost', $quote, 'test_calculation_50_percent error: quote has no basic_cost element');
        $this->assertContains('stop_cost', $quote, 'test_calculation_50_percent error: quote has no stop_cost element');
        $this->assertContains('breakdown', $quote, 'test_calculation_50_percent error: quote has no breakdown element');
        $this->assertContains('rate_hour', $quote, 'test_calculation_50_percent error: quote has no rate_hour element');
        $this->assertContains('time_cost', $quote, 'test_calculation_50_percent error: quote has no time_cost element');
        $this->assertContains('rate_hour', $quote, 'test_calculation_50_percent error: quote has no rate_hour element');
        $this->assertContains('rate_tax', $quote, 'test_calculation_50_percent error: quote has no rate_tax element');
        $this->assertContains('tax_cost', $quote, 'test_calculation_50_percent error: quote has no tax_cost element');
        $this->assertContains('job_rate', $quote, 'test_calculation_50_percent error: quote has no job_rate element');

        $this->assertEquals(83.60, $quote['total'], 'test_calculation_50_percent error: total is wrong value');               
        $this->assertEquals(83.60425000000001, $quote['total_before_rounding'], 'test_calculation_50_percent error: total_before_rounding is wrong value'); 
        $this->assertEquals(93.64, $quote['distance'], 'test_calculation_50_percent error: distance is wrong value'); 
        $this->assertEquals(69.67425, $quote['distance_cost_before_rounding'], 'test_calculation_50_percent error: distance_cost_before_rounding is wrong value'); 
        $this->assertEquals(69.67, $quote['distance_cost'], 'test_calculation_50_percent error: distance_cost is wrong value'); 
        $this->assertEquals(46.77, $quote['outward_distance'], 'test_calculation_50_percent error: outward_distance is wrong value'); 
        $this->assertEquals(46.87, $quote['return_distance'], 'test_calculation_50_percent error: return_distance is wrong value'); 
        $this->assertEquals(49.7545, $quote['outward_cost'], 'test_calculation_50_percent error: outward_cost is wrong value'); 
        $this->assertEquals(19.919749999999997, $quote['return_cost'], 'test_calculation_50_percent error: return_cost is wrong value'); 
        $this->assertEquals(69.67, $quote['basic_cost'], 'test_calculation_50_percent error: basic_cost is wrong value'); 
        $this->assertEquals(0, $quote['stop_cost'], 'test_calculation_50_percent error: stop_cost is wrong value'); 
        $this->assertTrue(is_array($quote['breakdown']), 'test_calculation_50_percent error: breakdown is not an array');     
        $this->assertEquals(0, $quote['rate_hour'], 'test_calculation_50_percent error: rate_hour is wrong value');     
        $this->assertEquals(0, $quote['time_cost'], 'test_calculation_50_percent error: time_cost is wrong value');     
        $this->assertEquals(20, $quote['rate_tax'], 'test_calculation_50_percent error: rate_tax is wrong value');     

        $this->assertEquals(20, $quote['rate_tax'], 'test_calculation_50_percent error: rate_tax is wrong value');     
        $this->assertEquals(13.93, $quote['tax_cost'], 'test_calculation_50_percent error: tax_cost is wrong value');  
        print_r($quote);
   //     $this->assertEquals('standard', $quote['job_rate'], 'test_calculation_50_percent error: job_rate is wrong value');     


    }    

    public function test_calculation_no_percentage() {
        $calculator = new TransitQuote_Pro4\TQ_CalculationReturnTrip($this->test_config_no_percentage);
        $calculator->init_calculation();
        $quote = $calculator->run();

        $this->assertContains('total', $quote, 'test_calculation_50_percent error: quote has no total element');
        $this->assertContains('total_before_rounding', $quote, 'test_calculation_50_percent error: quote has no total_before_rounding element');
        $this->assertContains('distance', $quote, 'test_calculation_50_percent error: quote has no distance element');
        $this->assertContains('distance_cost_before_rounding', $quote, 'test_calculation_50_percent error: quote has no distance_cost_before_rounding element');
        $this->assertContains('distance_cost', $quote, 'test_calculation_50_percent error: quote has no distance_cost element');
        $this->assertContains('outward_distance', $quote, 'test_calculation_50_percent error: quote has no total outward_distance');
        $this->assertContains('return_distance', $quote, 'test_calculation_50_percent error: quote has no return_distance element');
        $this->assertContains('outward_cost', $quote, 'test_calculation_50_percent error: quote has no outward_cost element');
        $this->assertContains('return_cost', $quote, 'test_calculation_50_percent error: quote has no return_cost element');
        $this->assertContains('basic_cost', $quote, 'test_calculation_50_percent error: quote has no basic_cost element');
        $this->assertContains('stop_cost', $quote, 'test_calculation_50_percent error: quote has no stop_cost element');
        $this->assertContains('breakdown', $quote, 'test_calculation_50_percent error: quote has no breakdown element');
        $this->assertContains('rate_hour', $quote, 'test_calculation_50_percent error: quote has no rate_hour element');
        $this->assertContains('time_cost', $quote, 'test_calculation_50_percent error: quote has no time_cost element');
        $this->assertContains('rate_hour', $quote, 'test_calculation_50_percent error: quote has no rate_hour element');
        $this->assertContains('rate_tax', $quote, 'test_calculation_50_percent error: quote has no rate_tax element');
        $this->assertContains('tax_cost', $quote, 'test_calculation_50_percent error: quote has no tax_cost element');
        $this->assertContains('job_rate', $quote, 'test_calculation_50_percent error: quote has no job_rate element');

        $this->assertEquals(107.51, $quote['total'], 'test_calculation_50_percent error: total is wrong value');               
        $this->assertEquals(107.514, $quote['total_before_rounding'], 'test_calculation_50_percent error: total_before_rounding is wrong value'); 
        $this->assertEquals(93.64, $quote['distance'], 'test_calculation_50_percent error: distance is wrong value'); 
        $this->assertEquals(89.594, $quote['distance_cost_before_rounding'], 'test_calculation_50_percent error: distance_cost_before_rounding is wrong value'); 
        $this->assertEquals(89.59, $quote['distance_cost'], 'test_calculation_50_percent error: distance_cost is wrong value'); 
        $this->assertEquals(46.77, $quote['outward_distance'], 'test_calculation_50_percent error: outward_distance is wrong value'); 
        $this->assertEquals(46.87, $quote['return_distance'], 'test_calculation_50_percent error: return_distance is wrong value');/* 
        $this->assertEquals(49.7545, $quote['outward_cost'], 'test_calculation_50_percent error: outward_cost is wrong value'); 
        $this->assertEquals(19.919749999999997, $quote['return_cost'], 'test_calculation_50_percent error: return_cost is wrong value'); */
        $this->assertEquals(89.59, $quote['basic_cost'], 'test_calculation_50_percent error: basic_cost is wrong value'); 
        $this->assertEquals(0, $quote['stop_cost'], 'test_calculation_50_percent error: stop_cost is wrong value'); 
        $this->assertTrue(is_array($quote['breakdown']), 'test_calculation_50_percent error: breakdown is not an array');     
        $this->assertEquals(0, $quote['rate_hour'], 'test_calculation_50_percent error: rate_hour is wrong value');     
        $this->assertEquals(0, $quote['time_cost'], 'test_calculation_50_percent error: time_cost is wrong value');     
        $this->assertEquals(20, $quote['rate_tax'], 'test_calculation_50_percent error: rate_tax is wrong value');     
        $this->assertEquals(17.92, $quote['tax_cost'], 'test_calculation_50_percent error: tax_cost is wrong value');  
        /*print_r($quote);
   //     $this->assertEquals('standard', $quote['job_rate'], 'test_calculation_50_percent error: job_rate is wrong value');     */


    }  
}