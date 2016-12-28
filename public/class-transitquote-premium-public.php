<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/public 
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/public
 * @author     Your Name <email@example.com>
 */
class TransitQuote_Premium_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	private $plugin_slug;
	private $vendor_id;
    private $tab_1_settings_key = 'premium_rates';
	private $tab_2_settings_key = 'premium_quote_options';
	private $tab_5_settings_key = 'email_options';
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_slug ) {
		$this->plugin_name = $plugin_name;
		$this->plugin_slug = $plugin_slug;
		$this->version = $version;
		$this->debug = true;
		$this->log_requests = true;
		$this->vendor_id = 10759;
	}

	public function load_settings() {		
	 	$this->{$this->tab_1_settings_key} = (array) get_option( $this->tab_1_settings_key);
	   	$this->{$this->tab_2_settings_key} = (array) get_option( $this->tab_2_settings_key);
	   	$this->{$this->tab_5_settings_key} = (array) get_option( $this->tab_5_settings_key);
	}
    public function get_rates_list(){
    	$plugin = new TransitQuote_Premium();
		$this->cdb = $plugin->get_custom_db();
    	$sql = "select distinct * 
    				from (select distinct * 
								from wp_premium_rates
								where distance <> 0
							order by service_type_id, distance
							) r
					union
				select distinct * from (
					select distinct * 
						from wp_premium_rates
					where distance = 0) r2;";

		$data = $this->cdb->query($sql);
		return $data;
    }
	private static function register_tables(){
		//define and register tables
		$this->cdb = new TransitQuote_Premium\CT_CDB(array('prefix'=>'tq_pre'));
		$db_config = new TransitQuote_Premium\DB_Config();

		//Define tables from the configs in the DB_Config class
		$this->cdb->define_table($db_config->get_config('customers'));
		$this->define_table($db_config->get_config('products'));
		$this->define_table($db_config->get_config('customers_products'));
		$this->define_table($db_config->get_config('event_logs')); 
		$this->define_table($db_config->get_config('event_data'));
	}

	/**
	 * Register the shortcode and display the form.
	 *
	 * @since    1.0.0
	 */

	public function display_TransitQuote_Premium($atts) {
		global $add_my_script_flag;
		$args = array( 'post_type' => 'product', 'posts_per_page' => 5,'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'terms' => $atts,
				'operator' => 'IN',
			)
        ), 'orderby' => 'rand' );
        $this->voucher_list = new WP_Query( $args );
		$add_my_script_flag = true; //to load the script if shortcode called
		$attributes = shortcode_atts( array(
	        'product_id' => '',
	    ), $atts );
	    $this->pd_product 	= $attributes['product_id'];
	    $ct_product 		= self::get_product_by_paddleid($this->pd_product);
		$this->ct_product 	= $ct_product['id'];
     	$this->view 		= 'partials/wp-balance-voucher-public-display.php';
		ob_start();
	   	include $this->view;
	   	return ob_get_clean();
	}

	public function get_product_by_paddleid($paddle_id){
		$plugin = new TransitQuote_Premium();
		$this->cdb = $plugin->get_custom_db();
		if(empty($paddle_id)){
			return false;
		};
		$ct_product = $this->cdb->get_row('ct_products', $paddle_id, 'paddleid');
		return $ct_product;
	}
	 /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TransitQuote_Premium_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TransitQuote_Premium_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $add_my_script_flag;
		if ( ! $add_my_script_flag )
			return;
		wp_enqueue_style( $this->plugin_slug."-parsley", plugin_dir_url( __FILE__ ) . 'css/parsley.css', array(), '', 'all' );
		wp_enqueue_style( $this->plugin_slug.'-public', plugin_dir_url( __FILE__ ) . 'css/wp-balance-voucher-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TransitQuote_Premium_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TransitQuote_Premium_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $add_my_script_flag;
		if ( ! $add_my_script_flag )
			return;
		wp_enqueue_script( $this->plugin_slug.'-parsley-script', plugin_dir_url( __FILE__ ) . 'js/parsley.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_slug.'-public-main', plugin_dir_url( __FILE__ ) . 'js/public-main.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_slug.'-public', plugin_dir_url( __FILE__ ) . 'js/wp-balance-voucher-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_slug.'-public', 'WpSellSoftwareSettings', array('ajaxUrl' => admin_url( 'admin-ajax.php' ), 'vendorId'=>$this->vendor_id));
		wp_enqueue_script( $this->plugin_slug.'-paddle', 'https://cdn.paddle.com/paddle/paddle.js', array( $this->plugin_slug.'-public' ), '', false );

	}

	/*** Front end ajax methods ***/
	private function get_record_data($table, $idx = null){
		//get params for records data from front end
		//idx is a 0 based index for where more than one rec is passed
		//get the field names to save
		$fields = $this->cdb->get_table_col_names($table);
		if($fields === false){
			$this->ajax->respond(array('success' => 'false',
                                    'msg'=>'Invalid table for update '.$table));
		};
		//append string to param name for instances of more than 1 rec
		$idx_str = '';
		if(is_numeric($idx)){
			$idx_str = '_'.$idx;
		};

		//init the record array
		$record_data = array();
		//get parameters
		foreach ($fields as $key => $field) {
			switch($field){
				case 'created':
				case 'modified':
				case 'purchase_date':
					$record_data[$field] = date('Y-m-d G:i:s');
					break;
				case 'delivery_time':					
					$delivery_date = $this->ajax->param(array('name'=>'delivery_date', 'optional'=>false));
					$date = new DateTime($delivery_date);
					$delivery_time = $this->ajax->param(array('name'=>'delivery_time', 'optional'=>false));
					$time_parts = explode(':', $delivery_time);
					$hours = $time_parts[0];
					$mins = $time_parts[1];
					$date->setTime($hours, $mins);
					$record_data[$field] = $date->format('Y-m-d H:i:s');
					break;				
				default:
					$field_name = $field.$idx_str;
					//$this->ajax->pa($field_name);
					$val = $this->ajax->param(array('name'=>$field_name, 'optional'=>true));
					if(!empty($val)){
						$record_data[$field] = sanitize_text_field($val);
					};
					if(strrpos($field, '_date')>-1){
						$record_data[$field] = $this->cdb->mysql_date($record_data[$field]);
					};				
			};
		};
		return $record_data;
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
		if(empty($table)){
			return false;
		};
		//get param data
		$record_data = self::get_record_data($table, $idx);
		
		if(!empty($defaults)){
			//merge with passed data
			$record_data = array_merge($defaults, $record_data);
		}

		$row_id = self::save_record($table, $record_data);
		$record_data['id'] = $row_id;		
		return $record_data;
	}
	public function save_record($table, $record_data){
		//Save the main event record
		//$this->ajax->pa($record_data);

		//save or update
		$rec_id = $this->cdb->update_row($table, $record_data);
		if($rec_id === false){
			$this->ajax->respond(array('success' => 'false',
                                    'msg'=>'Unable to update '.$table,
                                    'sql'=>$this->cdb->last_query));
		};
		return $rec_id;
	}	

	public function save_sale(){
		$plugin = new TransitQuote_Premium();
		$this->cdb = $plugin->get_custom_db();
		$this->ajax = new TransitQuote_Premium\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

		$this->sale = self::save('ct_customers_products');
		$message ='Product purchased successfully';
		$this->customer = self::get_customer_by_id(1);
		$email = self::email_dispatch('New Sale: '.$this->customer['first_name']." ".$this->customer['last_name']);
		// $customer_email = self::email_customer();

		$response = array('success'=>'true',
							 'msg'=>$message,
							 'data'=>array('customer'=>$this->customer));	

		$this->ajax->respond($response);
	}

	public function save_customer(){
		$plugin = new TransitQuote_Premium();
		$this->cdb = $plugin->get_custom_db();
		$this->ajax = new TransitQuote_Premium\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));
		
		// // save job request from customer facing form
		if($this->log_requests == true){
			$this->ajax->log_requests();
		}
		//get email for notification
		$email = $this->ajax->param(array('name'=>'email'));


		$existing_customer = self::get_customer_by_email($email);
		if($existing_customer===false){
			//save new customer as we have a new email address
			$this->customer = self::save('ct_customers');
		} else{
			//save against an existing customer email
			//we can pass id and it will not be overwritten as it is not in the post data
			$this->customer = self::save('ct_customers',null, array('id'=>$existing_customer['id']));
		};

		//default message
		$message ='Customer registered successfully';
		
		$email = self::email_dispatch('New Customer Registered: '.$this->customer['first_name']." ".$this->customer['last_name']);
		// $customer_email = self::email_customer();

		$response = array('success'=>'true',
							 'msg'=>$message,
							 'data'=>array('customer'=>$this->customer));	

		$this->ajax->respond($response);

	}
	private function email_customer(){
		//send email to customer

		$to = self::get_customer_email();
		$from = self::get_from_address();
		$from_name = self::get_from_name();
		$subject = self::get_customer_subject();
		$message = self::get_customer_message();

		//test address
		$headers = "Bcc: contact@creativetransmissions.com"."\r\n";
		
		ob_start();
		include 'partials/emails/email_customer.php'; 
		$html_email = ob_get_clean();

		//add_filter('wp_mail_content_type', array( $this, 'set_content_type' ) );
		//$this->ajax->set_email_debug(true);
		$email = $this->ajax->send_notification($to,
										$from,
										$from_name,
										$subject,
										$html_email, $headers);

		//remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

		return $html_email;
	}

	private function email_dispatch($subject){

		//get email addresses to send notifications to 
		$notification_addresses = self::get_notification_emails();

		//spit email addresses field incase there is more than one
		$this->notification_emails = explode(',',$notification_addresses);

		if(count($this->notification_emails)===0){
			self::debug('No notification email addresses provided');
			return false;
		};

		$to = array_shift($this->notification_emails);
		$from = self::get_from_address();
		$from_name = self::get_from_name();

		//test address
		$headers = "";

		//additional bcc addresses
		foreach ($this->notification_emails as $key => $address) {
			$headers .= "Bcc: ".$address."\r\n";
		};
		
		ob_start();
		include 'partials/emails/email_job_details.php'; 
		$html_email = ob_get_clean();

		//add_filter('wp_mail_content_type', array( $this, 'set_content_type' ) );
		//$this->ajax->set_email_debug(true);
		$email = $this->ajax->send_notification($to,
										$from,
										$from_name,
										$subject,
										$html_email, $headers);

		//remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

		return $html_email;
	}
	public function get_api_string(){
		$api_string = '';

		$this->api_key = self::get_setting($this->tab_2_settings_key, 'api_key');
		if(!empty($this->api_key)){
			$api_string = '&key='.$this->api_key;
		};

		return $api_string;
	}
	public function get_api_key(){
		//get google maps api key
		$this->api_key = self::get_setting($this->tab_2_settings_key, 'api_key', 'default');
		if(empty($this->api_key)){
			return false;
		};
		return $this->api_key;
	}
	public function get_customer_subject(){
        return self::get_setting($this->tab_5_settings_key, 'customer_subject', 'Your Quote Is Enclosed.');
    }
	public function get_geolocate(){
        return self::get_setting($this->tab_2_settings_key, 'geolocate');
    }	
	public function get_distance_unit(){
        return self::get_setting($this->tab_2_settings_key, 'distance_unit', 'Kilometer');
    }
    public function get_success_message(){
        return self::get_setting($this->tab_2_settings_key, 'success_message', 
        						'Thank you for your enquiry, a member of our staff will be in touch as soon as possible.');
    }
    public function get_customer_message(){
        return self::get_setting($this->tab_5_settings_key, 'customer_message', 'Thank you for your request.');
    }
    public function get_currency(){
        return self::get_setting($this->tab_2_settings_key, 'currency', '$');
    }	
	public function get_oldest_job_date(){
		$plugin = new TransitQuote_Premium();
		$this->cdb = $plugin->get_custom_db();
		$jobs = $this->cdb->get_rows('jobs', array(), array('id', 'created'), null);
		if(empty($jobs)){
			return 'no jobs';
		};
		if(!isset($jobs[0])){
			 return 'no first job';
		};
		return $jobs[0]['created'];
	}
	public function get_setting($tab, $name, $default = ''){
		//get and escape setting
		if(empty($this->{$tab}[$name])){
			return $default;
		} else {
			return esc_attr($this->{$tab}[$name]);
		}
	}
	public function get_notification_emails(){
        // return self::get_setting($this->tab_5_settings_key, 'notify', get_option( 'admin_email' ));
        return get_option( 'admin_email' );
    }
    public function get_from_address(){
        return get_option( 'admin_email' );
    }
    public function get_from_name(){
        return 'Custom Google Map Tools';
        // return self::get_setting($this->tab_5_settings_key, 'from_name', 'Medical Rescue');
    }
	public function job_details_list($header, $data){
		//return job details info in list for text email
		$text = $header."\r\n\r\n";
		$rows = array();
		foreach ($data as $field) {
			if(empty($field['label'])){
				$rows[] = $field['value'];
			} else {
				$rows[] = $field['label'].': '.$field['value'];
			}
			
		};
		$text .= implode("\r\n", $rows);
		echo $text."\r\n\r\n";
	}
    public function format_customer($customer){

		//format for display in job details view
		$out = array();
		foreach ($customer as $key => $value) {

			//init new field
			$field = array();

			//include only label, value and template_id set to text incase needed for output
			switch ($key) {
				case 'first_name':
					$field['label'] = 'First Name';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'last_name':
					$field['label'] = 'Last Name';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'email':
					$field['label'] = 'Email Address';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'phone':
					$field['label'] = 'Phone Number';
					$field['value'] = $value;
					$out[] = $field;
					break;
			};
			
		};
		return $out;

	}
}
