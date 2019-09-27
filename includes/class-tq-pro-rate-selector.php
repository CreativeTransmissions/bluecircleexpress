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
class TQ_RateSelector {

 	private $default_config = array('cdb'=>null,
 									'prefix'=>'BCE',
 									'length'=>9); 

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

   public function get_rates_for_journey_options() {

        $rates = false;
        $this->rates_query = $query = self::get_rates_query_for_journey_options();
        if ($query === false) {
            //echo 'could not get query';
            return false;
        };

        $date_list = $this->request_parser->get_location_dates();
        $time_list = $this->request_parser->get_location_times();

        $this->booking_start_time = date('H:i:s',strtotime(self::get_setting('tq_pro_form_options', 'booking_start_time', '07:00 AM')));
        $this->booking_end_time = date('H:i:s',strtotime(self::get_setting('tq_pro_form_options', 'booking_end_time', '09:00 PM'))); 

        $date_checker_config = array('date_list'=>$date_list,
                                    'time_list'=>$time_list,
                                    'use_out_of_hours_rates'=>$this->use_out_of_hours_rates,
                                    'use_holiday_rates'=>$this->use_holiday_rates,
                                    'use_weekend_rates'=>$this->use_weekend_rates,
                                    'booking_start_time'=>$this->booking_start_time,
                                    'booking_end_time'=>$this->booking_end_time);

        //echo json_encode($date_checker_config);



        $this->date_checker = new TransitQuote_Pro4\TQ_DateChecker($date_checker_config);

        if(!empty($this->rate_options['delivery_date']) && !empty($this->rate_options['delivery_time'])){
            $this->job_rate = $this->date_checker->get_rates_period(); 

            // default fields use standard rates in case of disabled job rates for holidays, weekends or out of hours
            $fields = array('id', 'service_id', 'vehicle_id', 'distance', 'amount', 'unit', 'hour');

            switch ($this->job_rate) {
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
        //    echo 'getting rates with period based fields fields';
            $rates = $this->cdb->get_rows( 'rates', $query, $fields );
        //    echo $this->cdb->last_query;
            return $rates;
        } else {
            return $this->cdb->get_rows( 'rates', $query );
        }
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
        //echo $sql;
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