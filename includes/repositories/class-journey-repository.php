<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
class TQ_JourneyRepository  
{  

	public function __construct($config = array()) { 

        $this->debug = true;

    	//Apply passed conifg 
        $defaults = array();

        $this->config = array_merge($defaults,$config);
        $this->cdb = $this->config['cdb']; 

    }

    public function get_error_message($error){
        return $error;
    }

     public function create_journeys_locations() {
        // save all locations in journey
        $this->saved_locations = array();
        foreach ($this->journey_order as $key => $address_index) {
            $location = $this->locations[$this->journey_order[$address_index]];
            if (empty($location)) {
                self::debug('No data for location at index: ' . $address_index);
                return false;
            };
            

            $journey_order_rec = array('journey_id' => $this->journey['id'],
                'location_id' => $location['id'],
                'journey_order' => $key,
                'created' => date('Y-m-d G:i:s'),
                'modified' => date('Y-m-d G:i:s'));

            $journey_order_optional_fields = self::get_journey_order_optional_fields($key);
            $journey_order_rec = array_merge($journey_order_rec, $journey_order_optional_fields);

            // store ids in array ready for save
            $this->saved_locations[$key] = $journey_order_rec;
        };

        return true;

    }    

    public function save($record_data){
        if(empty($record_data)){
            echo ' journey record is empty';
        };
        $row_id = $this->cdb->update_row('journeys', $record_data);
        if($row_id===false){
            return false;
        };

        $record_data['id'] = $row_id;
        return $record_data;              
    }

    public function load_journey($journey_id){
     
    }   


    public function save_journey_legs($id){
      
    }

    public function log($error){
        if($this->debug==true){
            if(is_array($error)){
                echo '<pre>';
                print_r($error);
                echo '</pre>';
            } else {
                echo '<br/>'.$error;
            }
        } else {
            //save error
        }
    }
}
?>