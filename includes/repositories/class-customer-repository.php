<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
class CT_CustomerRepository  
{  

	public function __construct($config = array()) { 

        $this->debug = true;

    	//Apply passed conifg 
        $defaults = array();

        $this->config = array_merge($defaults,$config);
        $this->cdb = $this->config['cdb']; 
        $this->ajax = new WP_Sell_Software\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

    }

    public function save_customer(){
        //get email for notification
        $email = $this->ajax->param(array('name' => 'email','optional'=>false));
        if(empty($email)){
            return false;
        };

        $wp_user_id = $this->tq_woocommerce_customer->is_logged_in();


        $existing_customer = self::get_customer_by_email($email);
        if ($existing_customer === false) {
            $customer = self::save_new_customer($wp_user_id);
        } else {
            $customer = self::update_customer($existing_customer, $wp_user_id);
        };

        return $customer;
    }   

    public function save_new_customer($wp_user_id = null){
        //save new customer as we have a new email address
        if ($wp_user_id) {
            $customer = self::save('customers', null, array('wp_user_id' => $wp_user_id));
        } else {
            $customer = self::save('customers');
        };
      
        return $customer;
    }

    public function update_customer($existing_customer, $wp_user_id = null){
        if($existing_customer['email']===''){
            return false;
        };
        $customer_post_data = self::get_record_data('customers');
        //save against an existing customer email
        //we can pass id and it will not be overwritten as it is not in the post data
        if ($wp_user_id) {
            $customer_post_data['wp_user_id'] = $wp_user_id;
            $customer_post_data['id'] = $existing_customer['id'];
            $customer = self::save('customers', $existing_customer['id'], $customer_post_data);
        } else {
            $customer_post_data['id'] = $existing_customer['id'];            
            $customer = self::save('customers', $existing_customer['id'], $customer_post_data);
        };
             
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

    public function save_or_update_customer(){
        $customer_email = $this->ajax->param(array('name'=>'email'));
        if(empty($customer_email)){
            return false;
        };

        $this->customer = self::get_customer_by_email($customer_email);
        if($this->customer===false){
            //save new customer as we have a new email address
            $this->customer = self::save('ct_customers');
        } else{
            //save against an existing customer email
            //we can pass id and it will not be overwritten as it is not in the post data
            $this->customer = self::save('ct_customers',null, $this->customer);
        };

        if($this->customer===false){
            return false;
        };           

        if(empty($this->customer['wp_user_id'])){
            $wp_user_id = $this->register_customer_as_wp_user($this->customer);
            // check for errors
            if (!is_numeric($wp_user_id)) { // this will be error object or id
                return false;
            };
            $this->customer = self::save('ct_customers',null, array('id'=>$this->customer['id'],
                                                                    'wp_user_id'=>$wp_user_id));                        

            if($this->customer===false){
                return false;
            };             

        };

        return true;
    }

    public function get_customer_by_email($email){
        //check for the email address to see if this is a previous customer
        if(empty($email)){
            return false;
        };
        //load customer by email
        $customer = $this->cdb->get_row('ct_customers', $email, 'email');
        return $customer;
    }   


    public function get_customer_by_id($id){
        //check for the email address to see if this is a previous customer
        if(empty($id)){
            return false;
        };
        //load customer by email
        $customer = $this->cdb->get_row('ct_customers', $id, 'id');
        return $customer;
    }    

    public function save($table, $idx = null, $defaults = null){
        // me
        if(empty($table)){
            return false;
        };
        //get param data
        $request_parser = new CT_HTTP_Request_Parser(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));
        $customer_fields = $this->cdb->get_table_col_names('ct_customers');        
        $record_data = $request_parser->get_record_from_post_data($customer_fields);
        
        if(!empty($defaults)){
            //merge with passed data
            $record_data = array_merge($defaults, $record_data);
        };
        $row_id = $this->cdb->update_row('ct_customers', $record_data);
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