<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
        $quote_rec = array('total'=>$quote['total'],
                            'basic_cost'=>$quote['basic_cost'],
                            'distance_cost'=>$quote['distance_cost'],
                            'time_cost'=>$quote['time_cost'],
                            ///'notice_cost'=>$quote['notice_cost'],
                            'tax_cost'=>$quote['tax_cost'],
                            'breakdown'=>json_encode($quote['breakdown'])
                           // 'rates'=>$quote['rates']
                        );
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
    
    }  

    public function save_quote_surcharges($surcharges){
        if(!is_numeric($this->quote_id)){
            trigger_error('save_quote_surcharges: cannot save until quote has been saved', E_USER_ERROR);
            return false;      
        };
        $saved_surcharge_ids = [];
        foreach ($surcharges as $key => $surcharge) {
            $quotes_surcharges_rec = $this->create_quotes_surcharges_rec($surcharge);
            $quote_surcharge_rec = $this->save_quote_surcharge($surcharge);
            $saved_surcharge_ids[] = $quote_surcharge_rec['id'];
        };
        return $saved_surcharge_ids;
    }

    public function create_quotes_surcharges_rec($surcharge){
        return array('quote_id'=>$this->quote_id,
                    'surcharge_id'=>$surcharge['surcharge_id'],
                    'amount'=>$surcharge['surcharge_id']);
    }

    public function save_quote_surcharge($record_data){
        if(empty($record_data)){
            trigger_error('save_quote_surcharge: record_data empty', E_USER_ERROR);            
        };
        $record_data['created'] = date('Y-m-d G:i:s');
        $record_data['modified'] = $record_data['created'];
        $row_id = $this->cdb->update_row('quote_surcharges', $record_data);
        if($row_id===false){
            return false;
        };

        $this->quote_id = $record_data['id'] = $row_id;
        return $record_data;              
    }

    public function load_quote($quote_id){
       
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