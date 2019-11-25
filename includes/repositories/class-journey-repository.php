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

    public function save_journey_legs($journey_id, $legs = null){
        if(!$this->save_journey_legs_get_params($journey_id, $legs)){
            return false;
        };
        
        $this->leg_recs = array();
        $this->stage_recs = array();        
        $stageIdx = 0;
        $this->current_leg_type = $this->get_first_leg_type();

        $stage_data = $this->create_stage_record($stageIdx);
        $this->current_stage = $this->save_journey_stage($stage_data);
        $this->current_stage['leg_type_id'] = $this->current_leg_type; // add leg_type_id to be stored against stage
        $this->stage_recs[] = $this->current_stage;
        foreach ($this->legs as $key => $leg) {
            $leg_data = $this->create_leg_record($key, $leg); 
            $leg_data = $this->save_journey_leg($leg_data);
            $this->leg_recs[] = $leg_data;
            if($leg_data['leg_type_id'] != $this->current_leg_type){
                ++$stageIdx;
                $stage_data = $this->create_stage_record($stageIdx);
                $this->current_stage = $this->save_journey_stage($stage_data);
                $this->current_stage['leg_type_id'] = $leg_data['leg_type_id']; // add leg_type_id to be stored against stage
                $this->stage_recs[] = $this->current_stage;
                $this->current_leg_type = $leg_data['leg_type_id'];
            }
        }
    }

    public function save_journey_legs_get_params($journey_id = null, $legs = null){
        if(!is_array($legs)){
            trigger_error('save_journey_legs_get_params: legs not array ', E_USER_ERROR);        
            return false;
        };

        if(empty($legs)){
            trigger_error('save_journey_legs_get_params: legs empty', E_USER_ERROR);
            return false;
        };

        $this->legs = $legs;

        if(!is_numeric($journey_id)){
            trigger_error('save_journey_legs_get_params: journey_id not numeric', E_USER_ERROR);        

            return false;            
        };

        if(empty($journey_id)){
            trigger_error('save_journey_legs_get_params: journey_id empty', E_USER_ERROR);        

            return false;
        };

        $this->journey_id = $journey_id;

        return true;

    }
    public function get_first_leg_type(){
        return $this->legs[0]['leg_type_id'];
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

        $this->stage_id = $stage_data['id'] = $row_id;
        return $stage_data;
    }

    public function create_leg_record($key, $leg){
        $leg_data = array(  'directions_response'=>$leg['directions_response'],
                            'distance'=>$leg['distance'],
                            'time'=>$leg['distance'],
                            'stage_id'=>$this->current_stage['id'],
                            'leg_order'=>$key,
                            'leg_type_id'=>$leg['leg_type_id']);
    
        return $leg_data;
    }

    public function save_journey_leg($leg_data = null){
        if(empty($leg_data)){
            echo ' leg_data record is empty';
        };

        $row_id = $this->cdb->update_row('legs', $leg_data);
        if($row_id===false){
            return false;
        };

        $this->leg_id = $leg_data['id'] = $row_id;
        return $leg_data;               
    }        

    public function save_journeys_locations($journey_id = null, $journeys_locations_recs = null){
        if(empty($journey_id)){
            trigger_error('save_journeys_locations: journey_id empty ', E_USER_ERROR);        
            return false;
        };

        if(empty($journeys_locations_recs)){
            trigger_error('save_journeys_locations: journey_location_recs empty ', E_USER_ERROR);        
            return false;
        };

        $saved_recs = [];
        foreach ($journeys_locations_recs as $key => $journeys_locations_rec) {
            $journeys_locations_rec['journey_id'] = $journey_id;
            $saved_journey_location_rec = $this->save_journey_location($journeys_locations_rec);
            $saved_recs[] = $saved_journey_location_rec;        
        };
        return $saved_recs;
    }
  
    public function save_journey_location($journeys_locations_rec = null){
        if(empty($journeys_locations_rec)){
            trigger_error('save_journeys_locations: journey_location_rec is empty ', E_USER_ERROR);        
            return false;
        };

        $row_id = $this->cdb->update_row('journeys_locations', $journeys_locations_rec);
        if($row_id===false){
            return false;
        };

        $journeys_locations_rec['id'] = $row_id;
        return $journeys_locations_rec;               
    }

    public function get_journey_stages(){
        return $this->stage_recs;
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