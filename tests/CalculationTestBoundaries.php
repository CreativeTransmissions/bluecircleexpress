<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class CalculationTestRates extends TestCase
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

        $this->test_rates = array();

    }

    public function test_calculation_1(){
        $test_config = json_decode('{"debugging":false,"rates":[{"id":"6","service_id":"1","vehicle_id":"1","distance":"55.00","amount":"58.00","unit":"0.00","hour":"0.00"},{"id":"7","service_id":"1","vehicle_id":"1","distance":"0.00","amount":"0.00","unit":"1.05","hour":"0.00"}],"distance":"129.87","return_percentage":"100","hours":0,"return_distance":0,"return_time":0,"tax_rate":"0","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals(true, is_array($quote), 'quote result not an array');

        $this->assertEquals($quote['distance'],$quote['outward_distance']+$quote['return_distance'], 'distance = outward_distance('.$quote['outward_distance'].') + return_distance('.$quote['return_distance'].')');


        $this->assertEquals($calculator->set_amount, 47, ' set amount is correct');  

         
        $this->assertEquals($calculator->basic_cost, 47, ' basic cost is correct');  

        $this->assertEquals($quote['total'], 56.87, ' total_cost correct');

        $this->assertNotEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate is not final rate we are within distance boundary');                
    }



    
}