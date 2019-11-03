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
        $this->ajax = new WP_Sell_Software\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

    }


    public function get_error_message($error){
        return $error;
    }

    public function save($record_data = null){
        if(empty($record_data)){
            echo ' qutoe record is empty';
        };
        $row_id = $this->cdb->update_row('quotes', $record_data);
        if($row_id===false){
            return false;
        };

        $this->quote_id = $record_data['id'] = $row_id;
        return $record_data;              
    }

    public function save_quote_stages($email){
    
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