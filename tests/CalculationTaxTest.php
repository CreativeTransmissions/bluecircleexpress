<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_CalculationTaxTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->default_config = array('tax_rate'=>20,
                                    'tax_name'=>'VAT',
                                    'subtotal'=>300);

        $this->zero_config = array('tax_rate'=>0,
                                    'tax_name'=>'VAT',
                                    'subtotal'=>0);

        $this->null_config = array('tax_rate'=>null,
                                    'tax_name'=>null,
                                    'subtotal'=>null);

        $this->junk_config = array('tax_rate'=>'stuff',
                                    'tax_name'=>null,
                                    'subtotal'=>'nonsense');
    }

    public function test_run(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationTax($this->default_config);
        $taxes = $calculator->run();

        $this->assertEquals(300, $taxes['subtotal']);
        $this->assertEquals(60, $taxes['tax_cost']);
        $this->assertEquals(360, $taxes['total']);
        $this->assertEquals('VAT', $taxes['tax_name']);         
    }

    public function test_run_zero_cost(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationTax($this->zero_config);
        $taxes = $calculator->run();

        $this->assertEquals(0, $taxes['subtotal']);
        $this->assertEquals(0, $taxes['tax_cost']);
        $this->assertEquals(0, $taxes['total']);
        $this->assertEquals('VAT', $taxes['tax_name']);     ;
     
    }    

    public function test_run_null_cost(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationTax($this->null_config);
        $taxes = $calculator->run();

        $this->assertEquals(0, $taxes['subtotal']);
        $this->assertEquals(0, $taxes['tax_cost']);
        $this->assertEquals(0, $taxes['total']);
        $this->assertEquals('', $taxes['tax_name']);   
     
    }

    public function test_run_junk_config(){

        $calculator = new TransitQuote_Pro4\TQ_CalculationTax($this->junk_config);
        $taxes = $calculator->run();

        $this->assertFalse($taxes);
     
    } 

    
}