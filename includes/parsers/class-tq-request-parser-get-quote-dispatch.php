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
class TQ_RequestParserGetQuoteDispatch {

 	private $default_config = array();  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
        $this->post_data = $this->config['post_data'];
	}

    public function get_all_locations_record_data(){
        if(!isset($this->journey_order)){
            $this->journey_order = $this->get_journey_order_from_request_data();
        };
        $locations_in_journey_order = [];
        foreach ($this->journey_order as $key => $address_index) {
            $location = $this->get_record_data_location($address_index);
            if (empty($location)) {
                echo 'location data misssing for address index: ' . $address_index;
                return false;
            };
           
         
            // store ids in array ready for save
            $locations_in_journey_order[$key] = $location;
        };
        return $locations_in_journey_order;
    }    

    public function get_record_data_journeys_locations($saved_locations){
        if(!isset($this->journey_order)){
            $this->journey_order = $this->get_journey_order_from_request_data();
        };

        $record_data_journeys_locations = array();

        foreach ($this->journey_order as $key => $address_index) {
            $location = $this->get_record_data_location($address_index);
            if (empty($location)) {
                self::debug('location data misssing for address index: ' . $address_index);
                return false;
            };
           
            $journey_order_rec = array(
                'location_id'=>$saved_locations[$key]['id'],
                'journey_order' => $key,
                'created' => date('Y-m-d G:i:s'),
                'modified' => date('Y-m-d G:i:s'));

            $journey_order_optional_fields = self::get_journey_order_optional_fields($key);
            $journey_order_rec = array_merge($journey_order_rec, $journey_order_optional_fields);

            // store ids in array ready for save
            $record_data_journeys_locations[] = $journey_order_rec;
        };
        return $record_data_journeys_locations;
    }    


    public function get_record_data_location($idx){
        $fields = $this->config['location_fields'];
        $record_data = $this->get_record_data_by_index($idx, $fields);
        return $record_data;
    }

    

    public function get_record_data_journey(){
        $record_data = array('distance'=>$this->get_journey_distance(),
                             'time'=>$this->get_journey_duration_hours()
                         );
        return $record_data;
    }

    public function get_record_data($fields){

        //init the record array
        $record_data = array();

        //get parameters
        foreach ($fields as $key => $field) {
            switch ($field) {
            case 'created':
            case 'modified':
                $record_data[$field] = date('Y-m-d G:i:s');
                break;
            default:
                $val = $this->get_param(array('name' => $param_name, 'optional' => true));
                if(empty($val)) {
                    $record_data[$field] = '';
                } else {
                    $record_data[$field] = sanitize_text_field($val);
                };
                if (strrpos($field, '_date') > -1) {
                    $record_data[$field] = $this->cdb->mysql_date($record_data[$field]);
                };
            };
        };

        return $record_data;
    }    

    public function get_record_data_by_index($idx, $fields){
        $idx_str = '_' . $idx;
        //init the record array
        $record_data = array();

        //get parameters
        foreach ($fields as $key => $field) {
            switch ($field) {
            case 'created':
            case 'modified':
                $record_data[$field] = date('Y-m-d G:i:s');
                break;
            case 'id':
            break;
            default:
                $param_name = 'address' . $idx_str . '_' . $field;
                $val = $this->get_param(array('name' => $param_name, 'optional' => true));
                if (empty($val)) {
                    $record_data[$field] = '';
                } else {
                    $record_data[$field] = sanitize_text_field($val);
                };
                if (strrpos($field, '_date') > -1) {
                    $record_data[$field] = $this->cdb->mysql_date($record_data[$field]);
                };
            };
        };

        return $record_data;
    }    

	public function parse_legs(){
        $decoded_legs = stripslashes($this->post_data['directions']);
        $this->legs = json_decode($decoded_legs, true);
	}

    public function get_journey_data(){

        //get data for whole journey and each leg

        $this->parse_legs();
        $legs = $this->get_leg_data();
        $this->journey_data = [];

        $journey = [];
        $journey['distance'] = $this->get_journey_distance();
        $journey['duration'] = $this->get_journey_duration_hours();
        $journey['deliver_and_return'] = $this->get_deliver_and_return();
        $journey['optimize_route'] = $this->get_optimize_route();

        $this->journey_data['journey'] = $journey;
        $this->journey_data['legs'] = $legs;

        return $this->journey_data;
    }

    public function get_leg_data(){
        //return array of stages with data (delivery distance can be multiple legs)
        /* 
        - leg_type
        - distance
        - hours
        */

        $this->leg_data = array();
        $this->stage_data = array();
        $this->journey_distance = 0;
        $this->journey_duration = 0;

        if(!isset($this->legs)){
            $this->parse_legs();
        };
       // echo 'looping through: '.count($this->legs).' legs.';
        // first stage     
        foreach ($this->legs as $key => $leg) {

            $leg_data = array();
            $leg_data['distance'] = $this->get_leg_distance($key, $this->config['distance_unit']);
            $leg_data['time'] =  $this->get_leg_duration_hours($key);
            $leg_data['leg_order'] =  $key;
            $leg_data['leg_type_id'] = $this->get_leg_type_id($key);
            $leg_data['leg_type'] = $this->get_leg_type($key);
            $leg_data['directions_response'] = json_encode($leg);
            $this->leg_data[] = $leg_data;
        };
        return $this->leg_data;
    }

    public function get_stage_data($legIdx = null){
        //return array of stages with data (delivery distance can be multiple legs)
        /* 
        - leg_type
        - distance
        - hours
        */


        if(!isset($this->legs)){
            $this->parse_legs();
        };

        $legs = $this->get_leg_data();
        echo 'legs to pars: '.count($legs);
        var_dump($legs);
        foreach ($legs as $key => $leg) {
            echo 'leg idx: '.$key.' = type: '.$leg['leg_type_id'].PHP_EOL;
            switch ($leg['leg_type_id']) {
                case 1: // dispatch
                    $this->stage_data = array();
                    $stage_data['leg_type'] = $this->get_leg_type($key);
                    $stage_data['distance'] = $this->get_leg_distance($key, $this->config['distance_unit']);
                    $stage_data['hours'] = $this->get_leg_duration_hours($key); 
                    // echo ' -- dispatch leg type: '.$stage_data['leg_type'];

                    $this->stage_data[] = $stage_data;   
                    echo '** added dispatch at index '.$key;
                 
                    break;
                case 2: // standard

                    if($legs[$key-1]!=2){
                        //echo '** started standard at index '.$key;                        
                        //start stage totals at 0 as standard stage can have multiple stops
                        //reset values
                        $stage_data = array('distance'=>0,'hours'=>0);   
                        $stage_data['leg_type'] = $this->get_leg_type($key);
                    };
                    // echo '** added to standard dispatch at index '.$key;                        

                    // add leg data to stage totals
                    $stage_data['distance'] = $stage_data['distance'] + $this->get_leg_distance($key, $this->config['distance_unit']);
                    $stage_data['hours'] = $stage_data['hours'] + $this->get_leg_duration_hours($key);                  
                    break;
                default:
                    trigger_error('unrecognised: leg_type_id '.$this->get_leg_type_id($key), E_USER_WARNING);            
                    break;
            };
        };
        $this->stage_data[] = $stage_data;

        return $this->stage_data;
    }

    public function is_dispatch_leg($legIdx){
        if($this->using_dispatch_rates()){
            if((int)$legIdx===0){ // start a new stage until leg index 2. 0 is for dispatch, 1 begins delivery stage
                return true;
            };
        };
        return false;
    }

    public function is_return_leg($legIdx){
        if($this->using_return_to_base_rates()){
            if((int)$legIdx===(count($this->legs)-1)){ // start a new stage until leg index 2. 0 is for dispatch, 1 begins delivery stage
                return true;
            };
        };
        return false;
    }

    public function leg_starts_new_stage($legIdx){
        if($this->using_dispatch_rates()){
            if((int)$legIdx===1){ // start a new stage until leg index 2. 0 is for dispatch, 1 begins delivery stage
                return true;
            };
        };
        return false;
    }

    public function get_leg_type($legIdx){
        if($legIdx === 0 ){
            return 'dispatch';
        };
      
        if($legIdx > 0){
            return 'standard';
        };
        return false;
    }

    public function get_leg_type_id($legIdx){
        // 1 = standard, 2 = dispatch, 3 = return to collection, 4 = return to base
        if($legIdx === 0 ){
            return 1;
        };
      
        if($legIdx > 0){
            return 2;
        };
        return false;
    }

    public function using_dispatch_rates(){
        return $this->config['use_dispatch_rates'];
    }

    public function using_return_to_base_rates(){
        return $this->config['use_return_to_base_rates'];
    }    

    public function leg_count(){
        if(!isset($this->legs)){
            $this->parse_legs();
        };

        return count($this->legs);
    }

    public function get_leg($legIdx = null){
        if(!is_numeric($legIdx)){
            echo 'non-numeric leg';
            return false;
        };

        if(!isset($this->legs)){
            $this->parse_legs();
        };

        if(isset($this->legs[$legIdx])){
            return $this->legs[$legIdx];
        } else {
           // trigger_error('get_leg: leg '.$legIdx.'not set', E_USER_WARNING);            

    //print_r($this->legs);
        };
        return false;
    }

    public function get_leg_distance($legIdx = null, $distance_unit = 'Kilometer'){
        $leg_distance = false;

        if(!is_numeric($legIdx)){
            echo 'get_leg_distance: non-numeric legIdx';                        
            return false;
        };

        if(!isset($this->legs)){
            $this->parse_legs();
        };

        
        switch ($distance_unit) {
            case 'Kilometer':
                $leg_distance = $this->get_leg_distance_kilometers($legIdx);
                break;
              case 'Mile':
                $leg_distance = $this->get_leg_distance_miles($legIdx);
                break;
            default:
                echo 'invalid distance_unit: '.$distance_unit;
                break;
        };
       
        return $leg_distance;
    }

    public function get_leg_distance_kilometers($legIdx = null){
        if(!is_numeric($legIdx)){
            echo 'get_leg_distance: non-numeric leg';                        
            return false;
        };
        $leg_meters = $this->get_leg_distance_meters($legIdx);
        if(!is_numeric($leg_meters)){
            trigger_error('get_leg_distance_kilometers: non-numeric leg_meters', E_USER_WARNING);            
            return false;
        };
        
        $leg_km = $leg_meters / 1000;
        return  $leg_km;
        
    }

    public function get_leg_distance_meters($legIdx = null){
        if(!is_numeric($legIdx)){
            echo 'get_leg_distance_meters: non-numeric leg';                        
            return false;
        };

        $leg = $this->get_leg($legIdx);
        if(!is_array($leg)){
            trigger_error('get_leg_distance_meters: non-numeric leg', E_USER_WARNING);            
            return false;
        };

        if(!is_array($leg['distance'])){
            trigger_error('get_leg_distance_meters: leg '.$legIdx.' distance is not array', E_USER_WARNING);            

            return false;
        };
        return $leg['distance']['value'];


    }

    public function get_leg_distance_miles($legIdx = null){
        if(!is_numeric($legIdx)){
            return false;
        };
        $leg_km = $this->get_leg_distance_kilometers($legIdx);
        if(!is_numeric($leg_km)){
            return false;
        };
        $leg_miles = $leg_km / 1.609;
        return $leg_miles;
    }

    public function get_leg_distance_text($legIdx = null){
        if(!is_numeric($legIdx)){
            echo 'get_leg_distance_text: non-numeric leg';                        
            return false;
        };

        $leg = $this->get_leg($legIdx);
        if(!is_array($leg)){
            trigger_error('get_leg_distance_text: non-numeric leg', E_USER_WARNING);            
            return false;
        };

        if(!is_array($leg['distance'])){
            trigger_error('get_leg_distance_text: leg '.$legIdx.' distance is not array', E_USER_WARNING);            

            return false;
        };
        return $leg['distance']['text'];
    }

    public function get_leg_duration($legIdx = null){ // seconds
        if(!is_numeric($legIdx)){
            echo 'get_leg_duration: non-numeric leg';                        
            return false;
        };

        $leg = $this->get_leg($legIdx);
        if(!is_array($leg)){
            trigger_error('get_leg_duration: non-numeric leg', E_USER_WARNING);            
            return false;
        };

        if(!is_array($leg['duration'])){
            trigger_error('get_leg_duration: leg '.$legIdx.' duration is not array', E_USER_WARNING);            

            return false;
        };
        return $leg['duration']['value'];
    }

    public function get_leg_duration_hours($legIdx = null){
        $duration = $this->get_leg_duration($legIdx);
        if(is_numeric($duration)){
           return $duration / 3600;
        } else {
            return false;
        }
    }    

    public function get_journey_distance(){
        $distance_unit = $this->config['distance_unit'];
        $journey_distance = false;
        if($distance_unit==='Kilometer'){
            $journey_distance = $this->get_journey_distance_kilometers();
        } elseif ($distance_unit==='Mile') {
            $journey_distance = $this->get_journey_distance_miles();
        };
        return $journey_distance;
    }

    public function get_journey_distance_miles(){
        if(!isset($this->legs)){
            $this->parse_legs();
        };

        if(!is_array($this->legs)) {
            echo ' no legs';
            return false;
        };
        $total_miles = 0;
        foreach ($this->legs as $key => $leg) {
            $total_miles = $total_miles + $this->get_leg_distance_miles($key);
        };

        return $total_miles;
    }

    public function get_journey_distance_kilometers(){
        if(!isset($this->legs)){
            $this->parse_legs();
        };

        if(!is_array($this->legs)){
            echo ' no legs';
var_dump($this->legs);
            return false;
        };

        $total_km = 0;
        foreach ($this->legs as $key => $leg) {
            $total_km = $total_km + $this->get_leg_distance_kilometers($key);
        };
        
        return $total_km;
    }    

    public function get_journey_duration(){
        if(!isset($this->journey_duration)){
            $this->get_leg_data();
        };
        return $this->journey_duration;
    }

    public function get_journey_duration_hours(){
        $duration = $this->get_journey_duration();
        if(is_numeric($duration)){
           return $duration / 3600;
        } else {
            return false;
        }
    }

    public function get_surcharge_ids(){
        $surcharge_id_string = $this->get_param(array('name' => 'surcharge_areas', 'optional' => true));
        $surcharge_ids = explode(',', $surcharge_id_string);
        return $surcharge_ids;
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

        $leg_type = $this->get_param(array('name' => 'leg_type', 'optional' => true));
        if (empty($leg_type)) {
            $leg_type = 'standard';
        };

        $weight = $this->get_param(array('name' => 'weight', 'optional' => true));
        if (empty($weight)) {
            $weight = 0;
        };

        $surcharge_ids = $this->get_surcharge_ids();

        $delivery_date = false;
        $date_list = array();
        if($this->using_location_dates()){
            $date_list = $this->get_location_dates();
        } else {
            // whole job delivery date /time
            $delivery_date = $this->get_param(array('name' => 'delivery_date', 'optional' => true));
            if (!empty($delivery_date)) {
                $delivery_date_time_obj = new \DateTime($delivery_date);
            };
            $date_list = array($delivery_date);
        };

        $delivery_time = false;
        $time_list = array();
        if($this->using_location_times()){
            $time_list = $this->get_location_times();
        } else {
            $delivery_time = $this->get_param(array('name' => 'delivery_time_submit', 'optional' => true));
            if (!empty($delivery_time)) {
              //  echo ' ** EMPY delivery_time';
                $time_list = array($delivery_time);
            };            
            
        };        

        return array(
            'leg_type'=>$leg_type,
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

    public function get_deliver_and_return(){
        $deliver_and_return = $this->get_param(array('name' => 'deliver_and_return', 'optional' => true));
        if (empty($deliver_and_return)) {
            $deliver_and_return = 0;
        };
        return $deliver_and_return;
    }

    public function get_optimize_route(){
        $optimize_route = $this->get_param(array('name' => 'optimize_route', 'optional' => true));
        if (empty($optimize_route)) {
            $optimize_route = 0;
        };
        return $optimize_route;
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