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
        $this->ajax = new WP_Sell_Software\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

    }

    public function get_error_message($error){
        return $error;
    }

    public function save_journey(){
     
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