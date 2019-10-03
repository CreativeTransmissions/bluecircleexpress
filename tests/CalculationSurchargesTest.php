<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class CalculationSurchargesTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->default_config = array('weight'=>20,
                                    'cost_per_weight_unit'=>10,
                                    'weight_unit_name'=>'lbs');

        $this->zero_config = array('weight'=>0,
                                    'cost_per_weight_unit'=>10,
                                    'weight_unit_name'=>'lbs');

        $this->null_config = array('weight'=>null,
                                    'cost_per_weight_unit'=>10,
                                    'weight_unit_name'=>'lbs');

        $this->junk_config = array('weight'=>'stuff',
                                    'cost_per_weight_unit'=>'nonsense',
                                    'weight_unit_name'=>null);
    }

    public function test_run(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationSurcharges($this->default_config);
        $surcharges = $calculator->run();

        $this->assertEquals(200, $surcharges['weight_cost']);
     
    }

    public function test_run_zero_weight(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationSurcharges($this->zero_config);
        $surcharges = $calculator->run();

        $this->assertEquals(0, $surcharges['weight_cost']);
     
    }    

    public function test_run_null_weight(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationSurcharges($this->null_config);
        $surcharges = $calculator->run();

        $this->assertEquals(0, $surcharges['weight_cost']);
     
    }

    public function test_run_junk_config(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationSurcharges($this->junk_config);
        $surcharges = $calculator->run();

        $this->assertFalse($surcharges);
     
    }    
}