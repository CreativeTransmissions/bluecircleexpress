<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_QuoteFormatterTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

		$this->currency = '£';
		$this->tax_name = 'VAT';

        $this->example_quote = json_decode('{"total":"1764.08","total_before_rounding":1764.08,"distance":"882.04","distance_cost_before_rounding":1764.08,"distance_cost":"1764.08","outward_distance":"882.04","return_distance":0,"outward_cost":1764.08,"return_cost":0,"basic_cost":"1764.08","stop_cost":0,"breakdown":[{"distance":"0.00","distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":882.04,"distance_cost":1764.08,"type":"per distance unit","rate":"2.00","cost":1764.08},{"distance":0,"distance_cost":1764.08,"type":"per distance unit","rate":"2.00","return_percentage":"100","cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":"0","tax_cost":0,"rates":"standard"}', true);

        $this->expected_output = json_decode('[{"label":"Distance Cost","name":"distance_cost","value":"1764.08","type":"number"},{"label":"Hourly Rate (GBP)","name":"rate_hour","value":"0.00","type":"text"},{"label":"Time Cost (GBP)","name":"time_cost","value":"0","type":"text"},{"label":"Subtotal (GBP)","name":"basic_cost","value":"1764.08","type":"number"},{"label":"VAT Rate (%)","name":"rate_tax","value":"0","type":"text"},{"label":"VAT (GBP)","name":"tax_cost","value":"0","type":"text"},{"label":"Total (GBP)","name":"total","value":"1764.08","type":"number"},{"label":"Rates","name":"rates","value":"Standard","type":"text"}]', true);

        $this->expected_output_non_zero = json_decode('[{"label":"Distance Cost","name":"distance_cost","value":"1764.08","type":"number"},{"label":"Subtotal (GBP)","name":"basic_cost","value":"1764.08","type":"number"},{"label":"Total (GBP)","name":"total","value":"1764.08","type":"number"},{"label":"Rates","name":"rates","value":"Standard","type":"text"}]', true);        

        $this->quote_with_stages_and_surcharges = json_decode('{"id":"67","total":"75.26","rate_unit":"0.00","rate_hour":"0.00","rate_tax":"0.00","basic_cost":"62.72","distance_cost":"50.72","time_cost":"0.00","notice_cost":"0.00","tax_cost":"12.54","breakdown":"","rates":"","created":"0000-00-00 00:00:00","modified":"0000-00-00 00:00:00","stages":[{"quote_id":"67","journey_id":"92","stage_order":"0","stage_id":"112","unit_cost":"28.24","time_cost":"0.00","set_cost":"0.00","stage_total":"28.24","rates":"2"},{"quote_id":"67","journey_id":"92","stage_order":"1","stage_id":"113","unit_cost":"22.48","time_cost":"0.00","set_cost":"0.00","stage_total":"22.48","rates":"1"}],"surcharges":[{"quote_id":"67","name":"Congestion Charge","surcharge_id":"1","amount":"12"},{"quote_id":"67","name":"Weight","surcharge_id":"3","amount":"0"}]}', true);
    }
   
  /*  public function test_format() {

        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.4');
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
													'rates'));

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

    public function test_format_non_zero_only() {

        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.4');
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
                                                    'rates'));

        $this->formatter = new TransitQuote_Pro4\TQ_QuoteFormatter($formatter_config);

        $output = $this->formatter->format_non_zero_only();

        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(4, $output, ' not 4 elements');

        foreach ($output as $field) {
            $this->assertArrayHasKey('label' ,$field);
            $this->assertArrayHasKey('name' ,$field);
            $this->assertArrayHasKey('type' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };

        $this->assertEquals($output, $this->expected_output_non_zero);

    }    
*/
    public function test_format_non_zero_only_ss() {

        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','4.4');
        $label_fetcher = new TransitQuote_Pro4\TQ_LabelFetcher(array('public' => $public));
        $labels = $label_fetcher->fetch_labels_for_view('dashboard');

        $formatter_config = array( 'quote'=>$this->quote_with_stages_and_surcharges,
                                   'labels'=>$labels,
                                    'currency'=>'£',
                                    'output_def'=>array('stages',
                                                    'distance_cost',
                                                    'rate_hour',
                                                    'time_cost',
                                                    'surcharges',
                                                    'basic_cost',
                                                    'rate_tax',
                                                    'tax_cost',
                                                    'total',
                                                    'rates'));

        $this->formatter = new TransitQuote_Pro4\TQ_QuoteFormatter($formatter_config);

        $output = $this->formatter->format_non_zero_only();

        $this->assertTrue(is_array($output), ' not an array');
        $this->assertCount(5, $output, ' not 4 elements');

        foreach ($output as $field) {
            $this->assertArrayHasKey('label' ,$field);
            $this->assertArrayHasKey('name' ,$field);
            $this->assertArrayHasKey('type' ,$field);
            $this->assertArrayHasKey('value' ,$field);
        };

        $this->assertEquals($output, $this->expected_output_non_zero);

    }        
}
?>