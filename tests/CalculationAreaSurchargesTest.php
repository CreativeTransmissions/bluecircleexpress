<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class CalculationAreaSurchargesTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->default_config = json_decode('{"surcharge_ids":["2","1"],"area_surcharges":{"2":{"id":"5","name":"Outer Area","definition":"c`mwFvumlMcdVkr_H|vgBv`bAkb`@pxiH","surcharge_name":"Parking","amount":"20.00","surcharge_id":"2"},"1":{"id":"4","name":"Test2","definition":"wc|vF~gqiMemAezcB|jSzjV","surcharge_name":"Congestion Charge","amount":"12.00","surcharge_id":"1"}}}',true);

        $this->zero_config = json_decode('{"surcharge_ids":[],"area_surcharges":{}}',true);

        $this->null_config = json_decode('{"surcharge_ids":null,"area_surcharges":null}',true);


        $this->junk_config = array('weight'=>'stuff',
                                    'cost_per_weight_unit'=>'nonsense',
                                    'weight_unit_name'=>null);
    }

    public function test_run(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationAreaSurcharges($this->default_config);
        $surcharges = $calculator->run();
        $this->assertTrue(is_array($surcharges));

        $this->assertArrayHasKey('parking', $surcharges);
        $this->assertEquals(20, $surcharges['parking']);
        $this->assertEquals(12, $surcharges['congestion_charge']);
        $this->assertEquals(32, $surcharges['area_surcharges_total']);

    }

    public function test_get_surcharge_for_id(){
        $calculator = new TransitQuote_Pro4\TQ_CalculationAreaSurcharges($this->default_config);
        $surcharge = $calculator->get_surcharge_for_id(1);
        $this->assertTrue(is_array($surcharge));

        $surcharge = $calculator->get_surcharge_for_id('1');
        $this->assertTrue(is_array($surcharge));        
    }

    public function test_run_zero(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationAreaSurcharges($this->zero_config);
        $surcharges = $calculator->run();
        $this->assertTrue(is_array($surcharges));

        $this->assertCount(1, $surcharges);
        $this->assertEquals(0, $surcharges['area_surcharges_total']);
     
    }    

    public function test_run_null(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationAreaSurcharges($this->null_config);
        $surcharges = $calculator->run();
        $this->assertFalse($surcharges);
     
    }

    public function test_run_junk_config(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationAreaSurcharges($this->junk_config);
        $surcharges = $calculator->run();

        $this->assertCount(1, $surcharges);
        $this->assertEquals(0, $surcharges['area_surcharges_total']);
     
    }    
}