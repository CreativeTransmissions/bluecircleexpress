<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
class TQ_CustomerRepository  
{  

	public function __construct($config = array()) { 

        $this->debug = true;

    	//Apply passed conifg 
        $defaults = array();

        $this->config = array_merge($defaults,$config);
        $this->cdb = $this->config['cdb']; 
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

    }

    public function save_customer($customer_data = null){
        if(empty($customer_data)){
            trigger_error('save_customer: no customer data', E_USER_ERROR);            
            return false;
        };
     

        $existing_customer = self::get_customer_by_email($customer_data['email']);
        if (empty($existing_customer)) {
            $customer = self::save_customer_record($customer_data);
        } else {
            $customer = self::update_customer($existing_customer, $customer_data);
        };

        return $customer;
    }   

    public function update_customer($existing_customer, $customer_data = null){

        //save against an existing customer id
        //we can pass id and it will not be overwritten as it is not in the post data
        if ($existing_customer['id']) {
            $customer_data['id'] = $existing_customer['id'];
        };
        $customer = self::save_customer_record($customer_data);
        return $customer;
    }

    /* ct sell photo methods below */

  public function register_customer_as_wp_user($record_data) {

        //wp_delete_user( $wp_user_id );
        $first_name = $record_data['first_name'];
        $last_name = $record_data['last_name'];
        $email = $record_data['email'];
    
        $errors = new WP_Error();

        if ( username_exists( $email ) || email_exists( $email ) ) {
            //$errors->add( 'user_error', self::get_error_message( 'email_exists') );
            $userdata = WP_User::get_data_by( 'email', $email );
            return $userdata->ID;
        }

        $role = 'tq_customer';
        // Generate the password so that the subscriber will have to check email...
        $password = wp_generate_password( 12, false );
     
        $user_data = array(
            'user_login'    => $email,
            'user_email'    => $email,
            'user_pass'     => $password,
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'nickname'      => $first_name,
        );
     
        $this->wp_user_id = wp_insert_user( $user_data );

        wp_update_user( array ('ID' => $this->wp_user_id, 'role' => $role ) ) ;
        $creds = array(
            'user_login'    => $email,
            'user_password' => $password,
            'remember'      => true
        );
 
        wp_new_user_notification( $this->wp_user_id, null );
        return $this->wp_user_id;
    }

    public function get_error_message($error){
        return $error;
    }

     public function save_customer_record($record_data = null){
        if(empty($record_data)){
            trigger_error('save_customer_record: empty customer data', E_USER_ERROR); 
        };
        $row_id = $this->cdb->update_row('customers', $record_data);
        if($row_id===false){
            return false;
        };

        $record_data['id'] = $row_id;
        return $record_data;
    }       


    public function get_customer_by_email($email){
        //check for the email address to see if this is a previous customer
        if(empty($email)){
            trigger_error('get_customer_by_email: empty email', E_USER_ERROR); 
            return false;
        };
        //load customer by email
        $customer = $this->cdb->get_row('customers', $email, 'email');
        return $customer;
    }   


    public function get_customer_by_id($id){
        //check for the email address to see if this is a previous customer
        if(empty($id)){
            return false;
        };
        //load customer by email
        $customer = $this->cdb->get_row('customers', $id, 'id');
        return $customer;
    }    

    public function save($table, $idx = null, $defaults = null){
        // me
        if(empty($table)){
            return false;
        };
        //get param data
        $request_parser = new CT_HTTP_Request_Parser(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));
        $customer_fields = $this->cdb->get_table_col_names('customers');        
        $record_data = $request_parser->get_record_from_post_data($customer_fields);
        
        if(!empty($defaults)){
            //merge with passed data
            $record_data = array_merge($defaults, $record_data);
        };
        $row_id = $this->cdb->update_row('customers', $record_data);
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