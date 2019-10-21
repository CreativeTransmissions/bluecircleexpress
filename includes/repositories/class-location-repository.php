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

    public function save($locations){
        $this->locations = $locations;
        $this->location_record_ids = array();
        if(!$this->has_required_params()){
            echo 'cannot save without required params';
            return false;
        };
        $this->save_locations();
        return $this->saved_locations_in_order;
    }

    public function get_saved_locations(){
        return $this->saved_locations_in_order;
    }

    public function has_required_params(){
        if (empty($this->locations)) {
            echo 'TQ_LocationRepository: no locations records to save';            
            return false;
        };
      
     /*   if (empty($this->config['journey_order'])) {
            echo 'TQ_LocationRepository: no journey_order array';            
            return false;
        };
        $this->journey_order = $this->config['journey_order'];*/
        return true; 
    }

    public function get_error_message($error){
        return $error;
    }

     public function save_locations() {
        // save all locations in journey
        $this->saved_locations_in_order = array();
        foreach ($this->locations as $key => $location_data) {
           
            $location = $this->save_location($location_data);
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
        // saves or updates is the same address / lat /lng exists
        if (empty($record_data['lat']) || empty($record_data['lng']) || empty($record_data['address'])) {
            return false;
        };
        $location_id = self::get_location_by_address($record_data);
        if (empty($location_id)) {
            //no match, create new location in database
            $location = self::save_location_record($record_data);
            if (!is_array($location)) {
                return false;
            };

        } else {

            //existing location
            $location = $this->cdb->get_row('locations', $location_id);
        };

        if (empty($location)) {
            return false;
        };

        return $location;
    }

    private function get_location_by_address($record_data) {
        //check for an existing location by its address and lat lng coordinates
        if (empty($record_data['lat'])) {
            return false;
        };
        if (empty($record_data['lng'])) {
            return false;
        };

        $lat = round($record_data['lat'] / 10, 7) * 10;
        $lng = round($record_data['lng'] / 10, 7) * 10;
        $query = array('address' => $record_data['address'],
            'lat' => $lat,
            'lng' => $lng);
        $location = $this->cdb->get_rows('locations', $query,
            array('id'));

        if (empty($location)) {
            return false;
        };

        return $location[0]['id'];

    }

    public function save_location_record($record_data = null){
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