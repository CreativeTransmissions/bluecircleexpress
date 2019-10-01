<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;


final class TQ_RateSelectorTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->rate_options_invalid = json_decode('{"leg_type":"standard","date_list":["27-9-2019"],"time_list":["12:30 PM"],"delivery_date":"27-9-2019","delivery_time":"12:30 PM","vehicle_id":"1","service_id":"1","distance":"415.50","return_time":0,"deliver_and_return":0,"return_distance":0,"no_destinations":1,"hours":0}', true);

        $this->rate_options_valid = json_decode('{"leg_type":"standard","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}],"use_out_of_hours_rates":false,"use_weekend_rates":false,"use_holiday_rates":false,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","date_list":["30-9-2019"],"time_list":["11:30 AM"],"delivery_date":"30-9-2019","delivery_time":"11:30 AM","vehicle_id":"1","service_id":"1","distance":"291.63","return_time":0,"deliver_and_return":"1","return_distance":0,"no_destinations":1,"hours":0}', true);

        $this->rate_options_holiday = json_decode('{"leg_type":"standard","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}],"use_out_of_hours_rates":false,"use_weekend_rates":false,"use_holiday_rates":true,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","date_list":["15-10-2019"],"time_list":["11:30 AM"],"delivery_date":"15-10-2019","delivery_time":"11:30 AM","vehicle_id":"1","service_id":"1","distance":"291.63","return_time":0,"deliver_and_return":"1","return_distance":0,"no_destinations":1,"hours":0}', true);


        $this->rate_options_weekend = json_decode('{"leg_type":"standard","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}],"use_out_of_hours_rates":false,"use_weekend_rates":true,"use_holiday_rates":true,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","date_list":["15-09-2019"],"time_list":["11:30 AM"],"delivery_date":"15-10-2019","delivery_time":"11:30 AM","vehicle_id":"1","service_id":"1","distance":"291.63","return_time":0,"deliver_and_return":"1","return_distance":0,"no_destinations":1,"hours":0}', true);


        $this->rate_options_out_of_hours = json_decode('{"leg_type":"standard","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}],"use_out_of_hours_rates":true,"use_weekend_rates":false,"use_holiday_rates":false,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","date_list":["30-9-2019"],"time_list":["9:30 PM"],"delivery_date":"30-9-2019","delivery_time":"11:30 PM","vehicle_id":"1","service_id":"1","distance":"291.63","return_time":0,"deliver_and_return":"1","return_distance":0,"no_destinations":1,"hours":0}', true);

        $this->rate_options_dispatch = json_decode('{"leg_type":"dispatch","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}],"use_out_of_hours_rates":false,"use_weekend_rates":false,"use_holiday_rates":false,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","date_list":["30-9-2019"],"time_list":["11:30 AM"],"delivery_date":"30-9-2019","delivery_time":"11:30 AM","vehicle_id":"1","service_id":"1","distance":"291.63","return_time":0,"deliver_and_return":"1","return_distance":0,"no_destinations":1,"hours":0}', true);

        $this->rate_options_return_to_pickup = json_decode('{"leg_type":"return_to_pickup","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}],"use_out_of_hours_rates":false,"use_weekend_rates":false,"use_holiday_rates":false,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","date_list":["30-9-2019"],"time_list":["11:30 AM"],"delivery_date":"30-9-2019","delivery_time":"11:30 AM","vehicle_id":"1","service_id":"1","distance":"291.63","return_time":0,"deliver_and_return":"1","return_distance":0,"no_destinations":1,"hours":0}', true);

        $this->rate_options_return_to_base = json_decode('{"leg_type":"return_to_base","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}],"use_out_of_hours_rates":false,"use_weekend_rates":false,"use_holiday_rates":false,"booking_start_time":"07:00:00","booking_end_time":"21:00:00","date_list":["30-9-2019"],"time_list":["11:30 AM"],"delivery_date":"30-9-2019","delivery_time":"11:30 AM","vehicle_id":"1","service_id":"1","distance":"291.63","return_time":0,"deliver_and_return":"1","return_distance":0,"no_destinations":1,"hours":0}', true);
        $this->cdb = TransitQuote_Pro4::get_custom_db();

        $this->rate_selector = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_valid,
                                                                            'cdb'=>$this->cdb));

    }

    public static function setUpBeforeClass(){
        // ** import rates for single service / vehicle with different dispatch rates
        $command = 'mysql -uroot -proot tailwind < /srv/www/tailwind/public_html/wp-content/plugins/transitquote-pro/tests/test_json/tailwind_simple_rates.sql';
        echo shell_exec($command);
    }
       
    protected function tearDown(){
        $this->rate_selector = null;

    }

    public function test_rate_options_are_valid() {
        $this->rate_selector_invalid = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_invalid));
        $valid = $this->rate_selector_invalid->rate_options_are_valid();
        $this->assertFalse($valid);

        $valid = $this->rate_selector->rate_options_are_valid();
        $this->assertTrue($valid);        
    }
 
    public function test_get_rates_fields_for_journey_options(){
    //    $fields = $this->rate_selector->get_rates_fields_for_journey_options();
     //   $this->assertEquals(["id","service_id","vehicle_id","distance","amount","unit","hour"], $fields);


        $rate_selector_holiday = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_holiday,
                                                                            'cdb'=>$this->cdb));        

        $fields_holiday = $rate_selector_holiday->get_rates_fields_for_journey_options();
        $this->assertEquals('holiday',  $rate_selector_holiday->job_rate);
        $this->assertEquals(["id","service_id","vehicle_id","distance","amount_holiday as amount","unit_holiday as unit","hour_holiday as hour"], $fields_holiday);

        $rate_selector_weekend = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_weekend,
                                                                            'cdb'=>$this->cdb));        

        $fields_weekend = $rate_selector_weekend->get_rates_fields_for_journey_options();
        $this->assertEquals('weekend',  $rate_selector_weekend->job_rate);
        $this->assertEquals(["id","service_id","vehicle_id","distance","amount_weekend as amount","unit_weekend as unit","hour_weekend as hour"], $fields_weekend);        

       $rate_selector_out_of_hours = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_out_of_hours,
                                                                            'cdb'=>$this->cdb)); 
        $fields_out_of_hours = $rate_selector_out_of_hours->get_rates_fields_for_journey_options();
        $this->assertEquals('out of hours',  $rate_selector_out_of_hours->job_rate);
        $this->assertEquals(["id","service_id","vehicle_id","distance","amount_out_of_hours as amount","unit_out_of_hours as unit","hour_out_of_hours as hour"], $fields_out_of_hours);     

       $rate_selector_dispatch = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_dispatch,
                                                                            'cdb'=>$this->cdb)); 
        $fields_dispatch = $rate_selector_dispatch->get_rates_fields_for_journey_options();
        $this->assertEquals('dispatch',  $rate_selector_dispatch->job_rate);
        $this->assertEquals(["id","service_id","vehicle_id","distance","amount_dispatch as amount","unit_dispatch as unit","hour_dispatch as hour"], $fields_dispatch);        


       $rate_selector_return_to_pickup = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_return_to_pickup,
                                                                            'cdb'=>$this->cdb)); 
        $fields_return_to_pickup = $rate_selector_return_to_pickup->get_rates_fields_for_journey_options();
        $this->assertEquals('return_to_pickup',  $rate_selector_return_to_pickup->job_rate);
        $this->assertEquals(["id","service_id","vehicle_id","distance","amount_return_to_pickup as amount","unit_return_to_pickup as unit","hour_return_to_pickup as hour"], $fields_return_to_pickup);     

                $rate_selector_return_to_base = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_return_to_base,
                                                                            'cdb'=>$this->cdb)); 
        $fields_return_to_base = $rate_selector_return_to_base->get_rates_fields_for_journey_options();
        $this->assertEquals('return_to_base',  $rate_selector_return_to_base->job_rate);
        $this->assertEquals(["id","service_id","vehicle_id","distance","amount_return_to_base as amount","unit_return_to_base as unit","hour_return_to_base as hour"], $fields_return_to_base); 
        
    }

    public function test_get_rates_for_journey_options(){

        $rates = $this->rate_selector->get_rates_for_journey_options();
        $this->assertTrue(is_array($rates));
        $this->assertCount(1, $rates);
        $this->assertEquals(2.35, $rates[0]['unit']); //standard rate

        $rate_selector_dispatch = new TransitQuote_Pro4\TQ_RateSelector(array('rate_options'=>$this->rate_options_dispatch,
                                                                            'cdb'=>$this->cdb));      

        $rates = $rate_selector_dispatch->get_rates_for_journey_options();
        $this->assertEquals(0.65, $rates[0]['unit']); //standard rate


    }

    public function test_get_rates_query_for_journey_options(){
        $rates_query = $this->rate_selector->get_rates_query_for_journey_options();
        $this->assertTrue(is_array($rates_query));
        $this->assertEquals(1, $rates_query['service_id']);
        $this->assertEquals(1, $rates_query['vehicle_id']);
        $this->assertEquals(1, $rates_query['journey_length_id']);
    }

}
