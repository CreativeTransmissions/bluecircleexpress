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
class TQ_RequestParserGetQuote {

 	private $default_config = array();  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function parse_directions(){

		$this->directions = $this->get_param(array('name' => 'directions', 'type'=>'json', 'optional' => false));
        print_r($this->this->directions);

	}

    public function get_rate_affecting_options() {

     //   $service = self::get_default_service();
    //    $vehicle = self::get_default_vehicle();

        $vehicle_id = $this->get_param(array('name' => 'vehicle_id', 'optional' => true));
        /*if (empty($vehicle_id)) {
            $vehicle_id = $vehicle['id'];
        };*/

        $service_id = $this->get_param(array('name' => 'service_id', 'optional' => true));
        /*if (empty($service_id)) {
            $service_id = $service['id'];
        };*/

        $distance = $this->get_param(array('name' => 'distance', 'optional' => true));
        if (empty($distance)) {
            $distance = 0;
        };

        $hours = $this->get_param(array('name' => 'hours', 'optional' => true));
        if (empty($hours)) {
            $hours = 0;
        };

        $return_time = $this->get_param(array('name' => 'return_time', 'optional' => true));
        if (empty($return_time)) {
            $return_time = 0;
        };

        $return_distance = $this->get_param(array('name' => 'return_distance', 'optional' => true));
        if (empty($return_distance)) {
            $return_distance = 0;
        };

        $deliver_and_return = $this->get_param(array('name' => 'deliver_and_return', 'optional' => true));
        if (empty($deliver_and_return)) {
            $deliver_and_return = 0;
        };

        $no_destinations = $this->get_param(array('name' => 'no_destinations', 'optional' => true));
        if (empty($no_destinations)) {
            $no_destinations = 1;
        };

        $delivery_date = $this->get_param(array('name' => 'delivery_date', 'optional' => true));     
        $delivery_time = $this->get_param(array('name' => 'delivery_time', 'optional' => true));


        return array(
            'delivery_date'=> $delivery_date,
            'delivery_time'=>$delivery_time,
            'vehicle_id' => $vehicle_id,
            'service_id' => $service_id,
            'distance' => $distance,
            'return_time' => $return_time,
            'deliver_and_return' => $deliver_and_return,
            'return_distance' => $return_distance,
            'no_destinations' => $no_destinations,
            'hours' => $hours,
            'use_holiday_rates'=>$this->use_holiday_rates,
            'use_weekend_rates'=>$this->use_weekend_rates,
            'use_out_of_hours_rates'=>$this->use_out_of_hours_rates
        );
    }	

	public function get_param($options){

        //retrieve a passed parameter from a get or post request and perform basic validation
        $name = $options['name'];
        $val = '';

        //Get parameter from ajax data

        if(isset($_REQUEST[$name])){
            $val = $_REQUEST[$name];
        };
        

        $optional = false;
        if(isset($options['optional'])){
            if($options['optional']==true){
                $optional = true;
            }
        };

        //check for empty value
        if(!$optional){
            if($val==''){
                //return false if not supplied
                self::respond(array('success' => 'false',
                                        'msg'=>'No '.$name.' received.'));
            }
        };

        if(isset($options['type'])){
            if(!empty($val)){
                switch ($options['type']) {
                    case 'array':
                        if(!is_array($val)){
                            $val = 'invalid';
                            $error = 'Not Array';

                        };
                        break;                	
                    case 'num':
                        if(!is_numeric($val)){
                            $val = 'invalid';
                            $error = 'Not Numeric';
                        };
                        break;
                    case 'alpha':
                        if(!ctype_alpha($val)){
                            $val = 'invalid';
                            $error = 'Not Text Only';
                        };
                        break;
                    case 'alnum':
                        if(!ctype_alnum($val)){
                            $val = 'invalid';
                            $error = 'Not Alphaumeric';
                        };
                        break;
                    case 'json':
                        $val = json_decode(stripslashes($val), TRUE);
                        break;
                    default:
                        //no validation
                        $val = stripslashes($val);
                        break;
                };
            };
        };

        if(!$optional){
            //passed or skipped validation, return parameter
            if($val=='invalid'){
                    self::respond(array('success' => 'false',
                                    'msg'=>'Invalid '.$name.' received. '.$error));
            } else {
                return $val;
            }   

        } else {
            return (isset($val)?$val:'');
        }
    }    
}
?>