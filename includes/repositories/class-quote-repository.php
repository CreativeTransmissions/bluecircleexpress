<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
class TQ_QuoteRepository  
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

    public function create_quote_rec($quote){
     /*   echo ' **** create_quote_rec: ';
        echo json_encode($quote);
        {"basic_cost":1098.5,"tax_cost":"0.00","total":"1098.50","distance_cost_total":1098.5,"stage_data":[{"distance":467.448,"hours":5.216666666666667,"quote":{"total":"1098.50","total_before_rounding":1098.5028,"distance":467.448,"distance_cost_before_rounding":1098.5028,"distance_cost":"1098.50","outward_distance":467.448,"return_distance":0,"outward_cost":1098.5028,"return_cost":0,"basic_cost":"1098.50","stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":467.448,"distance_cost":1098.5028,"type":"per distance unit","rate":"2.35","cost":1098.5028},{"distance":0,"distance_cost":1098.5028,"type":"per distance unit","rate":"2.35","return_percentage":100,"cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":0,"tax_cost":0}}],"job_rate":"standard","rates":[{"distance":467.448,"hours":5.216666666666667,"quote":{"total":"1098.50","total_before_rounding":1098.5028,"distance":467.448,"distance_cost_before_rounding":1098.5028,"distance_cost":"1098.50","outward_distance":467.448,"return_distance":0,"outward_cost":1098.5028,"return_cost":0,"basic_cost":"1098.50","stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":467.448,"distance_cost":1098.5028,"type":"per distance unit","rate":"2.35","cost":1098.5028},{"distance":0,"distance_cost":1098.5028,"type":"per distance unit","rate":"2.35","return_percentage":100,"cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":0,"tax_cost":0}}],"weight_cost":0,"area_surcharges_cost":0,"tax_name":"","tax_rate":"0","subtotal":"1098.50","total_cost":1098.5}*/
        $quote_rec = array('total'=>$quote['total'],
                            'basic_cost'=>$quote['basic_cost'],
                            'distance_cost'=>$quote['distance_cost'],
                            'time_cost'=>$quote['time_cost'],
                            ///'notice_cost'=>$quote['notice_cost'],
                            'tax_cost'=>$quote['tax_cost']
                           // 'rates'=>$quote['rates']
                        );

        if(isset($quote['breakdown'])){
            $quote_rec['breakdown'] =json_encode($quote['breakdown']);
        };
        return $quote_rec;
    }
    public function save($record_data = null){
        if(empty($record_data)){
            echo ' qutoe record is empty';
        };

        $record_data = $this->create_quote_rec($record_data);
        if(empty($record_data)){
            trigger_error('save quote: record_data empty', E_USER_ERROR);            
        };
        $row_id = $this->cdb->update_row('quotes', $record_data);
        if($row_id===false){
            return false;
        };

        $this->quote_id = $record_data['id'] = $row_id;
        return $record_data;              
    }


    public function save_quote_stages($stage_data){

     //   echo ' UPDATED save_quote_stages: ';
       //s echo json_encode($stage_data);

        if(!is_numeric($this->quote_id)){
            trigger_error('save_quote_stages: cannot save until quote has been saved', E_USER_ERROR);
            return false;      
        };

        if(empty($this->quote_id)){
            trigger_error('save_quote_stages empty: cannot save until quote has been saved', E_USER_ERROR);
            return false;      
        };        
        $saved_stage_ids = [];
        foreach ($stage_data as $key => $stage) {
            $quotes_stages_rec = $this->create_quotes_stages_rec($stage);
            $quote_stage_rec = $this->save_quote_stage($quotes_stages_rec);
            $saved_stage_ids[] = $quote_stage_rec['id'];
        };
        return $saved_stage_ids;
    }  

    public function create_quotes_stages_rec($stage_data){
        
        $quote_stage_rec = array('stage_id'=>$stage_data['id'],
                                'journey_id'=>$stage_data['journey_id'],
                                'quote_id'=>$this->quote_id,
                                'unit_cost'=>$stage_data['quote']['distance_cost'],
                                'time_cost'=>$stage_data['quote']['time_cost'],
                                'stage_total'=>$stage_data['quote']['basic_cost'],
                                'rates'=>$stage_data['leg_type_id']
                            );
        return $quote_stage_rec;
    }

    public function save_quote_stage($record_data){
        if(empty($record_data)){
            trigger_error('save_quote_stage: record_data empty', E_USER_ERROR); 
            return false;      
        };
        $record_data['created'] = date('Y-m-d G:i:s');
        $record_data['modified'] = $record_data['created'];
        $row_id = $this->cdb->update_row('quotes_stages', $record_data);
        if($row_id===false){
            return false;
        };

        $record_data['id'] = $row_id;
        return $record_data;              
    }    

    public function save_quote_surcharges($surcharges){
        if(!is_numeric($this->quote_id)){
            trigger_error('save_quote_surcharges: cannot save until quote has been saved', E_USER_ERROR);
            return false;      
        };
        if(empty($this->quote_id)){
            trigger_error('save_quote_surcharges empty: cannot save until quote has been saved', E_USER_ERROR);
            return false;      
        };
        if($this->quote_id == 0){
            trigger_error('quote id is 0: cannot save until quote has been saved', E_USER_ERROR);
            return false;      
        };     
        $saved_surcharge_ids = [];
        foreach ($surcharges as $key => $surcharge) {
            $quotes_surcharges_rec = $this->create_quotes_surcharges_rec($surcharge);
            $quote_surcharge_rec = $this->save_quote_surcharge($quotes_surcharges_rec);
            $saved_surcharge_ids[] = $quote_surcharge_rec['id'];
        };
        return $saved_surcharge_ids;
    }

    public function create_quotes_surcharges_rec($surcharge){
        return array('quote_id'=>$this->quote_id,
                    'surcharge_id'=>$surcharge['surcharge_id'],
                    'amount'=>$surcharge['amount']);
    }

    public function save_quote_surcharge($record_data){
        if(empty($record_data)){
            trigger_error('save_quote_surcharge: record_data empty', E_USER_ERROR);            
        };
        if(empty($record_data['quote_id'])){
            trigger_error('save_quote_surcharge: quote_id empty', E_USER_ERROR);            
        };        
        $record_data['created'] = date('Y-m-d G:i:s');
        $record_data['modified'] = $record_data['created'];
        $row_id = $this->cdb->update_row('quote_surcharges', $record_data);
        if($row_id===false){
            return false;
        };

        $record_data['id'] = $row_id;
        return $record_data;              
    }

    public function load($quote_id = null){
        if(empty($quote_id)){
            return false;          
        }; 
        $quote = $this->cdb->get_row('quotes', $quote_id);
        if ($quote === false) {
            echo 'Could not load quote rec from database: '.$quote_id;
            echo $this->cdb->last_query;
            return false;
        };
        $quote['stages'] = $this->load_quote_stages($quote_id);
        $quote['surcharges'] = $this->load_quote_surcharges($quote_id);

        return $quote; 
    }    

    public function load_quote_stages($quote_id = null){
        if(empty($quote_id)){
            echo 'load_quote_stages: not quote_id';
            return false;          
        }; 

        $quotes_stages_table_name = $this->cdb->get_table_full_name('quotes_stages');
        $stages_table_name = $this->cdb->get_table_full_name('stages');

        $sql = 'SELECT quote_id, qs.journey_id, stage_order, stage_id, unit_cost, time_cost, set_cost, stage_total, rates
                    FROM '.$quotes_stages_table_name.' qs
                        inner join '.$stages_table_name.' s
                            on qs.stage_id = s.id
                    where quote_id = '.$quote_id.' 
                order by stage_order';

        $quotes_stages = $this->cdb->query($sql);
        if (!is_array($quotes_stages)) {
            echo 'Could not load quotes_stages: '.$quote_id;
            return false;
        };
        if (empty($quotes_stages)) {
            echo 'Quote has no stages: '.$quote_id;
            var_dump($quotes_stages);
            echo $this->cdb->last_query;
            return false;            
        };        
        return $quotes_stages; 
    }

    public function load_quote_surcharges($quote_id = null){
        if(empty($quote_id)){
            return false;          
        }; 

        $quote_surcharges_table_name = $this->cdb->get_table_full_name('quote_surcharges');
        $surcharges_table_name = $this->cdb->get_table_full_name('surcharges');        

        $sql = 'SELECT quote_id, s.name, surcharge_id, qs.amount 
                    FROM '.$quote_surcharges_table_name.' qs 
                    inner join '.$surcharges_table_name.' s 
                        on qs.surcharge_id = s.id 
                    where quote_id = '.$quote_id;

        $quotes_surcharges = $this->cdb->query($sql);
        if (!is_array($quotes_surcharges)) {
            //echo 'Could not load quotes_surcharges: '.$quote_id;
            return false;            
        };
        if (empty($quotes_surcharges)) {
            //echo 'Quote has no surcharges: '.$quote_id;
            return false;
        };        
        return $quotes_surcharges; 
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