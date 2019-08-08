<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_EmailRendererTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();



        $this->email_renderer = new TransitQuote_Pro4\TQ_EmailRenderer();

        $this->test_customer_data = json_decode('[{"label":"First Name","value":"Andrew"},{"label":"Last Name","value":"Test"},{"label":"Email Address","value":"test@etset.com"},{"label":"Phone Number","value":"345435345354"}]', true);

        $this->test_job_data = json_decode('[{"label":"Information","value":"test"},{"label":"Vehicle","value":"Van"},{"label":"Service","value":"Standard"}]', true);

        $this->test_job_datetime_data = json_decode('[{"label":"Pick Up Date","value":"August 8, 2019"},{"label":"Pick Up Time","value":"12:00 pm"}]',true);

        $this->test_journey_data = json_decode('[{"label":"Distance (Kilometers)","value":"663.2400"},{"label":"Estimated Travel Time (Hours)","value":"6.91"}]',true);

        $this->test_quote_data = json_decode('[{"label":"Distance Cost","name":"distance_cost","value":"1326.48","type":"number"},{"label":"Subtotal (GBP)","name":"basic_cost","value":"1326.48","type":"number"},{"label":"Total (GBP)","name":"total","value":"1326.48","type":"number"},{"label":"Rates","name":"rates","value":"Standard","type":"text"}]',true);


        $this->expected_text_1 = urldecode('Customer+Details%0D%0A%0D%0AFirst+Name%3A+Andrew%0D%0ALast+Name%3A+Test%0D%0AEmail+Address%3A+test%40etset.com%0D%0APhone+Number%3A+345435345354%0D%0A%0D%0A');

        $this->expected_text_2 = urldecode('Additional+Info%0D%0A%0D%0AInformation%3A+test%0D%0AVehicle%3A+Van%0D%0AService%3A+Standard%0D%0A%0D%0A');

        $this->expected_text_3 = urldecode('Pick+Up+Date%0D%0A%0D%0APick+Up+Date%3A+August+8%2C+2019%0D%0APick+Up+Time%3A+12%3A00+pm%0D%0A%0D%0A');

        $this->expected_text_4 = urldecode('Distance+and+Travel+Time%0D%0A%0D%0ADistance+%28Kilometers%29%3A+663.2400%0D%0AEstimated+Travel+Time+%28Hours%29%3A+6.91%0D%0A%0D%0A');

        $this->expected_text_5 = urldecode('Cost%0D%0A%0D%0ADistance+Cost%3A+1326.48%0D%0ASubtotal+%28GBP%29%3A+1326.48%0D%0ATotal+%28GBP%29%3A+1326.48%0D%0ARates%3A+Standard%0D%0A%0D%0A');

    }
   
    public function test_render_customer_data() {
        $email= $this->email_renderer->render(array('header'=>'Customer Details','data'=>$this->test_customer_data)); 
        //echo urlencode($email);
        $this->assertEquals($this->expected_text_1, $email);
    }

    public function test_render_job_data(){
        $email = $this->email_renderer->render(array('header'=>'Additional Info','data'=>$this->test_job_data)); 
        //echo urlencode($email);

        $this->assertEquals($this->expected_text_2, $email);
    }

    public function test_render_datetime_data(){
        $email = $this->email_renderer->render(array('header'=>'Pick Up Date','data'=>$this->test_job_datetime_data));
        //echo urlencode($email);

        $this->assertEquals($this->expected_text_3, $email);
    }   

    public function test_render_journey_data(){
        $email = $this->email_renderer->render(array('header'=>'Distance and Travel Time','data'=>$this->test_journey_data));
        //echo urlencode($email);

        $this->assertEquals($this->expected_text_4, $email);
    }

    public function test_render_quote_data(){
        $email = $this->email_renderer->render(array('header'=>'Cost','data'=>$this->test_quote_data));
        //echo urlencode($email);

        $this->assertEquals($this->expected_text_5, $email);
    }     
}
?>