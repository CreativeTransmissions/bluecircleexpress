<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
class TQ_LocationRepository  
{  

	public function __construct($config = array()) { 

        $this->debug = true;

    	//Apply passed conifg 
        $defaults = array();

        $this->config = array_merge($defaults,$config);
        $this->cdb = $this->config['cdb']; 

    }

    public function save($locations, $journey_order){
        $this->locations = $locations;
        $this->journey_order = $journey_order;        
        if(!$this->has_required_params()){
            echo 'cannot save without required params';
            return false;
        };
        return $this->save_locations;
    }

    public function get_save_locations(){
        return $this->saved_locations_in_order;
    }

    public function has_required_params(){
        if (empty($this->locations)) {
            echo 'TQ_LocationRepository: no locations records to save';            
            return false;
        };
      
        if (empty($this->config['journey_order'])) {
            echo 'TQ_LocationRepository: no journey_order array';            
            return false;
        };
        $this->journey_order = $this->config['journey_order'];
        return true; 
    }

    public function get_error_message($error){
        return $error;
    }

     public function save_locations() {
        // save all locations in journey
        $this->saved_locations_in_order = array();
        foreach ($this->journey_order as $key => $address_index) {
            $location_data = $this->locations[$this->journey_order[$address_index]];
            if (empty($location)) {
                self::debug('No data for location at index: ' . $address_index);
                return false;
            };
            $location = $this->save_location($location);
            if(!is_array($location)){
                echo 'could not save location record:';
                var_dump($location);
                return false;
            };
            // store ids in array ready for save
            $this->saved_locations_in_order[$key] = $location;
        };
        return true;
    }

    private function save_location($record_data) {
        if (empty($record_data['lat']) || empty($record_data['lng']) || empty($record_data['address'])) {
            return false;
        };
        $location_id = self::get_location_by_address($record_data);
        if (empty($location_id)) {
            //no match, create new location in database
            $location_id = self::save_location_record($record_data);
            if (empty($location_id)) {
                return false;
            };
            // add new id to array of location details
            $location['id'] = $location_id;
        } else {

            //existing location
            $location = $this->cdb->get_row('locations', $location_id);
        };

        if (empty($location)) {
            return false;
        };

        return $location;
    }

    public function save_location_record($idx = null, $record_data = null){
        if(empty($record_data)){
            echo ' location record is empty';
        };
        $row_id = $this->cdb->update_row('locations', $record_data);
        if($row_id===false){
            return false;
        };

        $record_data['id'] = $row_id;
        return $record_data;
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