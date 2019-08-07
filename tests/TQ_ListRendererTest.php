<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_ListRendererTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();



        $this->list_renderer = new TransitQuote_Pro4\TQ_ListRenderer();

        $this->test_list_data = json_decode('[{"name":"appartment_no","value":"2\/1","type":"text","label":"Unit No"},{"name":"street_number","value":"385","type":"text"},{"name":"postal_town","value":"Glasgow","type":"text"},{"name":"route","value":"Dumbarton Road","type":"text"},{"name":"administrative_area_level_2","value":"Glasgow City","type":"text"},{"name":"administrative_area_level_1","value":"Scotland","type":"text"},{"name":"country","value":"United Kingdom","type":"text"},{"name":"postal_code","value":"G11 6BE","type":"text"},{"name":"lat","value":"55.87069900000000000000","type":"number"},{"name":"lng","value":"-4.30828000000000000000","type":"number"},{"name":"contact_name","value":"Andrew","type":"text"},{"name":"contact_phone","value":"123123123123","type":"text"}]', true);

        $this->test_list_data2 = json_decode('[{"name":"appartment_no","value":"1","type":"text"},{"name":"street_number","value":"28 - 40","type":"text"},{"name":"postal_town","value":"Glasgow","type":"text"},{"name":"route","value":"Union Street","type":"text"},{"name":"administrative_area_level_2","value":"Glasgow City","type":"text"},{"name":"administrative_area_level_1","value":"Scotland","type":"text"},{"name":"country","value":"United Kingdom","type":"text"},{"name":"postal_code","value":"G1 3QX","type":"text"},{"name":"lat","value":"55.85886300000000000000","type":"number"},{"name":"lng","value":"-4.25660400000000000000","type":"number"},{"name":"contact_name","value":"Dude","type":"text"},{"name":"contact_phone","value":"93478534957","type":"text"}]', true);

        $this->expected_html_1 = '<ul class="tq-list"><li>Unit No: 2/1</li><li>385</li><li>Glasgow</li><li>Dumbarton Road</li><li>Glasgow City</li><li>Scotland</li><li>United Kingdom</li><li>G11 6BE</li><li>55.87069900000000000000</li><li>-4.30828000000000000000</li><li>Andrew</li><li>123123123123</li></ul>';

        $this->expected_html_2 = '<ul class="tq-list"><li>1</li><li>28 - 40</li><li>Glasgow</li><li>Union Street</li><li>Glasgow City</li><li>Scotland</li><li>United Kingdom</li><li>G1 3QX</li><li>55.85886300000000000000</li><li>-4.25660400000000000000</li><li>Dude</li><li>93478534957</li></ul>';
    }
   
    public function test_render() {

        $html = $this->list_renderer->render(array('data'=>$this->test_list_data)); 
        $this->assertEquals($this->expected_html_1, $html);
    }

    public function test_render2(){
        $html = $this->list_renderer->render(array('data'=>$this->test_list_data2)); 
        $this->assertEquals($this->expected_html_2, $html);
    }
}
?>