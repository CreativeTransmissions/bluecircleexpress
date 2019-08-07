<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_RouteRendererTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();



        $this->route_renderer = new TransitQuote_Pro4\TQ_RouteRenderer();

        $this->test_params = json_decode('{"header":"<h3>Route<\/h3>","data":[[{"name":"address","value":"385 Dumbarton Road, Glasgow, UK","type":"text"},{"name":"appartment_no","value":"2\/1","type":"text","label":"Unit No"},{"name":"postal_code","value":"G11 6BE","type":"text"},{"name":"contact_name","value":"Andrew","type":"text","label":"Contact Name"},{"name":"contact_phone","value":"123123123123","type":"text","label":"Contact Phone"}],[{"name":"address","value":"CeX, Union Street, Glasgow, UK","type":"text"},{"name":"appartment_no","value":"1","type":"text","label":"Unit No"},{"name":"postal_code","value":"G1 3QX","type":"text"},{"name":"contact_name","value":"Dude","type":"text","label":"Contact Name"},{"name":"contact_phone","value":"93478534957","type":"text","label":"Contact Phone"}]]}', true);

        $this->expected_html = '<table><tbody><tr><th colspan="1"><h3>Route</h3></th></tr><tr><td><ul class="tq-list"><li>385 Dumbarton Road, Glasgow, UK</li><li>Unit No: 2/1</li><li>G11 6BE</li><li>Contact Name: Andrew</li><li>Contact Phone: 123123123123</li></ul></td></tr><tr><td><ul class="tq-list"><li>CeX, Union Street, Glasgow, UK</li><li>Unit No: 1</li><li>G1 3QX</li><li>Contact Name: Dude</li><li>Contact Phone: 93478534957</li></ul></td></tr></tbody></table>';
    }
   
    public function test_generate_list_for_each_waypoint(){
        $this->route_renderer->data = $this->test_params['data'];

        $array_of_lists = $this->route_renderer->generate_list_for_each_waypoint(); 

        $this->assertTrue(is_array($array_of_lists), ' not an array');
        $this->assertCount(2, $array_of_lists);

    }
    public function test_render() {

        $html = $this->route_renderer->render($this->test_params); 
        $this->assertTrue(is_string($html), 'output not a string');

        echo $html;

        $this->assertEquals($this->expected_html, $html);
    }
}
?>