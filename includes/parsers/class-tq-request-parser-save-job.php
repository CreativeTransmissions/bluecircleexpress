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
class TQ_RequestParserSaveJob {

 	private $default_config = array();  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
        $this->post_data = $this->config['post_data'];
	}

	
    public function get_record_data_customer(){
        $quote_id = $this->get_param(array('name' => 'quote_id', 'optional' => true));
    };





        return array(
            'quote_id'=>$quote_id,
            'date_list'=>$date_list,
            'time_list'=>$time_list,
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
            'weight'=>$weight,
            'surcharge_ids'=>$surcharge_ids
        );
    }	

    public function using_location_dates(){
        if(!isset($this->all_locations_optional_data)){
            $this->get_location_data_for_all_stops();
        };
        if(isset($this->all_locations_optional_data[0]['collection_date'])){
            return true;
        };

        return false;
    }

    public function get_location_dates(){
        if(!isset($this->all_locations_optional_data)){
            $this->get_location_data_for_all_stops();
        };
        $this->location_dates = [];
        foreach ($this->all_locations_optional_data as $key => $location_fields) {
            $this->location_dates[] = $location_fields['collection_date'];
        }
        return $this->location_dates;
    }

    public function using_location_times(){
        if(!isset($this->all_locations_optional_data)){
            $this->get_location_data_for_all_stops();
        };
        if(isset($this->all_locations_optional_data[0]['collection_time'])){
            return true;
        };

        return false;
    }

    public function get_location_times(){
        if(!isset($this->all_locations_optional_data)){
            $this->get_location_data_for_all_stops();
        };        
        $this->location_times = [];
        foreach ($this->all_locations_optional_data as $key => $location_fields) {
            $this->location_times[] = $location_fields['collection_time'];
        }
        return $this->location_times;
    }

     public function get_location_data_for_all_stops(){
        $this->journey_order = $this->get_journey_order_from_request_data();
        $this->get_journey_locations_from_request_data();
    }

    public function get_first_collection_date(){
        if(!isset($this->all_locations_optional_data)){
            $this->get_location_data_for_all_stops();
        }; 
        return $this->all_locations_optional_data[0]['collection_date'];
    }
 
    public function get_first_collection_time(){
        if(!isset($this->all_locations_optional_data)){
            $this->get_location_data_for_all_stops();
        };
        return $this->all_locations_optional_data[0]['collection_time'];
    }

    function get_journey_order_from_request_data() {
        // build array of address post field indexes in order of journey_order
        $journey_order = array();
        foreach ($this->post_data as $key => $value) {
            if (strpos($key, 'journey_order')) {
                // key example: address_1_journey_order
                $key_array = explode('_', $key);
                $address_index = $key_array[1];
                $journey_order[$value] = $address_index;
            }
        };
        return $journey_order;
    }


    public function get_journey_locations_from_request_data(){
        $this->all_locations_optional_data = array();
        foreach ($this->journey_order as $key => $address_index) {
            $location_data = $this->get_journey_order_optional_fields($address_index);
            $location_data['address_index'] = $address_index;
            array_push($this->all_locations_optional_data, $location_data);
        }
    }

    private function get_journey_order_optional_fields($idx) {
        $journey_order_optional_fields = array();

        $contact_name_field_name = 'address_' . $idx . '_contact_name';
        $contact_name = $this->get_param(array('name' => $contact_name_field_name, 'optional' => true));
        if (!empty($contact_name)) {
            $journey_order_optional_fields['contact_name'] = $contact_name;
        };

        $contact_phone_field_name = 'address_' . $idx . '_contact_phone';
        $contact_phone = $this->get_param(array('name' => $contact_phone_field_name, 'optional' => true));
        if (!empty($contact_name)) {
            $journey_order_optional_fields['contact_phone'] = $contact_phone;
        };

        $visit_type_field_name = 'address_' . $idx . '_visit_type';
        $visit_type = $this->get_param(array('name' => $visit_type_field_name, 'optional' => true));
        if (!empty($visit_type)) {
            $journey_order_optional_fields['visit_type'] = $visit_type;
        };

        $time_type_field_name = 'address_' . $idx . '_time_type';
        $time_type = $this->get_param(array('name' => $time_type_field_name, 'optional' => true));
        if (!empty($time_type)) {
            $journey_order_optional_fields['time_type'] = $time_type;
        };

        $collection_date_field_name = 'address_' . $idx . '_collection_date';
        if($idx==1){
            $collection_date = $this->get_param(array('name' => 'delivery_date', 'optional' => true));
            if (!empty($collection_date)) {
                $journey_order_optional_fields['collection_date'] = $collection_date;
                $collection_date_time_obj = new \DateTime($collection_date);
            };
            $collection_time = $this->get_param(array('name' => 'delivery_time_submit', 'optional' => true));
            if (!empty($collection_time)) {
                $timeparts = explode(':', $collection_time);
                $collection_date_time_obj->setTime($timeparts[0],$timeparts[1]);
                $journey_order_optional_fields['collection_date'] = $collection_date_time_obj->format('Y-m-d H:i:s');
                $journey_order_optional_fields['collection_time'] = $collection_date_time_obj->format('H:i:s');

            };


        } else {
            $collection_date = $this->get_param(array('name' => $collection_date_field_name, 'optional' => true));
            if (!empty($collection_date)) {
                $journey_order_optional_fields['collection_date'] = $collection_date;
                $collection_date_time_obj = new \DateTime($collection_date);
            };

            $collection_time_field_name = 'address_' . $idx . '_collection_time_submit';
            $collection_time = $this->get_param(array('name' => $collection_time_field_name, 'optional' => true));
            if (!empty($collection_time)) {
                $timeparts = explode(':', $collection_time);
                $collection_date_time_obj->setTime($timeparts[0],$timeparts[1]);
                $journey_order_optional_fields['collection_date'] = $collection_date_time_obj->format('Y-m-d H:i:s');
                $journey_order_optional_fields['collection_time'] = $collection_date_time_obj->format('H:i:s');
            };

        };

       

        return $journey_order_optional_fields;
    }

	public function get_param($options){

        //retrieve a passed parameter from a get or post request and perform basic validation
        $name = $options['name'];
        $val = '';

        //Get parameter from ajax data

        if(isset($this->post_data[$name])){
            $val = $this->post_data[$name];
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

    public function respond($data){
        print_r($data);
    }
}
?>