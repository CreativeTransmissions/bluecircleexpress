<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_TableRendererTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();



        $this->table_renderer = new TransitQuote_Pro4\TQ_TableRenderer();

        $this->test_quote_data = json_decode('[{"label":"Distance Cost","name":"distance_cost","value":"1326.48","type":"number"},{"label":"Hourly Rate (GBP)","name":"rate_hour","value":"0.00","type":"text"},{"label":"Time Cost (GBP)","name":"time_cost","value":"0.00","type":"text"},{"label":"Subtotal (GBP)","name":"basic_cost","value":"1326.48","type":"number"},{"label":"VAT Rate (%)","name":"rate_tax","value":"0.00","type":"text"},{"label":"VAT (GBP)","name":"tax_cost","value":"0.00","type":"text"},{"label":"Total (GBP)","name":"total","value":"1326.48","type":"number"}]', true);

        $this->expected_html = '<table><tbody><tr><th colspan="2"><h3>Quote</h3></th></tr><tr><td>Distance Cost</td><td>1326.48</td></tr><tr><td>Hourly Rate (GBP)</td><td>0.00</td></tr><tr><td>Time Cost (GBP)</td><td>0.00</td></tr><tr><td>Subtotal (GBP)</td><td>1326.48</td></tr><tr><td>VAT Rate (%)</td><td>0.00</td></tr><tr><td>VAT (GBP)</td><td>0.00</td></tr><tr><td>Total (GBP)</td><td>1326.48</td></tr></tbody></table>';
    }
   
    public function test_render() {

        $html = $this->table_renderer->render(array('header'=>'<h3>Quote</h3>',
        											'data'=>$this->test_quote_data)); 
        $this->assertEquals($this->expected_html, $html);
    }
}
?>