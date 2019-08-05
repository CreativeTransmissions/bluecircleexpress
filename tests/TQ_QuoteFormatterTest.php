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

        $this->expected_output = json_decode('[{"label":"Distance Cost","name":"distance_cost","value":"1764.08","type":"number"},{"label":"Hourly Rate (GBP)","name":"rate_hour","value":"0.00","type":"text"},{"label":"Time Cost (GBP)","name":"time_cost","value":"0","type":"text"},{"label":"Subtotal (GBP)","name":"basic_cost","value":"1764.08","type":"number"},{"label":"VAT Rate (%)","name":"rate_tax","value":"0","type":"text"},{"label":"VAT (GBP)","name":"tax_cost","value":"0","type":"text"},{"label":"Total (GBP)","name":"total","value":"1764.08","type":"number"},{"label":"Rates","name":"job_rate","value":"Standard","type":"text"}]', true);
    }
   
    public function test_format() {

        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.3.2');
        $label_fetcher = new TransitQuote_Pro4\TQ_LabelFetcher(array('public' => $public));
        $labels = $label_fetcher->fetch_labels_for_view('dashboard');

    	$formatter_config = array( 'quote'=>$this->example_quote,
                                   'labels'=>$labels,
								    'currency'=>'£',
								    'output_def'=>array('distance_cost',
													'rate_hour',
													'time_cost',
													'basic_cost',
													'rate_tax',
													'tax_cost',
													'total',
													'job_rate'));

        $this->formatter = new TransitQuote_Pro4\TQ_QuoteFormatter($formatter_config);

        $output = $this->formatter->format();

        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(8, $output, ' not 6 elements');

        foreach ($output as $field) {
        	$this->assertArrayHasKey('label' ,$field);
        	$this->assertArrayHasKey('name' ,$field);
        	$this->assertArrayHasKey('type' ,$field);
        	$this->assertArrayHasKey('value' ,$field);
        };

        $this->assertEquals($output, $this->expected_output);

    }
}
?>