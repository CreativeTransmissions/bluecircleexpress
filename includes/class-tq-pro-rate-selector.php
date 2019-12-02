<?php

/**
 * Define Calculation functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 */

/**
 * select rates for one leg based on:
 * - distance
 * - eta
 * - service 
 * - vehicle
 * - booking date(s)
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
namespace TransitQuote_Pro4;
class TQ_RateSelector {

 	private $default_config = array('cdb'=>null,
                                    'rate_options'=>array()); 

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
        $this->rate_options = $config['rate_options'];

        $this->cdb = $this->config['cdb'];
	}

    public function rate_options_are_valid(){
        if(empty($this->rate_options)){
            print_r('rate_options_are_valid: no params passed', E_USER_WARNING);

            return false;
        };

        if(!isset($this->rate_options['service_id'])){
            print_r('rate_options_are_valid: invalid param: service_id', E_USER_WARNING);

            return false;
        };

        if(!isset($this->rate_options['vehicle_id'])){
            print_r('rate_options_are_valid: invalid param: vehicle_id', E_USER_WARNING);

            return false;
        };

        if(!isset($this->rate_options['distance'])){
            print_r('rate_options_are_valid: invalid param: distance', E_USER_WARNING);

            return false;
        };

        if(!isset($this->rate_options['date_list'])){
            print_r('rate_options_are_valid: invalid param: date_list', E_USER_WARNING);

            return false;
        };

        if(!isset($this->rate_options['time_list'])){
            print_r('rate_options_are_valid: invalid param: time_list', E_USER_WARNING);

            return false;
        };

        if(!isset($this->rate_options['use_holiday_rates'])){
            print_r('rate_options_are_valid: invalid param: use_holiday_rates', E_USER_WARNING);

            return false;
        };

        if(!isset($this->rate_options['use_weekend_rates'])){
            print_r('rate_options_are_valid: invalid param: use_weekend_rates', E_USER_WARNING);            
            return false;
        };

        if(!isset($this->rate_options['use_out_of_hours_rates'])){
            print_r('rate_options_are_valid: invalid param: use_out_of_hours_rates', E_USER_WARNING);
            return false;
        }        

        if(!isset($this->rate_options['holiday_dates'])){
            print_r('rate_options_are_valid: invalid param: holiday_dates', E_USER_WARNING);
            return false;
        } else {
            if(!is_array($this->rate_options['holiday_dates'])){
                 print_r('rate_options_are_valid: invalid param: holiday_dates - not an array', E_USER_WARNING);
                return false;
            }
        };   
               
        return true;
    }
   public function get_rates_for_journey_options() {

        $fields = $this->get_rates_fields_for_journey_options();

        $rates = false;
        $this->rates_query = self::get_rates_query_for_journey_options();
        if ($this->rates_query === false) {
            //echo 'could not get query';
            return false;
        };


    //    echo 'getting rates with period based fields fields';
        $rates = $this->cdb->get_rows( 'rates', $this->rates_query, $fields );
        //echo $this->cdb->last_query;
        return $rates;

    }

    public function get_rates_fields_for_journey_options(){

        $date_checker_config = array('date_list'=>$this->rate_options['date_list'],
                                    'time_list'=>$this->rate_options['time_list'],
                                    'holiday_dates'=>$this->rate_options['holiday_dates'],
                                    'use_out_of_hours_rates'=>$this->rate_options['use_out_of_hours_rates'],
                                    'use_holiday_rates'=>$this->rate_options['use_holiday_rates'],
                                    'use_weekend_rates'=>$this->rate_options['use_weekend_rates'],
                                    'booking_start_time'=>$this->rate_options['booking_start_time'],
                                    'booking_end_time'=>$this->rate_options['booking_end_time']);

        $this->date_checker = new TQ_DateChecker($date_checker_config);

        //initial job rate based on time
        $this->job_rate = $this->date_checker->get_rates_period(); 


        // time based rates are overridden for dispatch or return to base
        if($this->rate_options['leg_type']==='dispatch'){
             $this->job_rate = 'dispatch';
        };

        if($this->rate_options['leg_type']==='return_to_pickup'){
            $this->job_rate = 'return_to_pickup';
        };

        if($this->rate_options['leg_type']==='return_to_base'){
            $this->job_rate = 'return_to_base';
        };        

        // default fields use standard rates in case of disabled job rates for holidays, weekends or out of hours
        $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount', 'unit', 'hour');

        switch ($this->job_rate) {
            case 'dispatch':
                 $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount_dispatch as amount', 'unit_dispatch as unit', 'hour_dispatch as hour');
            break;
            case 'return_to_pickup':
                 $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount_return_to_pickup as amount', 'unit_return_to_pickup as unit', 'hour_return_to_pickup as hour');
            break;
            case 'return_to_base':
                 $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount_return_to_base as amount', 'unit_return_to_base as unit', 'hour_return_to_base as hour');
            break;
            case 'holiday':
                 $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount_holiday as amount', 'unit_holiday as unit', 'hour_holiday as hour');
                 break;
            case 'weekend':
                $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount_weekend as amount', 'unit_weekend as unit', 'hour_weekend as hour');
                                    break;
            case 'out of hours':
                $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount_out_of_hours as amount', 'unit_out_of_hours as unit', 'hour_out_of_hours as hour');                      
                                    break;
            case 'standard':
                $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount', 'unit', 'hour');
                break;
            default:
                $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount', 'unit', 'hour');
                break;
        };

        return $fields;    
    }

    public function get_rates_query_for_journey_options() {
        $journey_length_id = self::get_journey_length_id_for_distance();
        if ($journey_length_id === false) {
            echo 'no journey_length_id.';
            return false;
        } else {
            $rates_query = array('service_id' => $this->rate_options['service_id'],
                'vehicle_id' => $this->rate_options['vehicle_id'],
                'journey_length_id' => $journey_length_id);
        };
        return $rates_query;

    }

 	private function get_journey_length_id_for_distance() {
        $this->journey_lengths = self::get_journey_lengths_except_max();
        $journey_length_id = self::get_range_for_number($this->rate_options['distance'], $this->journey_lengths);
        if ($journey_length_id === false) {
            $journey_length_id = self::get_max_journey_length_id();
            //    echo ' OVER MAX JL so jlid is: '.$journey_length_id;
        }
        return $journey_length_id;
    }

    private function get_max_journey_length_id() {
        $query = array('distance' => 0);
        $journey_lengths = $this->cdb->get_rows('journey_lengths', $query);
        if (is_array($journey_lengths)) {
            return $journey_lengths[0]['id'];
        } else {
            $this->response_msg = 'No range set for longest journeys';
            return false;
        }

    }

    public function get_journey_lengths_except_max() {
        $journey_lengths_table_name = $this->cdb->get_table_full_name('journey_lengths');
        // get ordered list of rates with distance 0 as the final record
        $sql = "select distinct *
					from " . $journey_lengths_table_name . "
					where distance > 0
					order by distance asc;";

        $data = $this->cdb->query($sql);
        return $data;
    }

    public function get_range_for_number($number, $ranges) {
        $range_lower_limit = 0;
        foreach ($ranges as $key => $range_limit) {
            $range_upper_limit = $range_limit['distance'];

            if (self::number_in_range($number, $range_lower_limit, $range_upper_limit)) {
                //echo $number.' is betweeten '.$range_lower_limit.' and '.$range_upper_limit;
                return $range_limit['id'];
            } else {
                //echo $number.' is NOT betweeten '.$range_lower_limit.' and '.$range_upper_limit;
                $range_lower_limit = $range_upper_limit;
            }
        };
        return false; //not between any range
    }

    private function number_in_range($number, $range_lower_limit, $range_upper_limit) {
        if ($number > $range_lower_limit && $number <= $range_upper_limit) {
            return true;
        };
        return false;

    }

}

?>