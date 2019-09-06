<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class CalculationTestBoundaries extends TestCase
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
        $test_config = json_decode('{"debugging":false,"rates":[{"id":"7","service_id":"1","vehicle_id":"1","distance":"0.00","amount":"0.00","unit":"1.05","hour":"0.00"},{"id":"6","service_id":"1","vehicle_id":"1","distance":"55.00","amount":"58.00","unit":"0.00","hour":"0.00"}],"distance":"69.82","return_percentage":"100","hours":0,"return_distance":0,"return_time":0,"tax_rate":"0","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals(true, is_array($quote), 'quote result not an array');

        $this->assertEquals($quote['distance'],$quote['outward_distance']+$quote['return_distance'], 'distance = outward_distance('.$quote['outward_distance'].') + return_distance('.$quote['return_distance'].')');
         
        $this->assertEquals(69.82, $calculator->distance);
        $this->assertEquals(0, $calculator->max_distance_rate['distance'], ' max distance has incorrect rate.');
        $this->assertEquals(7, $calculator->final_rate['id'], ' final_rate is not correct for distance .');

        $this->assertEquals(1.05, $calculator->final_rate['unit'], ' final_rate is not correct for distance .');

        $this->assertEquals(73.31099999999999, $calculator->distance_cost, ' distance cost is incorrect');          

        $this->assertEquals(73.31099999999999, $calculator->basic_cost, ' basic cost is incorrect');  

        $this->assertEquals(73.31, $quote['total'],  ' total_cost correct');

        $this->assertEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate is final rate');                
    }

    public function test_calculation_2(){
        $test_config = json_decode('{"debugging":false,"rates":[{"id":"6","service_id":"1","vehicle_id":"1","distance":"55.00","amount":"58.00","unit":"0.00","hour":"0.00"},{"id":"7","service_id":"1","vehicle_id":"1","distance":"0.00","amount":"0.00","unit":"1.05","hour":"0.00"}],"distance":"69.82","return_percentage":"100","hours":0,"return_distance":0,"return_time":0,"tax_rate":"0","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals(true, is_array($quote), 'quote result not an array');

        $this->assertEquals($quote['distance'],$quote['outward_distance']+$quote['return_distance'], 'distance = outward_distance('.$quote['outward_distance'].') + return_distance('.$quote['return_distance'].')');
         
        $this->assertEquals(69.82, $calculator->distance);
        $this->assertEquals(0, $calculator->max_distance_rate['distance'], ' max distance has incorrect rate.');
        $this->assertEquals(7, $calculator->final_rate['id'], ' final_rate is not correct for distance .');

        $this->assertEquals(1.05, $calculator->final_rate['unit'], ' final_rate is not correct for distance .');

        $this->assertEquals(73.31099999999999, $calculator->distance_cost, ' distance cost is incorrect');          

        $this->assertEquals(73.31099999999999, $calculator->basic_cost, ' basic cost is incorrect');  

        $this->assertEquals(73.31, $quote['total'],  ' total_cost correct');

        $this->assertEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate is final rate');                
    }

    
}