<?php

/**
 * Define Request Parser For Get Quote Requests
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
namespace TransitQuote_Pro4;
class TQ_DateChecker {

 	private $default_config = array('date_list'=>array(),
                                    'time_list'=>array()); // pass in list of dates and times in order

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
        $this->date_list = $this->config['date_list'];
        $this->time_list = $this->config['time_list'];        
        $this->use_holiday_rates = (bool)$this->config['use_holiday_rates'];
        $this->use_weekend_rates = (bool)$this->config['use_weekend_rates'];
        $this->use_out_of_hours_rates = (bool)$this->config['use_out_of_hours_rates'];
     
	}

    public function get_rates_period(){
        if(empty($this->holiday_dates_array)){
            $this->holiday_dates_array = self::get_holiday_dates();  
        };
        //return standard, out_of_hours, weekend, holiday
        if(self::any_location_date_is_holiday() && ($this->use_holiday_rates) ){
            return 'holiday';
        } else if (self::any_location_date_is_weekend()  && ($this->use_weekend_rates) ) {
            return 'weekend';
        } else if((self::is_out_of_booking_time())&&($this->use_out_of_hours_rates )) {
            return 'out of hours';
        } else {
            return 'standard';
        }        

    }

    function any_location_date_is_weekend() {
        foreach ($this->date_list as $location_date) {
            $formatted_date = date("Y-m-d", strtotime($location_date));
            if(self::is_weekend($formatted_date)){
             //   echo 'out of hours: ';
              //  print_r($location_data);
                return true;
            } else {
           //     echo 'not out of hours for this location';
         //       print_r($location_data);
            }
        };
      
        return false;
    }

    // weekends
    function is_weekend($job_date) {        
        $weekDay = date('w', strtotime($job_date));
        return ($weekDay == 0 || $weekDay == 6);
    }

    // out of hours
    function is_out_of_booking_time() {
        foreach ($this->time_list as $location_time) {
            if(self::collection_time_is_out_of_hours($location_time)){
             //   echo 'out of hours: ';
              //  print_r($location_data);
                return true;
            } else {
           //     echo 'not out of hours for this location';
         //       print_r($location_data);
            }
        };
     
        return false;
    }

    function collection_time_is_out_of_hours($location_time){

        //echo 'index: '.$location_data['address_index'].' collection_time: '.$collection_time;
        $earlier_than_start = ($location_time < $this->config['booking_start_time']);
       // echo 'earlier_than_start = '.$earlier_than_start;
        
        $later_than_finish = ($location_time > $this->config['booking_end_time']);
      //  echo 'later_than_finish = '.$later_than_finish;
      //  echo 'finish time: '.$this->config['booking_end_time'];

        if( $earlier_than_start||$later_than_finish ){
            return true;
        } else {
            return false;
        };
    }

    function any_location_date_is_holiday(){
        foreach ($this->date_list as $location_date) {
            $formatted_date = date("Y-m-d", strtotime($location_date));
            if(self::is_holiday($formatted_date)){
               // echo 'HOLIDAY DETECTED: ';
               // print_r($formatted_date);
                return true;
            };
        };
        return false;
    }

    function is_holiday($delivery_date) {
        $job_date = date("Y-m-d", strtotime($delivery_date));        
     
        $is_holiday = in_array($job_date, $this->holiday_dates_array);
        if($is_holiday===false){
          //  echo $job_date.' is NOT in :';
          //  print_r($this->holiday_dates_array);

        } else {
         //   echo $job_date.' IS in :';
        //    print_r($this->holiday_dates_array);

            return true;
        }

        return false;
    }
    
    // holiday dates range
    function get_holiday_dates() {

        // get future dates only
        $all_holiday_dates = $this->config['holiday_dates'];
        $holiday_dates_array = array();

        foreach ($all_holiday_dates as $key => $holiday_dates) {
            $start_date = $holiday_dates['start_date'];
            $sdate = $holiday_dates['start_date'];
            $end_date = $holiday_dates['end_date'];
            if ($end_date == $start_date) {
                $holiday_dates_array[] = date("Y-m-d", strtotime($start_date));
            } else {
                while (strtotime($sdate) <= strtotime($end_date)) {
                    $holiday_dates_array[] = date("Y-m-d", strtotime($sdate));
                    $sdate = date("Y-m-d", strtotime("+1 day", strtotime($sdate)));
                }
            }
        };
        return $holiday_dates_array;
    }
}
?>