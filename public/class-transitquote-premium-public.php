<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
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
	private $tab_5_settings_key = 'premium_email_options';
	private $tab_6_settings_key = 'premium_paypal_options';
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
	}

	public function check_payment_config($payment_type_id = null){
		// Check we have all required paypal config values
		if(empty($payment_type_id)){
			self::debug('check_payment_config: no payment_type_id');
			return false;
		};

		switch ($payment_type_id) {
			case 1: // payment on delivery
				break;
			case 2: // payment by paypal
				$this->business_email = self::get_setting('premium_paypal_options', 'business_email');
				if(empty($this->business_email)){
					self::debug('no business_email set');
					return false;
				};

				$this->currency_code = self::get_currency_code();
				if(empty($this->currency_code)){
					self::debug('no currency_code set');
					return false;
				};
				break;
		};
		return true;
	}
	public function debug($error){
		if($this->debug==true){		
			$plugin = new TransitQuote_Premium();	
			$this->cdb = $plugin->get_custom_db();
			$this->ajax = new TransitQuote_Premium\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));
			$this->ajax->error_log_request($error, 'log');
			if(is_array($error)){
				echo '<pre>';
				print_r($error);
				echo '</pre>';				
			} else {
				echo '<br/>'.$error;
			}
		}
	}

	public function load_settings() {		
	 	$this->{$this->tab_1_settings_key} = (array) get_option( $this->tab_1_settings_key);
	   	$this->{$this->tab_2_settings_key} = (array) get_option( $this->tab_2_settings_key);
	   	$this->{$this->tab_5_settings_key} = (array) get_option( $this->tab_5_settings_key);
	   	$this->{$this->tab_6_settings_key} = (array) get_option( $this->tab_6_settings_key);
	}
	private function get_rates(){
	   	$plugin = new TransitQuote_Premium();
		$this->cdb = $plugin->get_custom_db();
    	$rates = $this->cdb->get_rows('rates');
		return $rates;
    }

    public function get_rates_list(){
    	$plugin = new TransitQuote_Premium();
		$this->cdb = $plugin->get_custom_db();
    	$sql = "select distinct * 
    				from (select distinct * 
								from wp_premium_tp_rates
								where distance <> 0
							order by service_type_id, distance
							) r
					union
				select distinct * from (
					select distinct * 
						from wp_premium_tp_rates
					where distance = 0) r2;";

		$data = $this->cdb->query($sql);
		return $data;
    }
	public function init_plugin(){
		// Load plugin text domain	
		// $this->cdb = self::get_custom_db();
		// $this->ajax = new TransitQuotePro\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));		
		self::load_settings();
	}
	/**
	 * Register the shortcode and display the form.
	 *
	 * @since    1.0.0
	 */
	public function display_TransitQuote_Premium($atts) {
		global $add_my_script_flag;
		$add_my_script_flag = true;
		// added layout option if given and inline then form will  be inline map else admin setting
		$attributes = shortcode_atts( array(
	        'layout' => '',
	    ), $atts );
		
	    if ($attributes['layout'] == 'inline'){
	    	$layout = 1;
	    }elseif($attributes['layout'] == 'popup'){
	    	$layout = 2;
	    }else{
	    	$layout = $this->currency = self::get_layout();
	    }
		$this->currency = self::get_currency();
		$this->distance_unit = self::get_distance_unit();

		if($layout==1){ //Inline Map public
			$this->view = 'partials/transitquote-premium-inline-display.php';
		}else{ //business_qoute
			$this->view = 'partials/transitquote-premium-popup-display.php';
		}		
		ob_start();
	   	include $this->view;
	   	return ob_get_clean();
	}	

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
		wp_enqueue_style( $this->plugin_slug . '-calc-styles', plugins_url( 'js/js-transitquote/css/map-quote-calculator.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-jqueryui-styles', plugins_url( 'css/jquery-ui.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-timepicker-styles', plugins_url( 'css/jquery-ui-timepicker-addon.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugin_dir_url( __FILE__ ) . 'css/transitquote-premium-public.css', array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-parsley-styles', plugin_dir_url( __FILE__ ) . 'css/parsley.css', array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-popup-styles', plugins_url( 'css/magnific-popup.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_scripts() {
		global $add_my_script_flag;
		if ( ! $add_my_script_flag )
			return;
		//get varibles to pass to JS
		// $holidays = self::get_holidays();
		$rates = self::get_rates();
	
		// $surcharges = self::get_service_surcharges();

		$this->start_lat = $this->get_setting('premium_quote_options', 'start_lat','55.870853');
		$this->start_lng = $this->get_setting('premium_quote_options', 'start_lng', '-4.252036');
		$this->start_place_name = $this->get_setting('premium_quote_options', 'start_place_name', 'Glasgow');
		$this->currency = self::get_currency();
		$this->distance_unit = self::get_distance_unit();
		$this->min_notice = $this->get_setting('premium_quote_options', 'min_notice', '24:00');
		$this->min_notice_charge = $this->get_setting('premium_quote_options', 'min_notice_charge', '200');
		$this->quote_element = $this->get_setting('premium_quote_options', 'quote_element', 'quote');
		$this->api_key = self::get_api_key();
		$this->api_string = self::get_api_string();
		$geolocate = self::get_geolocate();
		if($geolocate==1){
			$this->geolocate = 'true';		
		} else {
			$this->geolocate = 'false';	
		};

		$tq_settings = array('ajaxurl' => admin_url( 'admin-ajax.php' ),
							'geolocate'=>$this->geolocate,
							'imgurl'=> plugins_url( 'assets/images/', __FILE__ ),
							'distance_unit'=>$this->distance_unit,
							'startLat'=>$this->start_lat,
							'startLng'=>$this->start_lng,
							'startPlaceName'=>$this->start_place_name,
							'rates'=>$rates,
							'min_notice'=>$this->min_notice,
							'min_notice_charge'=>$this->min_notice_charge,
							'quote_element'=>$this->quote_element
							);

		if(!empty($this->api_key)){
			$tq_settings['apiKey'] = $this->api_key;
		};


		//include dependancies
		wp_enqueue_script($this->plugin_slug.'-magnific-popup', plugins_url( 'js/jquery-magnific-popup.js', __FILE__ ), '', 1.1, True );
		wp_enqueue_script($this->plugin_slug.'-gmapsapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places'.$this->api_string, '', 3.14, True );
		wp_enqueue_script($this->plugin_slug.'-jqui', 'http://code.jquery.com/ui/1.10.4/jquery-ui.js', '', 1.10, True );
		wp_enqueue_script( $this->plugin_slug.'-jqui-maps', plugins_url( 'js/jquery.ui.map.js', __FILE__ ), array( 'jquery',$this->plugin_slug.'-jqui',$this->plugin_slug.'-gmapsapi'), '', True ); //was commented
		wp_enqueue_script( $this->plugin_slug.'-jqui-timepicker', plugins_url( 'js/jquery-ui-timepicker-addon.js', __FILE__ ), array( 'jquery',$this->plugin_slug.'-jqui',$this->plugin_slug.'-gmapsapi'), '', True );
		wp_enqueue_script( $this->plugin_slug.'-map-quote-calculator', plugins_url( 'js/js-transitquote/js/map-quote-calculator.js', __FILE__ ), array( 'jquery',$this->plugin_slug.'-jqui',$this->plugin_slug.'-jqui-maps'), '', True );
		wp_enqueue_script($this->plugin_slug . '-transitquote-premium', plugins_url('js/transitquote-premium-public.js', __FILE__ ), array($this->plugin_slug.'-map-quote-calculator'), $this->version, true);

		wp_enqueue_script( $this->plugin_slug . '-parsley-script', plugins_url( 'js/parsley.js', __FILE__ ), array( $this->plugin_slug . '-transitquote-premium' ), $this->version, true );	
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public-main.js', __FILE__ ), array( $this->plugin_slug . '-transitquote-premium' ), $this->version, true );
 		wp_localize_script( $this->plugin_slug . '-plugin-script', 'TransitQuotePremiumSettings', $tq_settings);
 		
	}



	/*** Front end ajax methods ***/
	public function premium_save_job_callback(){		
		$this->plugin = new TransitQuote_Premium();	
		$this->cdb = $this->plugin->get_custom_db();
		$this->ajax = new TransitQuote_Premium\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));
		
		// save job request from customer facing form
		if($this->log_requests == true){
			$this->ajax->log_requests();
		}

		// get the submit type for the submitted qutoe form
		$submit_type = $this->ajax->param(array('name'=>'submit_type', 'optional'=>true));

		//get the job id in submitted form, unless it is a quote request submission
		$job_id = $this->ajax->param(array('name'=>'job_id', 'optional'=>true));
		switch ($submit_type) {
			case 'pay_method_1':
				// On delivery
				$response = self::request_payment_on_delivery($job_id);
				break;
			case 'pay_method_2':
				// PayPal
				$response = self::request_payment_paypal($job_id);
				break;
			case 'pay_method_3':
				// Stripe
				$response = self::request_payment_stripe($job_id);
				break;				
			default:
				//get estimate
				$response = self::get_quote();
				break;
		}

		if($response === false){
			$response = array('success'=>false, 
								'msg'=>'Sorry, an error occured and we are unable to process this request.');
		};

		$this->ajax->respond($response);		
	}

	public function get_job_id(){
		//return curernt job id
		if(!isset($this->job)){
			return false;
		};

		if(empty($this->job['id'])){
			return false;
		};		
		return $this->job['id'];
	}

	public function get_quote(){
		//get email for notification
		$email = $this->ajax->param(array('name'=>'email'));


		$existing_customer = self::get_customer_by_email($email);
		if($existing_customer===false){
			//save new customer as we have a new email address
			$this->customer = self::save('customers');
		} else{
			//save against an existing customer email
			//we can pass id and it will not be overwritten as it is not in the post data
			$this->customer = self::save('customers',null, array('id'=>$existing_customer['id']));
		};

		//get from location from map address_0 field
		$record_data = self::get_record_data('locations', 0);
		$address_0_location_id = self::get_location_by_address($record_data);
		if(empty($address_0_location_id)){
			//no match, create new location
			$this->location_0 = self::save('locations',0);
		} else {
			//existing location
			$this->location_0 = $this->cdb->get_row('locations', $address_0_location_id);
		};

		if(empty($this->location_0)){
			return false;
		};

		//get from location from map address_1 field
		$record_data = self::get_record_data('locations', 1);
		//search for a match lat lng address in db
		$address_1_location_id = self::get_location_by_address($record_data);
		if(empty($address_1_location_id)){
			//no match, create new location
			$this->location_1 = self::save('locations',1);
		} else {
			//existing location id passed in params
			$this->location_1 = $this->cdb->get_row('locations', $address_1_location_id);
		};

		if(empty($this->location_1)){
			return false;
		};

		$this->quote = self::save('quotes');
		//$this->quote_surcharge_ids = self::save_surcharges($this->quote['id']);

		//To do: create a many to many address relationship with job with an order index
		//save job, passing id values not included in post data
		$this->job = self::save('jobs',null, array('customer_id'=>$this->customer['id'],
													'accepted_quote_id'=>$this->quote['id']));

		//a job could potentially have multiple journeys so save job id against table
		$this->journey = self::save('journeys',null,array('job_id'=>$this->job['id'],
												'origin_location_id'=>$this->location_0['id'],
												'dest_location_id'=>$this->location_1['id']));
		
		//default message
		$message ='Request booked successfully';
		

		$this->job = self::get_job_details();
		$email = self::email_dispatch('New Removal Request: '.$this->customer['first_name']." ".$this->customer['last_name']);
		$customer_email = self::email_customer();

		return array('success'=>'true',
							 'msg'=>$message,
							 'data'=>array('customer_id'=>$this->customer['id'],
							 				'job_id'=>$this->job['id']));
		

	}

	/*
		Payment Methods After Recieving Quote 
	*/
	private function request_payment_on_delivery($job_id = null){
		if(empty($job_id)){
			return array('success'=>'false',
							 'msg'=>'No job_id for payment on delivery');
		};

		if(!self::update_payment_status($job_id, 1)){
			return array('success'=>'false',
							 'msg'=>'Unable to update job '.$job_id.' to payment on delivery');
		};

		return array('success'=>'true',
						'success_message'=>'<h2>Thank You.</h2><p>Your job has now been booked with payment due on delivery. Your reference number is: '.$job_id.'</p>');

	}

	private function request_payment_paypal($job_id = null){
		if(empty($job_id)){
			return array('success'=>'false',
							 'msg'=>'No job_id for payment by PayPal');
		};

		if(!self::update_payment_status($job_id, 2)){
			return array('success'=>'false',
							 'msg'=>'Unable to update job '.$job_id.' to payment by paypal');
		};

		//get job from job_id
		$this->job = self::get_job($job_id);
		// get related job data
		$this->job = self::get_job_details($this->job);

		$paypal_config = array('cdb'=>$this->cdb,
								'amount' => $this->quote['total'],
								'business'=> self::get_setting('premium_paypal_options', 'business_email'),
								'currency'=> self::get_currency_code(),
								'item_name'=> self::get_setting('premium_paypal_options', 'item_name', 'TransitQuote Payment'),
								'item_number'=>$this->job['id'],
								'transaction_id'=>$this->job['id'],
								'sandbox'=> self::get_setting('premium_paypal_options', 'sandbox', 1)
						);

		$this->paypal = new CT_PayPal($paypal_config);
		$paypal_form = $this->paypal->get_paypal_form();
		$paypal_html = '<h3>Please click below to make your payment and book this delivery</h3>'.
							$paypal_form;

		return array('success'=>'true',
					 'msg'=>'Job booked successfully',
					 'data'=>array('customer_id'=>$this->customer['id'],
					 				'job_id'=>$this->job['id'],
					 				'quote_id'=>$this->quote['id'],
					 				'email'=>$this->customer['email']),
					 'paypal_html'=>$paypal_html);

	}

	private function request_payment_stripe($job_id = null){
		if(empty($job_id)){
			return array('success'=>'false',
							 'msg'=>'No job_id for payment by stripe');
		};

		if(!self::update_payment_status($job_id, 3)){
			return array('success'=>'false',
							 'msg'=>'Unable to update job '.$job_id.' to payment by stripe');
		};
	}

	public function get_record_data($table, $idx = null){
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
	public function job_details_table($header, $data){
		
		$rows = array();
		foreach ($data as $field) {
			if(empty($field['label'])){
				$row = '<td>'.$field['value'].'</td>';
				$html = '<table><tr><th colspan="1">'.$header.'</th></tr><tr>';
			} else {
				$row = '<td>'.$field['label'].'</td><td>'.$field['value'].'</td>';
				$html = '<table><tr><th colspan="2">'.$header.'</th></tr><tr>';
			}
			
			$rows[] = $row;
		};

		if(count($rows)===0){
			echo '<table><tr><th colspan="1">'.$header.'</th></tr><tr><tr><td>No information available.</td></tr>';
		};
		$html .= implode('</tr><tr>', $rows);
		$html .= '</tr></table>';
		echo $html;
	}
	private function get_location_by_address($record_data){
		//check for an existing location by its address and lat lng coordinates
		if(empty($record_data['lat'])){
			return false;
		};
		if(empty($record_data['lng'])){
			return false;
		};

		$lat = round($record_data['lat'] / 10, 7) * 10;
		$lng = round($record_data['lng'] / 10, 7) * 10;
		$query = array( 'address'=>$record_data['address'],
											'lat'=>$lat,
											'lng'=>$lng);
		$location = $this->cdb->get_rows('tp_locations',$query,
									array('id'));

		if(empty($location)){
			return false;
		};
		
		return $location[0]['id'];
	}

 	private function get_job($job_id = null){
    	//get job record from property or database
    	if(empty($job_id)){
    		// if no job passed, get the job currently being processed from the job property
    		if(empty($this->job)){
    			// if the job property is not set return false
    			return false;
    		} else {
    			// return the job property
    			return $this->job;
    		}
    	};
		//if we do have a passed job id, get the job from the table
		return $this->cdb->get_row('jobs',$job_id);
    }

	public function get_job_details($job = null){
		$plugin = new TransitQuote_Premium();	
		$this->cdb = $plugin->get_custom_db();
		//add the details to a job record
		if(empty($job)){
    		$job = $this->job;
    	}; 

    	if(empty($job)){
    		//no job to add details to
			self::debug(array('name'=>'No job to add details to.'));     		
    		return false;
    	};

		if(!isset($this->customer)){
			$this->customer = $this->cdb->get_row('customers', $job['customer_id']);
			if($this->customer===false){
				self::debug(array('name'=>'Could not load customer',
	                            'value'=>'job_id: '.$job['id']));
			};
		};
		$job['customer'] = $this->customer;


		if(!isset($this->journey)){
			$this->journey = $this->cdb->get_row('journeys', $job['id'], 'job_id');
			if($this->journey===false){
				self::debug(array('name'=>'Could not load journey',
	                            'value'=>'job_id: '.$job['id']));
			};
		};
		$job['journey'] = $this->journey;

		if(!isset($this->location_0)){
			$this->location_0 = $this->cdb->get_row('locations',$this->journey['origin_location_id']);
			if($this->location_0===false){
				self::debug(array('name'=>'Could not load origin',
	                            'value'=>'job_id: '.$job['id']));
			};
		};
		$job['location_0'] = $this->location_0;

		if(!isset($this->location_1)){
			$this->location_1 = $this->cdb->get_row('locations',$this->journey['dest_location_id']);
			if($this->location_1===false){
				self::debug(array('name'=>'Could not load destination',
	                            'value'=>'job_id: '.$job['id']));
			};
			
		};
		$job['location_1'] = $this->location_1;		
		if(!isset($this->quote)){
			if(!empty($job['accepted_quote_id'])) {
				$this->quote = $this->cdb->get_row('quotes',$job['accepted_quote_id']);
				if($this->quote===false){
					self::debug(array('name'=>'Could not load quote',
		                            'value'=>'job_id: '.$job['id']));
				};
			}
		};
		$job['quote'] = $this->quote;
		$job['job_date'] = self::get_job_date($job);
		return $job;
	}

	public function get_job_date($job = null){
		//get date and time for job in separate  array elements
		if(empty($job)){
    		$job = $this->job;
    	};

    	if(empty($job)){
    		//no job passed
			self::debug(array('name'=>'No job to get move day.'));     		
    		return false;
    	};

    	$job_date = array();

    	//get date
		$dateparts = explode(' ', $job['delivery_time']);
		$job_datetime = $dateparts[0];

		//get time
		$time_parts = explode(':', $dateparts[1]);
		$hours = $time_parts[0];
		$mins = $time_parts[1];
		
    	$dt = new DateTime($job_datetime);

		$date = $dt->format('d/m/Y');

		$job_date[0]=array('label'=>'Pick Up Date',
								'value'=> $date);

		/*$job_date[1] = array('label'=>'Pick Up Time',
							'value'=>$hours.':'.$mins);
		*/
		return $job_date;
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

    public function get_layout(){
        return self::get_setting($this->tab_2_settings_key, 'layout');
    }
	public function get_customer_by_email($email){
		//check for the email address to see if this is a previous customer
		if(empty($email)){
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
	public function get_customer_email(){
        return $this->customer['email'];
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

    public function get_payment_buttons(){
    	$plugin = new TransitQuote_Premium();
    	$this->cdb = $plugin->get_custom_db();
    	$methods = $this->cdb->get_rows('payment_types', array('available'=>1), array('id', 'name'), null);
    	if(count($methods)===0){
    		// no payment methods available. Perhaps for quote only.
    		return '';
    	};

    	//build array of buttons based on payment methods available in the payment_types table
		$button_html ='';
    	$buttons = array();
    	foreach ($methods as $key => $payment_method) {
    		if(self::check_payment_config($payment_method['id'])){
	    		$button_html = '<button id="pay_method_'.$payment_method['id'].'" class="tq-button" type="submit" name="submit" value="pay_method_'.$payment_method['id'].'">'.$payment_method['name'].'</button>';
				array_push($buttons, $button_html);
			};
    	};

    	$button_panel = '<div class="tq-payment-buttons">';
    	$button_panel .= implode('', $buttons);
    	$button_panel .= '</div>';

    	return $button_panel;

    }
    public function get_success_message(){
        return self::get_setting($this->tab_2_settings_key, 'success_message', 
        						'Thank you for your enquiry, we accept credit card payments online via PayPal (no login required) or on delivery.');
    }
    public function get_customer_message(){
        return self::get_setting($this->tab_5_settings_key, 'customer_message', 'Thank you for your request.');
    }

    public function get_currency(){
    	$currency = self::get_setting($this->tab_2_settings_key, 'currency');
        return $currency;
    }

    public function get_currency_code(){
    	$currency_symbol = self::get_setting($this->tab_2_settings_key, 'currency', '$');
    	switch ($currency_symbol) {
    		case '$':
    			$currency = 'USD';
    			break;
    		case '£':
    			$currency = 'GBP';
    			break;
    		default:
    			$currency = 'USD';
    			break;
    	}
        return $currency;
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
	public function format_table($data){
		//format for display in job details view
		$out = array();
		foreach ($data as $key => $value) {
			//init new field
			$field = array();
			//include only label, value and template_id set to text incase needed for output
			switch ($key) {
				case 'id':
				case 'created':
				case 'modified':
					break;
					default:
					$field['label'] = $key;
					$field['value'] = $value;
					$out[] = $field;
			};			
		};
		return $out;
	}
	public function format_job($job){
		$commerical_move_sizes = array();
		$commerical_move_sizes[1] = 'Factory';
		$commerical_move_sizes[2] = 'Warehouse';
		$commerical_move_sizes[3] = 'Small Office 1-10 employees';
		$commerical_move_sizes[4] = 'Medium Office 1-100 employees';
		$commerical_move_sizes[5] = 'Large Office - 100 + employees';

		$domestic_move_sizes = array();
		$domestic_move_sizes[1] = 'Less than 1 Bed House';
		$domestic_move_sizes[2] = '1 Bed House';
		$domestic_move_sizes[3] = '2 Bed House';
		$domestic_move_sizes[4] = '3 Bed House';
		$domestic_move_sizes[5] = '4 Bed House';
		$domestic_move_sizes[6] = '5 + Bed House';

		//format for display in job details view
		$out = array();
		foreach ($job as $key => $value) {
			//init new field
			$field = array();
			//include only label, value and template_id set to text incase needed for output
			switch ($key) {
				case 'description':
					$field['label'] = 'Information';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'move_size_id':
					$field['label'] = 'Move Size';
					$field['value'] = '';
					switch ($job['service_type_id']) {
						case 1:
							if(isset($commerical_move_sizes[$value])){
								$field['value'] .= $commerical_move_sizes[$value];
							} else {
								$field['value'] .= $value;
							};
							break;
						case 2:
							if(isset($domestic_move_sizes[$value])){
								$field['value'] .= $domestic_move_sizes[$value];
							} else {
								$field['value'] .= $value;
							};
							break;
					};
					$out[] = $field;
					break;					
				case 'service_type_id':
					$field['label'] = 'Move Type';
					$field['value'] = '';
					switch ($job['service_type_id']) {
						case 1:
							$field['value'] .= 'Commercial';
							break;
						case 2:
							$field['value'] .= 'Domestic';
							break;
					};
					$out[] = $field;
					break;								
				default:
					break;
			};			
		};
		return $out;
	}
	public function format_journey($journey){
		$distance_unit = self::get_distance_unit();
		//format for display in job details view
		$out = array();
		foreach ($journey as $key => $value) {
			//init new field
			$field = array();
			//include only label, value and template_id set to text incase needed for output
			switch ($key) {
				case 'distance':
					$field['label'] = 'Distance ('.$distance_unit.'s)';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'time':
					$field['label'] = 'Estimated Travel Time (Hours)';
					$field['value'] = number_format((float)$value, 2, '.', '');
					$out[] = $field;
					break;
			};			
		};
		return $out;
	}
	public function format_location($loc){
		//format for display in customise forms
		$out = array();
		foreach ($loc as $key => $value) {
			//skip empty fields
			if(empty($value)){
				continue;
			};
			//init new field
			$field = array();

			//include only label, value and template_id set to text incase needed for output
			switch ($key) {
				case 'address':
					$field['label'] = 'Address';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'appartment_no':
					$field['label'] = 'Appartment Number';
					$field['value'] = $value;
					$out[] = $field;
					break;					
				case 'street_number':
					$field['label'] = 'Building Number';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'route':
					$field['label'] = 'Route';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'postal_town':
					$field['label'] = 'Post Town';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'administrative_area_level_2':
					$field['label'] = 'Area';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'administrative_area_level_1':
					$field['label'] = 'Area';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'country':
					$field['label'] = 'Country';
					$field['value'] = $value;
					$out[] = $field;
					break;
				case 'postal_code':
					$field['label'] = 'Post Code';
					$field['value'] = $value;
					$out[] = $field;
					break;
			};
			
		};
		return $out;
	}
	public function format_quote($quote = null){
		//format for display in job details view
		if(empty($quote)){
			return false;
		};		
		$currency = self::get_currency();
		$out = array();
		foreach ($quote as $key => $value) {
			//init new field
			$field = array();
			//include only label, value and template_id set to text incase needed for output
			switch ($key) {
				case 'total':
					$field['label'] = 'Total';
					$field['value'] = $currency.$value;
					$out[] = $field;
					break;
				case 'rate_per_unit':
					break;
				case 'distance_cost':
					$field['label'] = 'Distance Cost';
					$field['value'] =$currency.$value;
					$out[] = $field;
					break;
				case 'notice_cost':
					if($value!=0){
						$field['label'] = 'Short Notice Cost';
						$field['value'] = $currency.$value;
						$out[] = $field;					
					}
					break;
			};
			
		};
		return $out;
	}

	/**
	 * Update Payment Status Column in jobs 
	 *	 
	 * @since    1.0.0
	 */	
	private function update_payment_status($job_id, $payment_status_type_id){
		if(empty($job_id)){
			self::log('update_payment_status: No job_id');
			return false;
		};

		if(empty($payment_status_type_id)){
			self::log('update_payment_status: No payment_status_type_id');
			return false;
		};

		// update the payment status to the selected type in the db and update the job object
		$this->job = $this->cdb->update_field('jobs','payment_status_type_id', $payment_status_type_id, $job_id);
		if($this->job===false){
			return false;
		};
		return true;

	}	
}
