<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_QuoteFormatterTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

		$this->currency = '£';
		$this->tax_name = 'VAT';

        $this->example_quote = json_decode('{"total":"1764.08","total_before_rounding":1764.08,"distance":"882.04","distance_cost_before_rounding":1764.08,"distance_cost":"1764.08","outward_distance":"882.04","return_distance":0,"outward_cost":1764.08,"return_cost":0,"basic_cost":"1764.08","stop_cost":0,"breakdown":[{"distance":"0.00","distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":882.04,"distance_cost":1764.08,"type":"per distance unit","rate":"2.00","cost":1764.08},{"distance":0,"distance_cost":1764.08,"type":"per distance unit","rate":"2.00","return_percentage":"100","cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":"0","tax_cost":0,"job_rate":"standard"}', true);
    }
   
    public function test_format() {

    	$formatter_config = array('quote'=>$this->example_quote,
    													'currency'=>'£',
    													'output_def'=>array('distance_cost'=> 'Distance Cost (' . $this->currency . ')',
    																		'rate_hour'=>'Hourly Rate (' . $this->currency . ')',
    																		'time_cost'=>'Time Cost (' . $this->currency . ')',
    																		'basic_cost'=>'Subtotal (' . $this->currency . ')',
    																		'rate_tax'=>'Tax Rate (%)',
    																		'tax_cost'=>$this->tax_name.' (' . $this->currency . ')',
    																		'total'=>'Total (' . $this->currency . ')',
    																		'job_rate'=>'Rates')
    																		);

        $this->formatter = new TransitQuote_Pro4\TQ_QuoteFormatter($formatter_config);

        $output = $this->formatter->format();

        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(8, $output, ' not 6 elements');

        foreach ($output as $field) {
        	$this->assertArrayHasKey('label' ,$field);
        	$this->assertArrayHasKey('name' ,$field);
        	$this->assertArrayHasKey('type' ,$field);
        	$this->assertArrayHasKey('value' ,$field);
        }

    }
}
?>