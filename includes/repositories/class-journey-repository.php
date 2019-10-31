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

        $this->journey_id = $record_data['id'] = $row_id;
        return $record_data;              
    }

    public function load_journey($journey_id){
     
    }   

    public function save_journey_stages(){

    }

    public function save_journey_stage($id){
      
    }  

    public function save_journey_legs($legs = null){

        if(empty($legs)){
            return false;
        };

        $this->legs = $legs;
        
        $stageIdx = 0;
        $this->current_leg_type = $this->get_first_leg_type();

        $stage_data = $this->create_stage_record($stageIdx);
        $this->current_stage = $this->save_journey_stage($stage_data);

        foreach ($this->legs as $key => $leg) {
            $leg_data = $this->create_leg_record($leg); 
            $leg_data = $this->save_journey_leg($leg);
            if($leg_data['leg_type'] != $this->current_leg_type){
                ++$stageIdx;
                $stage_data = $this->create_stage_record($stageIdx);
                $this->current_stage = $this->save_journey_stage($stage_data);
            }
        }
    }

    public function get_first_leg_type(){
        return $this->legs[0]['leg_type'];
    }

    public function create_stage_record($stageIdx){
        $stage_data = array('journey_id'=>$this->journey_id,'stage_order'=>$stageIdx);
        return $stage_data;
    }

    public function save_journey_stage($stage_data = null){
        if(empty($stage_data)){
            echo ' stage_data record is empty';
        };
        $row_id = $this->cdb->update_row('stages', $stage_data);
        if($row_id===false){
            return false;
        };

        $this->stage_id = $record_data['id'] = $row_id;
        return $record_data;
    }

    public function save_journey_leg($leg_data = null){
        if(empty($leg_data)){
            echo ' leg_data record is empty';
        };
        $row_id = $this->cdb->update_row('legs', $leg_data);
        if($row_id===false){
            return false;
        };

        $this->leg_id = $record_data['id'] = $row_id;
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