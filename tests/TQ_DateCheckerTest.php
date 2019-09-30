<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;


final class DateCheckerTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();


        $this->test_config_standard = json_decode('{"date_list":["2019-09-27 13:15:00","2019-09-27 14:30:00"],"time_list":["13:15:00","14:30:00"],"use_out_of_hours_rates":true,"use_holiday_rates":true,"use_weekend_rates":true,"booking_start_time":"06:00:00","booking_end_time":"18:00:00","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}]}', true);   

        $this->test_config_weekend = json_decode('{"date_list":["2019-09-27 13:15:00","2019-09-28 14:30:00"],"time_list":["13:15:00","14:30:00"],"use_out_of_hours_rates":true,"use_holiday_rates":true,"use_weekend_rates":true,"booking_start_time":"06:00:00","booking_end_time":"18:00:00","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}]}', true);   

        $this->test_config_out_of_hours = json_decode('{"date_list":["2019-09-27 13:15:00","2019-09-27 19:30:00"],"time_list":["19:30:00","14:30:00"],"use_out_of_hours_rates":true,"use_holiday_rates":true,"use_weekend_rates":true,"booking_start_time":"06:00:00","booking_end_time":"18:00:00","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}]}', true);

        $this->test_config_holiday = json_decode('{"date_list":["2019-10-15 13:15:00","2019-09-27 21:30:00"],"time_list":["19:30:00","21:30:00"],"use_out_of_hours_rates":true,"use_holiday_rates":true,"use_weekend_rates":true,"booking_start_time":"06:00:00","booking_end_time":"18:00:00","holiday_dates":[{"id":"1","start_date":"2019-10-13 00:00:00","end_date":"2019-10-17 00:00:00","created":"2019-09-30 14:11:45","modified":"2019-09-30 14:11:45"}]}', true);   
        }
   
    protected function tearDown(){
        $this->public = null;

    }


    public function test_get_rates_period_standard() {

        $this->date_checker = new TransitQuote_Pro4\TQ_DateChecker($this->test_config_standard);
        $rates_period = $this->date_checker->get_rates_period();
        $this->assertTrue(is_string($rates_period));
        $this->assertEquals('standard', $rates_period);
    }
 
     public function test_get_rates_period_weekend() {

        $this->date_checker = new TransitQuote_Pro4\TQ_DateChecker($this->test_config_weekend);
        $rates_period = $this->date_checker->get_rates_period();
        $this->assertTrue(is_string($rates_period));
        $this->assertEquals('weekend', $rates_period);
    }

     public function test_get_rates_period_out_of_hours() {

        $this->date_checker = new TransitQuote_Pro4\TQ_DateChecker($this->test_config_out_of_hours);
        $rates_period = $this->date_checker->get_rates_period();
        $this->assertTrue(is_string($rates_period));
        $this->assertEquals('out of hours', $rates_period);
    }    

     public function test_get_rates_period_holiday() {

        $this->date_checker = new TransitQuote_Pro4\TQ_DateChecker($this->test_config_holiday);
        $rates_period = $this->date_checker->get_rates_period();
        $this->assertTrue(is_string($rates_period));
        $this->assertEquals('holiday', $rates_period);
    }    
}
