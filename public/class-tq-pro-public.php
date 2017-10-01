<?php
/*error_reporting(E_ERROR | E_PARSE | E_ALL);
 ini_set('display_errors', 1);*/
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public 
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
class TransitQuote_Pro_Public {

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
    private $tab_1_settings_key = 'tq_pro_rates';
	private $tab_2_settings_key = 'tq_pro_quote_options';
	private $tab_5_settings_key = 'tq_pro_email_options';
	private $tab_6_settings_key = 'tq_pro_paypal_options';
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
		$this->prefix = 'tq_pro3';
		$this->cdb = TransitQuote_Pro::get_custom_db();
		$this->ajax = new TransitQuote_Pro3\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

	}

	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TransitQuote_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TransitQuote_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $add_my_script_flag;
		if ( ! $add_my_script_flag )
			return;
		wp_enqueue_style( $this->plugin_slug . '-calc-styles', plugins_url( 'js/js-transitquote/css/map-quote-calculator.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-jqueryui-styles', plugins_url( 'css/jquery-ui.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-timepicker-styles', plugins_url( 'css/jquery-ui-timepicker-addon.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugin_dir_url( __FILE__ ) . 'css/tq-pro-public.css', array(), $this->version );
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
				$add_my_script_flag = true;
		if ( ! $add_my_script_flag )
			return;
		
		self::get_plugin_settings();

		$tq_settings = self::get_settings_for_js();

		//include dependancies
		wp_enqueue_script($this->plugin_slug.'-magnific-popup', plugins_url( 'js/jquery-magnific-popup.js', __FILE__ ), '', 1.1, True );
		wp_enqueue_script($this->plugin_slug.'-gmapsapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places'.$this->api_string, '', 3.14, True );
		wp_enqueue_script($this->plugin_slug.'-jqui', 'http://code.jquery.com/ui/1.10.4/jquery-ui.js', '', 1.10, True );
		wp_enqueue_script($this->plugin_slug.'-paypal', 'https://www.paypalobjects.com/api/checkout.js', '', $this->version, true );
		
		wp_enqueue_script( $this->plugin_slug.'-jqui-maps', plugins_url( 'js/jquery.ui.map.js', __FILE__ ), array( 'jquery',$this->plugin_slug.'-jqui',$this->plugin_slug.'-gmapsapi'), '', True ); //was commented
		wp_enqueue_script( $this->plugin_slug.'-jqui-timepicker', plugins_url( 'js/jquery-ui-timepicker-addon.js', __FILE__ ), array( 'jquery',$this->plugin_slug.'-jqui',$this->plugin_slug.'-gmapsapi'), '', True );
		wp_enqueue_script( $this->plugin_slug.'-map-quote-calculator', plugins_url( 'js/js-transitquote/js/map-quote-calculator.js', __FILE__ ), array( 'jquery',$this->plugin_slug.'-jqui',$this->plugin_slug.'-jqui-maps'), '', True );
		wp_enqueue_script($this->plugin_slug . '-tq-pro', plugins_url('js/tq-pro-public.js', __FILE__ ), array($this->plugin_slug.'-map-quote-calculator'), $this->version, true);

		wp_enqueue_script( $this->plugin_slug . '-parsley-script', plugins_url( 'js/parsley.js', __FILE__ ), array( $this->plugin_slug . '-tq-pro' ), $this->version, true );	
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public-main.js', __FILE__ ), array( $this->plugin_slug . '-tq-pro' ), $this->version, true );
 		wp_localize_script( $this->plugin_slug . '-plugin-script', 'TransitQuoteProSettings', $tq_settings);
 		
	}

	public function get_plugin_settings(){
		$this->start_lat = $this->get_setting('tq_pro_quote_options', 'start_lat','55.870853');
		$this->start_lng = $this->get_setting('tq_pro_quote_options', 'start_lng', '-4.252036');
		$this->start_place_name = $this->get_setting('tq_pro_quote_options', 'start_place_name', 'Glasgow');
		self::get_currency_code();
		$this->distance_unit = self::get_distance_unit();
		$this->max_address_pickers = $this->get_setting('tq_pro_quote_options', 'max_address_pickers', '1');
		$this->min_notice = $this->get_setting('tq_pro_quote_options', 'min_notice', '');
		$this->min_notice_charge = $this->get_setting('tq_pro_quote_options', 'min_notice_charge', '');
		$this->quote_element = $this->get_setting('tq_pro_quote_options', 'quote_element', 'quote');
		$this->api_key = self::get_api_key();
		$this->api_string = self::get_api_string();
		$geolocate = self::get_geolocate();
		if($geolocate==1){
			$this->geolocate = 'true';		
		} else {
			$this->geolocate = 'false';	
		};		
	}

	public function get_settings_for_js(){
		//get varibles to pass to JS
		// $holidays = self::get_holidays();
		$rates = self::get_rates();
	
		// $surcharges = self::get_service_surcharges();
		$ajax_url = admin_url( 'admin-ajax.php' );

		$tq_settings = array('ajaxurl' => $ajax_url,
							'geolocate'=>$this->geolocate,
							'imgurl'=> plugins_url( 'assets/images/', __FILE__ ),
							'distance_unit'=>$this->distance_unit,
							'startLat'=>$this->start_lat,
							'startLng'=>$this->start_lng,
							'startPlaceName'=>$this->start_place_name,
							'rates'=>$rates,
							'min_notice'=>$this->min_notice,
							'min_notice_charge'=>$this->min_notice_charge,
							'quote_element'=>$this->quote_element,
							'max_address_pickers'=>$this->max_address_pickers
							);

		if(!empty($this->api_key)){
			$tq_settings['apiKey'] = $this->api_key;
		};

		$paypal_settings = array();
		$paypal_settings['createPaymentUrl'] = $ajax_url.'?action=create_paypal_payment';
		$paypal_settings['executePaymentURL'] = $ajax_url.'?action=execute_paypal_payment';
	
		if(!empty($paypal_settings)){
			$tq_settings['paypal'] = $paypal_settings;
		};
		return $tq_settings;
	}

	public function check_payment_config($payment_type_id = null){
		// Check we have all required paypal config values
		$payment_config_is_ok = false;

		if(empty($payment_type_id)){
			self::debug('check_payment_config: no payment_type_id');
			return false;
		};
		
		switch ($payment_type_id) {
			case 1: // payment on delivery
				$payment_config_is_ok = true;
				break;
			case 2: // payment by paypal
				self::get_paypal_config();
				$payment_config_is_ok = self::has_paypal_config();
				break;
		};
		
		return $payment_config_is_ok;
	}

	public function debug($error){
		if($this->debug==true){		
			$plugin = new TransitQuote_Pro();	
			$this->cdb = $plugin->get_custom_db();
			$this->ajax = new TransitQuote_Pro3\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));
			$this->ajax->error_log_request($error, 'log');
			if(is_array($error)){
				echo '<pre>';
				print_r($error);
				echo '</pre>';
				$error = print_r($error, true);
			} else {
				echo '<br/>'.$error;
			}
			trigger_error($error, E_USER_WARNING);
		}
	}

	public function define_tab_config(){
		return TransitQuote_Pro3\Admin_Config::get_config('tabs');
	}

	public function load_settings(){
		$this->tabs_config = $this->define_tab_config();
		$this->settings = array();
		// update the conif with any saved settings
		foreach ($this->tabs_config as $tab_key => $tab) {
			$saved_options = (array) get_option($tab_key, array());
			if(!empty($saved_options)){
				$this->settings = array_merge($this->settings, $saved_options);
			}
		};
	}

	public function get_prefix(){
		return $this->prefix;
	}

	private function get_rates(){
	   	$plugin = new TransitQuote_Pro();
		$this->cdb = $plugin->get_custom_db();
    	$rates = $this->cdb->get_rows('rates');
		return $rates;
    }

     public function get_rates_list($filters = null){
    	$filter_clause = '';
    	if(is_array($filters)){
    		// start sql with and if there is at least one filter
    		$filter_sql = ' and ';
    		// array for the separate parts of the where statement
    		$filter_clauses = array();
    		foreach ($filters as $key => $value) {
    			$filter_clauses[] = $key .' = ' .$value;
    		};
    		// concatenate individual filters with AND
    		$filter_sql .= implode(' and ', $filter_clauses);
    	};

		// get ordered list of rates with distance 0 as the final record
    	$sql = "select distinct * 
    				from (select distinct * 
								from wp_".$this->prefix."_rates
								where distance <> 0
								".$filter_sql."
							order by service_id, vehicle_id, distance
							) r
					union
				select distinct * from (
					select distinct * 
						from wp_".$this->prefix."_rates
					where distance = 0
					".$filter_sql.") r2;";
		//echo $sql;
		$data = $this->cdb->query($sql);
		return $data;
    }

	public function init_plugin(){
		$plugin = new TransitQuote_Pro();
		self::load_settings();

		$this->cdb = $plugin->get_custom_db();
		$this->ajax = new TransitQuote_Pro3\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

		if(!self::api_keys_are_present()){
			add_action( 'admin_notices', array($this, 'api_key_notice') );
		};

    }

    public function api_keys_are_present(){
    	$this->api_setup_message = '';
    	$success = true;
    	$this->application_client_id = self::get_setting('tq_pro_paypal_options','application_client_id');
		$this->application_client_secret = self::get_setting('tq_pro_paypal_options','application_client_secret');

    	if(!self::get_api_key()){
    		$this->api_setup_message = '<li>Please enter a valid Google Maps API Key in the Map Options tab of your TransitQuote Pro Dashboard.</li>';
    	};

    	if(empty($this->application_client_id)){
    		$this->api_setup_message .= '<li>Please enter a valid PayPal Application Client ID in the PayPal tab of your TransitQuote Pro Dashboard.</li>';

    	};

    	if(empty($this->application_client_id)){
    		$this->api_setup_message .= '<li>Please enter a valid PayPal Application Client Secret in the PayPal tab of your TransitQuote Pro Dashboard.</li>';
    	};

    	if(!self::rates_exist()){
    		$this->api_setup_message .= '<li>Please enter your rates in the Rates tab of your TransitQuote Pro Dashboard.</li>';
    	}

		if($success === false){
			$this->api_setup_message = '<p>To use TransitQuote Pro please update your settingss follows:</p><ul>'.$this->api_setup_message.'</ul>';
		}

		return $success;

    }

    public function rates_exist(){
    	$rates = self::get_rates();
    	if(empty($rates)){

    		return false;
    	} else {
    		return true;
    	}
    }

    public function api_key_notice(){
    	?><div class="update-nag notice">
    		<h3>TransitQuote Pro Setup Notice</h3>
    		<?php echo $this->api_setup_message; ?>
    	</div>
    	<?php
    }
   
    
    public function create_paypal_payment(){
    	self::init_paypal();
    	
    	$job_id = $this->ajax->param(array('name'=>'jobId', 'optional'=>false));	
    	$payment_item = self::create_payment_item($job_id);
		$this->paypal->add_payment_item($payment_item);
		
		$this->paypal->create_transaction(array('description'=>self::get_description(),
												'total'=>$this->quote['total'],
												'invoice_no'=>$job_id));

		$payment_id = $this->paypal->get_payment_id();

		$this->ajax->respond(array('success' => 'true',
									'payment_id' => $payment_id,
                                    'msg'=>'',
                                    'data'=>array('payment_item'=>$payment_item)));
    }

	public function get_msg_auth_success(){
		return 'Thank you! Your Payment has been authorized successfully. You will recieve a confirmation email as soon as the payment has been processed.';
	}
	
	public function get_msg_auth_fail(){
		return 'Sorry, we were unable to process your payment. Please check your PayPal account for more information.';
	}

    private function create_payment_item($job_id){
    	self::get_job_details_from_id($job_id);
    	$price = $this->quote['total'];

    	return array('name'=>self::get_description(),
					'currency'=> self::get_currency_code(),
					'quantity'=>'1',
					'order_no'=>$job_id,
					'price'=>$price,
					'customer_id'=>$this->job['customer_id']
					);
    }
    public function init_paypal(){
    	self::get_paypal_config();
		if(self::has_paypal_config()){
			$this->paypal = new CT_PayPal(array('application_client_id' => $this->application_client_id,
												'application_client_secret' => $this->application_client_secret,
												'payment_approved_url'=>$this->payment_approved_url,
												'payment_cancelled_url'=>$this->payment_cancelled_url,
												'cdb'=>$this->cdb));
			
		};
    }

    public function execute_paypal_payment(){

    	$plugin = new TransitQuote_Pro();
		self::load_settings();

		$this->cdb = $plugin->get_custom_db();
		$this->ajax = new TransitQuote_Pro3\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

    	self::init_paypal();

		$job_id = $this->ajax->param(array('name'=>'jobId', 'optional'=>false));	
		self::get_job_details_from_id($job_id);
    	$price = $this->quote['total'];
    	
    	self::get_payment_authorization_response_data();

    	$success = $this->paypal->execute_payment(array(
    											'job_id'=>$job_id,
	    										'payment_id'=>$this->payment_id,
	    										'payer_id'=>$this->payer_id,
	    										'currency'=> self::get_currency_code(),
												'price'=>$price,
											));
    	if($success===false){
			if(!self::update_payment_status_id($job_id, 3)){
				return array('success'=>'false',
								 'msg'=>'Unable to update job '.$job_id.' to failed');
			};

			$exception = $this->paypal->get_exception();
			$msg = $exception->getData();
			$url = $exception->getUrl();

			$this->ajax->respond(array('success' => 'false',
    									'msg'=>'Payment failed due to error.',
    									'error'=>$msg,
    									'url'=>$url));
    	} else {
    		$status = $this->paypal->get_paypal_status();
    		if($status==='approved'){
	    		if(!self::update_payment_status_id($job_id, 4)){
					return array('success'=>'false',
									 'msg'=>'Unable to update job '.$job_id.' to pending / authorized');
				};

				$this->ajax->respond(array('success' => 'true',
	    								'payment_id'=>$this->payment_id,
	                                    'status'=>$status));
			} else {
				$this->ajax->respond(array('success' => 'false',
	    								'payment_id'=>$this->payment_id,
	    								'msg'=>'Payment was not approved.',
	                                    'status'=>$status));
			}
    	}

    	

	}

	private function get_payment_authorization_response_data(){
	    $this->payment_id = $this->ajax->param(array('name'=>'paymentID', 'optional'=>false));
    	$this->payer_id = $this->ajax->param(array('name'=>'payerID', 'optional'=>false));	
	}

	private function get_paypal_config(){
		self::load_settings();

		$this->application_client_id = self::get_setting('tq_pro_paypal_options','application_client_id');
		$this->application_client_secret = self::get_setting('tq_pro_paypal_options','application_client_secret');

		$site_url = get_site_url();
		$payment_approved_url = self::get_setting('tq_pro_paypal_options','payment_approved_url','/payment-approved');
		$payment_cancelled_url = self::get_setting('tq_pro_paypal_options','payment_approved_url','/payment-cancelled');
		$this->payment_approved_url = $site_url.$payment_approved_url; 
		$this->payment_cancelled_url = $site_url.$payment_cancelled_url;
	}

	private function has_paypal_config(){
		if((!empty($this->application_client_id))&&(!empty($this->application_client_secret))){
			return true;
		} else {
			return false;
		}
	}

	public function get_description(){
		return $this->sales_item_description = self::get_setting('tq_pro_paypal_options','sales_item_description', 'Delivery');
	}

	/**
	 * Register the shortcode and display the form.
	 *
	 * @since    1.0.0
	 */
	public function display_TransitQuote_Pro($atts) {
		global $add_my_script_flag;
		$add_my_script_flag = true;

		$plugin = new TransitQuote_Pro();
		$this->cdb = $plugin->get_custom_db();
		$this->ajax = new TransitQuote_Pro3\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));

		$this->pick_start_address = 'true';
		// added layout option if given and inline then form will  be inline map else admin setting

		//get paths for includes
		self::get_paths_for_includes();

		// display the plugin form
		$attributes = shortcode_atts( array(
	        'layout' => '',
	    ), $atts );
		
	    if ($attributes['layout'] == 'inline'){
	    	$layout = 1;
	    }elseif($attributes['layout'] == 'popup'){
	    	$layout = 2;
	    }else{
	    	$layout = 1;
	    }
		$this->currency_code = self::get_currency_code();
		$this->distance_unit = self::get_distance_unit();
		$this->success_message = self::get_success_message();

		if($layout==1){ //Inline Map public
			$this->view = 'partials/tq-pro-inline-display.php';
		}else{ //business_qoute
			$this->view = 'partials/tq-pro-popup-display.php';
		};
		
		ob_start();
	   	include $this->view;
	   	return ob_get_clean();
	}	



	function process_paypal_request(){
		// page is being requested after paypal redirects customer back to the website
		$this->paypal = new CT_PayPal(array('cdb'=>$this->cdb,
											'sandbox'=>self::get_setting('tq_pro_paypal_options', 'sandbox', 1)));
		$this->payment_status_type_id = $this->paypal->process_paypal_return();
		$this->job_id = $this->paypal->get_transaction_id();
		if(empty($this->job_id)){
			$this->ajax->log_error(array('name'=>'Paypal return error','value'=>'No job id returned from PayPal'));
			return false;
		};

		if(!self::update_payment_status_id($this->job_id, $this->payment_status_type_id)){
			self::debug('could not update payment_status');
			return false;
		};

		$this->job = self::get_job($this->job_id);
		if($this->job===false){
			$this->ajax->log_error(array('name'=>'Could not load job to update',
                'value'=>'job_id: '.$job['id']));
            return false;				
		};	

		if(self::job_is_available()){
			$this->job = self::get_job_details($this->job);
		};
		//get text payment status message
		$payment_status = $this->paypal->get_payment_status($this->job);

		if(!self::email_dispatch('Delivery Update: '.$this->customer['first_name']." ".$this->customer['last_name'].' PayPal '.$payment_status)){
			$this->ajax->log_error(array('name'=>'Unable to email dispatch',
                'value'=>'job_id: '.$job['id']));
		};

		$this->view = $this->paypal_partials_dir.'payment_result.php';
		return true;
	}

	private function check_payment_status_type_id($payment_status_type_id){
		if(empty($payment_status_type_id)){
			$payment_status_type_id = $this->payment_status_type_id;
		};
		if(empty($payment_status_type_id)){
			return false;
		};
		return $payment_status_type_id;
	}

	private function get_result_class($payment_status_type_id = null){
		$payment_status_type_id = self::check_payment_status_type_id($payment_status_type_id);

		switch ($payment_status_type_id) {
			case 2:
				$result_class = 'success';
				break;
			case 3:
				$result_class = 'failed';
				break;
			case 4:
				$result_class = 'pending';
				break;
			default:
				$result_class = 'error';
				break;
		};
		return $result_class;
	}

	private function get_result_title($payment_status_type_id = null){
		$payment_status_type_id = self::check_payment_status_type_id($payment_status_type_id);
		switch ($payment_status_type_id) {
			case 2:
				$result_title = 'Thank You. Your Payment Has Been Recieved Successfully.';
				break;
			case 3:
				$result_title = 'Sorry, there was a problem processing your payment.';
				break;
			case 4:
				$result_title = 'Thank You. PayPal is Processing Your Payment .';
				break;
			default:
				$result_title = 'Sorry, there was a problem processing your payment.';
				break;
		};
		return $result_title;
	}

	private function get_result_message($payment_status_type_id = null){
		$payment_status_type_id = self::check_payment_status_type_id($payment_status_type_id);
		switch ($payment_status_type_id) {
			case 2:
				$result_message = 'Your job has now been booked.';
				break;
			case 3:
				$result_message = 'Please check your PayPal account for more information.';
				break;
			case 4:
				$result_message = 'Your job will be booked as soon as PayPal notifies us of the completed payment.';
				break;
			default:
				$result_message = 'Please contact support for assistance.';
				break;
		};
		return $result_message;
	}

	function get_paths_for_includes(){
		$file = dirname(dirname(__FILE__)) . '/tq-pro.php';
		$this->plugin_root_dir = plugin_dir_path($file);
		$this->paypal_partials_dir = $this->plugin_root_dir.'includes/ct-payment-pp/partials/';
	}

	public function get_service_name($service_id = null){
		//get service name from id
		if(empty($service_id)){
			//return 'No service id for job';
			return false;
		};

		if(!isset($this->services[$service_id])){
			//return "no service_id: ".$service_id.print_r($this->services, true);
			return false;
		};

		if(!isset($this->services[$service_id]['name'])){
			//return "no name for service_id: ".$service_id.print_r($this->services, true);
			return false;
		};

		return $this->services[$service_id]['name'];
	}

	public function get_services(){
		//return services which have rates set
		$services = $this->cdb->get_rows('services');
		return $services;

	}

	public function get_services_with_rates(){
		//return services which have rates set
		$services = $this->cdb->get_rows('services',array(), 
										array('id','name','description'),
										array('rates'=>array('rates', 'service_id','id'))
										);
		return $services;

	}

	public function get_vehicle_name($vehicle_id = null){
		//get service name from id
		if(empty($vehicle_id)){
			return false;
		};

		if(!isset($this->vehicles)){
			return false;
		};

		if(empty($this->vehicles)){
			return false;
		};

		if(!isset($this->vehicles[$vehicle_id])){
			return false;
		};

		if(!isset($this->vehicles[$vehicle_id]['name'])){
			return false;
		};

		return $this->vehicles[$vehicle_id]['name'];
	}

	public function get_vehicles(){
		//return services which have rates set
		$vehicles = $this->cdb->get_rows('vehicles');

		return $vehicles;
	}

	public function get_vehicles_with_rates(){
		//return services which have rates set
		$vehicles = $this->cdb->get_rows('vehicles',array(), 
										array('id','name','description'),
										array('rates'=>array('rates', 'vehicle_id','id'))
										);

		return $vehicles;
	}

	public function has_services(){
		// is there more than one service?

		// is there more than one services in the services table?
		if($this->cdb->get_count('services') > 1){
			// do we have rates for more than one service in the rates table?
			if($this->cdb->get_count_distinct('rates', 'service_id')>1){
				return true;
			};
		};
		return false;
	}

	public function has_vehicles(){
		// is there more than one vehicle?
		if($this->cdb->get_count('vehicles') > 1){
			// do we have rates for more than one service in the rates table?
			if($this->cdb->get_count_distinct('rates', 'vehicle_id')>1){
				return true;
			};
		};
		return false;
	}

	/*** Front end ajax methods ***/
	public function tq_pro_save_job_callback(){
		$this->plugin = new TransitQuote_Pro();	
		$this->cdb = $this->plugin->get_custom_db();
		$this->ajax = new TransitQuote_Pro3\CT_AJAX(array('cdb'=>$this->cdb, 'debugging'=>$this->debug));
		
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
				self::get_job_details_from_id($job_id);
				$response = self::request_payment_on_delivery($job_id);
				break;
			case 'pay_method_2':
				// PayPal
				self::get_job_details_from_id($job_id);
				$response = self::request_payment_paypal($job_id);
				break;
			case 'pay_method_3':
				// Stripe
				self::get_job_details_from_id($job_id);
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

	public function get_job_details_from_id($job_id){

		$this->job = self::get_job($job_id);
		if($this->job===false){
			$this->ajax->log_error(array('name'=>'Could not get job to update',
                'value'=>'job_id: '.$this->job['id']));
            return false;				
		};	

		if(self::job_is_available()){
			self::get_job_details($this->job);
		};		
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

		$this->quote = self::save('quotes');
		//$this->quote_surcharge_ids = self::save_surcharges($this->quote['id']);

		//To do: create a many to many address relationship with job with an order index
		//save job, passing id values not included in post data

		$this->job = self::save('jobs',null, array('customer_id'=>$this->customer['id'],
													'accepted_quote_id'=>$this->quote['id']));

		$this->save_journey();
		$this->journey_order = $this->get_journey_order_from_post_data();
		$this->save_locations();
		if(!$this->save_journeys_locations()){
			$message = 'Unable to save route information';
		};

		//default message
		$message ='Request booked successfully';
		
		if(self::job_is_available()){
			$this->job = self::get_job_details($this->job);
		};

		
		$email = self::email_dispatch('New Removal Request: '.$this->customer['first_name']." ".$this->customer['last_name']);
		$customer_email = self::email_customer();

		return array('success'=>'true',
							 'msg'=>$message,
							 'data'=>array('customer_id'=>$this->customer['id'],
							 				'job_id'=>$this->job['id']));
		

	}

	private function save_journey(){
		//a job could potentially have multiple journeys so save job id against table
		$this->journey = self::save('journeys',null,array('job_id'=>$this->job['id']));
	}

	function get_journey_order_from_post_data(){
		// build array of address post field indexes in order of journey_order
		$journey_order = array();
		foreach($_POST as $key => $value) {
	    	if(strpos($key, 'journey_order')) {
	    		// key example: address_1_journey_order
	    		$key_array = explode('_', $key);
	    		$address_index = $key_array[1];
		        $journey_order[$value] = $address_index;
	    	}
		};
		return $journey_order;
	}

	private function load_journey_locations(){
		// load all locations in journey
		$this->locations_in_journey_order = array();
		foreach ($this->journey_order as $key => $journey_stop) {
			$location = $this->load_location($journey_stop['location_id']);
			if($location === false){
				self::debug('Unable to save location: '.$address_index);
				return false;
			};
			// store ids in array ready for save
			$this->locations_in_journey_order[$key] = array('location'=> $location,
															'journey_id' => $journey_stop['journey_id'],
															'location_id'=> $journey_stop['location_id'],
															'journey_order'=>$key,
															'created'=>date('Y-m-d G:i:s'),
															'modified'=>date('Y-m-d G:i:s'));
		};
	}

	private function load_location($location_id){
		return $this->cdb->get_row('locations', $location_id);
	}

	private function save_locations(){
		// save all locations in journey
		$this->locations_in_journey_order = array();
		foreach ($this->journey_order as $key => $address_index) {
			$location = $this->save_location($address_index);
			if($location === false){
				self::debug('Unable to save location: '.$address_index);
				return false;
			};
			// store ids in array ready for save
			$this->locations_in_journey_order[$key] = array('journey_id' => $this->journey['id'],
															'location_id'=> $location['id'],
															'journey_order'=>$key,
															'created'=>date('Y-m-d G:i:s'),
															'modified'=>date('Y-m-d G:i:s'));
		};

	}

	private function save_location($address_index){

		$record_data = self::get_location_record_data('locations', $address_index);
		$location_id = self::get_location_by_address($record_data);
		if(empty($location_id)){
			//no match, create new location in database
			$location_id = self::save_record('locations', $record_data);
			if($location_id===false){
				return false;
			};
			// add new id to array of location details
			$location['id'] = $location_id;
		} else {

			//existing location
			$location = $this->cdb->get_row('locations', $location_id);
		};

		if(empty($location)){
			return false;
		};

		return $location;
	}

 	private function get_location_record_data($table, $idx = null){
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
					$record_data[$field] = date('Y-m-d G:i:s');
					break;
				default:
					$param_name = 'address'.$idx_str.'_'.$field;
					$val = $this->ajax->param(array('name'=>$param_name, 'optional'=>true));
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
		$location = $this->cdb->get_rows('locations',$query,
									array('id'));

		if(empty($location)){
			return false;
		};
		
		return $location[0]['id'];
		
	}

	private function load_journey_order($journey_id){

		$this->journey_order = $this->cdb->get_rows('journeys_locations',
																array('journey_id'=>$journey_id),
																array(),
																null,
																array('journey_order'=>'asc')
															);


	}

	private function save_journeys_locations(){
		// save all locations in journey
		foreach ($this->locations_in_journey_order as $key => $step) {
			$row_id = self::save_record('journeys_locations', $step);
			if($row_id===false){
				self::debug(array('msg'=>'Unable to save journeys_locations: '.$key,
									'data'=>$step));
				return false;
			}
		}				
	}
	/*
		Payment Methods After Recieving Quote 
	*/
	private function request_payment_on_delivery($job_id = null){
		if(empty($job_id)){
			return array('success'=>'false',
							 'msg'=>'No job_id for payment on delivery');
		};

		if(!self::update_payment_type_id($job_id, 1)){
			self::debug('could not update payment_type');
			return false;
		};

		//set payment status to 1 = Awaiting Payment
		if(!self::update_payment_status_id($job_id, 1)){
			return array('success'=>'false',
							 'msg'=>'Unable to update job '.$job_id.' to payment on delivery');
		};

		return array(	'success'=>'true',
						'success_message'=>'<h2>Thank You.</h2><p>Your job has now been booked with payment due on delivery.<br/>Your reference number is: '.$job_id.'</p>',
					 	'payment_method'=>1);

	}

	private function request_payment_paypal($job_id = null){
		if(empty($job_id)){
			return array('success'=>'false',
							 'msg'=>'No job_id for payment by PayPal');
		};

		if(!self::update_payment_type_id($job_id, 2)){
			self::debug('could not update payment_type');
			return false;
		};

		$paypal_return_url = $this->ajax->param(array('name'=>'return_url'));

		//set payment status to 1 = Awaiting Payment
		if(!self::update_payment_status_id($job_id, 1)){
			return array('success'=>'false',
							 'msg'=>'Unable to update job '.$job_id.' to payment by paypal');
		};

		return array('success'=>'true',
					 'msg'=>'Job booked successfully',
					 'data'=>array('customer_id'=>$this->customer['id'],
					 				'job_id'=>$this->job['id'],
					 				'quote_id'=>$this->quote['id'],
					 				'email'=>$this->customer['email']),
					 'payment_method'=>2);

	}

	private function request_payment_stripe($job_id = null){
		if(empty($job_id)){
			return array('success'=>'false',
							 'msg'=>'No job_id for payment by stripe');
		};

		if(!self::update_payment_type_id($job_id, 3)){
			self::debug('could not update payment_type');
			return false;
		};

		//set payment status to 1 = Awaiting Payment
		if(!self::update_payment_status_id($job_id, 1)){
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
	
 	public function get_job($job_id = null){
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

    function job_is_available($job = null){
    	if(empty($job)){
    		$job = $this->job;
    	}; 

    	if(empty($job)){	
    		return false;
    	};
    	return true;
    }

	public function get_job_details($job = null){
		$plugin = new TransitQuote_Pro();	
		$this->cdb = $plugin->get_custom_db();
		//add the details to a job record

		$job['customer'] = $this->customer = self::get_customer($job['customer_id']);
		$job['journey'] = $this->journey = self::get_journey_by_job_id($job['id']);
		$job['stops'] = self::get_journey_stops($job['journey']['id']);
		self::load_journey_order($job['journey']['id']);
		self::load_journey_locations();

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

	public function get_customer($customer_id){
		$customer = $this->cdb->get_row('customers', $customer_id);
		if($customer===false){
			self::debug(array('name'=>'get_customer:Could not load customer',
                            'value'=>'customer_id: '.$customer_id));
		};
		return $customer;
	}

	public function get_journey_by_job_id($job_id){

		$journey = $this->cdb->get_row('journeys', $job_id, 'job_id');
		if($journey===false){
			self::debug(array('name'=>'Could not load journey',
                            'value'=>'job_id: '.$job_id));
		};
		return $journey;
	}

	function get_journey_stops($journey_id = null){
    	return $this->cdb->get_rows('locations', 
    								array(), 
						    		array('id',
										'address',
										'appartment_no',
										'street_number',
										'postal_town',
										'route',
										'administrative_area_level_2',
										'administrative_area_level_1',
										'country',
										'postal_code',
										'lat',
										'lng'),
						    		array(
					    				array('journeys_locations',
					    					'location_id',
					    					'id',
					    					'journey_id = '.$journey_id,
					    					'inner')
						    			),
						    			array('journey_order'=>'asc')
						    		);
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

    	if(empty($job['delivery_time'])){
    		self::debug('No delivery_time');
    		var_dump($job);
    		return '';
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
        return self::get_setting($this->tab_2_settings_key, 'layout', 'inline');
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
	
	public function get_customer_email(){
        return $this->customer['email'];
    }

    public function test_customer_email($job_id){
    	$this->job = self::get_job($job_id);
   		
		//get details for the job
		if(self::job_is_available()){
			$this->job = self::get_job_details($this->job);
		};	

		$message = self::get_customer_message();

		ob_start();
		include 'partials/emails/email_customer.php'; 
		$html_email = ob_get_clean();

		echo $html_email;
    }

    public function test_dispatch_email($job_id){
    	$this->job = self::get_job($job_id);
   		
		//get details for the job
		if(self::job_is_available()){
			$this->job = self::get_job_details($this->job);
		};			

		ob_start();
		include 'partials/emails/email_job_details.php'; 
		$html_email = ob_get_clean();

		echo $html_email;
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

		return $email;
	}
	public function get_api_string(){
		$api_string = '';
		$this->api_key = self::get_api_key();
		if(!empty($this->api_key)){
			$api_string = '&key='.$this->api_key;
		};

		return $api_string;
	}
	public function get_api_key(){
		//get google maps api key
		$this->api_key = self::get_setting($this->tab_2_settings_key, 'api_key', '');
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
    	$plugin = new TransitQuote_Pro();
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

 	private function get_return(){
        // get return address, note this only works when included not when called via ajax
        $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        if(strpos($url, '?')>-1){
        	$glue = '&';
        } else {
        	$glue = '?';
        };
        return 'http://'.$url.$glue.'action=paypal';
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
    	$this->currency = self::get_currency();
    	if(empty($this->currency)){
    		return false;
    	};
    	$this->currency_code = $this->cdb->get_field('currencies', 'currency_code', $this->currency);
        return $this->currency_code;
    }

	public function get_oldest_job_date(){
		$plugin = new TransitQuote_Pro();
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
		if(empty($this->settings)){
			self::load_settings();			
		};
		//get and escape setting
		if(empty($this->settings[$name])){
			return $default;
		} else {
			return esc_attr($this->settings[$name]);
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
		$services = self::get_services();
		$this->services = $this->index_array_by_db_id($services);

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
			/*	case 'move_size_id':
					$field['label'] = 'Move Size';
					$field['value'] = '';
					switch ($job['service_id']) {
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
					break;					*/
				case 'service_id':
					if(self::using_service_types($value)){
						$out[] = self::format_service_type($value);
					};
					break;								
				default:
					break;
			};			
		};
		return $out;
	}

	public function index_array_by_db_id($array){
		$indexed_array = array();
		foreach ($array as $key => $record) {
			$indexed_array[$record['id']] = $record;
		}
		return $indexed_array;
	}

	private function format_service_type($value){
		$field = array('label' => 'Service');
		$service_name = '';
		if(isset($this->services[$value])){
			$service_name = $this->services[$value]['name'];
		};
		$field['value'] = $service_name;
		return $field;
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

	public function using_service_types($value){
		if(empty($value)){
			return false;
		};
		return true;
	}

	public function render_route_details($waypoints){
		$route_row_data = array();
		foreach ($waypoints as $key => $waypoint) {
			$route_row_data[] = array('value'=>$this->format_waypoint($waypoint));
		};

		return $this->job_details_table('<h3>Route</h3>',$route_row_data);
	}

	public function route_details_list(){
		$route_row_data = array();
		foreach ($this->locations_in_journey_order as $key => $waypoint) {
			switch ($waypoint['journey_order']) {
				case '0':
					$route_row_data[] = array('value'=>'Collect From:');
					$route_row_data[] = array('value'=>$this->format_waypoint_list($waypoint['location']));
					break;
				default:
					$route_row_data[] = array('value'=>'Drop Off:');
					$route_row_data[] = array('value'=>$this->format_waypoint_list($waypoint['location']));
					break;
			}
			
		};

		return $this->email_details_list('Route',$route_row_data);
	}

	public function email_details_list($header, $data){
		//return job details info in list for text email
		$text = $header."\r\n\r\n";
		$rows = array();
		foreach ($data as $field) {
			if(!empty($field['value'])){
				if(empty($field['label'])){
					$rows[] = $field['value'];
				} else {
					$rows[] = $field['label'].': '.$field['value'];
				}
			}
		};
		$text .= implode("\r\n", $rows);
		echo $text."\r\n";
	}

	private function format_waypoint($waypoint){
		$html ='<ul>';
		if(!empty($waypoint['appartment_no'])){
			$html .='<li>Unit: '.$waypoint['appartment_no'].'</li>';
		};
		$html .='<li>Address: '.stripslashes($waypoint['address']).'</li>';
		if(!empty($waypoint['postal_code'])){
			$html .='<li>Postcode: '.$waypoint['postal_code'].'</li>';
		};
		$html .='</ul>';

		return $html;
	}

	private function format_waypoint_list($waypoint){
		$text ="";
		if(!empty($waypoint['appartment_no'])){
			$text .="Unit: ".$waypoint['appartment_no']."\r\n";
		};
		$text .="Address: ".stripslashes($waypoint['address'])."\r\n";
		if(!empty($waypoint['postal_code'])){
			$text .="Postcode: ".$waypoint['postal_code']."\r\n";
		};

		return $text;
	}

	public function render_service_options($selected_id = 1){
		// get list of services from db
		$services = $this->get_services();
		return $this->render_select_options($services, $selected_id);
	}

	public function render_service_options_with_rates($selected_id = 1){
		// get list of services from db
		$services = $this->get_services_with_rates();
		return $this->render_select_options($services, $selected_id);
	}

	public function render_vehicle_options($selected_id = 1){
		// get list of vehicles from db
		$vehicles = $this->get_vehicles();
		return $this->render_select_options($vehicles, $selected_id);
	}

	public function render_vehicle_options_with_rates($selected_id = 1){
		// get list of vehicles from db
		$vehicles = $this->get_vehicles_with_rates();
		return $this->render_select_options($vehicles, $selected_id);
	}

	public function render_select_options($options = null, $selected_id = null){
		if(empty($options)){
			return false;
		};

		if(!is_array($options)){
			return false;
		};

		// loop through list
		foreach ($options as $key => $option) {
			// set selected attribute if item is selected
			$selected = ($option['id']==$selected_id) ? 'selected="selected" ' : '';
			echo '<option value="'.$option['id'].'" '.$selected.'>'.$option['name'].'</option>';
		}
	}

	public function render_vehicle_descriptions(){
		// render all vehicle descriptions so they can be hidden or shown as option changes

		$descriptions_html = '';
		$style_attribute = '';
		$vehicles = $this->cdb->get_rows('vehicles');
		foreach ($vehicles as $key => $vehicle) {
			if($key>0){
				$style_attribute = ' style="display: none;" ';
			};
			$descriptions_html .= '<p class="select-desc v-desc-'.$vehicle['id'].'" '.$style_attribute.'>'.$vehicle['description'].'</p>';
		}

		echo $descriptions_html;
	}

	public function update_job_status($job_id, $status_type_id){
		if(empty($job_id)){
			return false;
		};

		if(empty($status_type_id)){
			return false;
		};

		$this->job = self::get_job($job_id);
   		

		$this->job['status_type_id'] = $status_type_id;
		$success = self::save_record('jobs', $this->job);
		if($success===false){
			return false;
		}

		//get details for the job
   		self::get_job_details($this->job);		

		//status updated ok, send email
		$subject = self::get_status_subject($status_type_id, $job_id);
		$notify = false;
		if($this->job['status_type_id']!==1){
			$notify = true;
		};
		self::email_dispatch($subject, $notify);

		return true;
	}

	private function get_status_subject($status_type_id = null, $job_id = null){
		if(empty($job_id)){
			//use current job if none is passed
			$job = $this->job;
		} else {
			//get job for passed id
			$job = self::get_job($job_id);
		};

		if(empty($job)){
			//job id not valide
			return false;
		};

		$status_type_rec = self::get_status_type($status_type_id);
   		if(empty($status_type_rec)){
   			//status type
   			return false;
   		};

   		//create email subject
   		$customer = trim($this->customer['first_name']." ".$this->customer['last_name']);
   		$assigned = self::get_assigned($job);
   		if($assigned===false){
   			$assigned = ' - Not Assigned';
   		} else {
   			$assigned = ' - '.$assigned['name'];
   		};
   		$subject = 'Delivery for '.$customer.' '.$status_type_rec['name'].$assigned;

   		return $subject;
   	}

	private function get_status_type($status_type_id = null){
		//get the status type record for an id
   		if(empty($status_type_id)){
   			return false;
   		};
   		if(empty($this->status_types[$status_type_id])){
   			return false;
   		};
   		return $this->status_types[$status_type_id];
   	}

	private function get_status_types(){
		$status_types = $this->cdb->get_rows('status_types');
		$status_types_indexed = array();
		foreach ($status_types as $key => $status_type) {
			$status_types_indexed[$status_type['id']] = $status_type;
		}
		//$this->ajax->pa($vehicles);
		return $status_types_indexed;				
	}

	/**
	 * Update Payment Status Column in jobs 
	 *	 
	 * @since    1.0.0
	 */	
	private function update_payment_status_id($job_id, $payment_status_id){
		if(empty($job_id)){
			self::debug('update_payment_status_id: No job_id');
			return false;
		};

		if(empty($payment_status_id)){
			self::debug('payment_status_id: No payment_status_id');
			return false;
		};

		// update the payment status to the selected type in the db and update the job object
		$this->job = $this->cdb->update_field('jobs','payment_status_id', $payment_status_id, $job_id);
		if($this->job===false){
			return false;
		};
		return true;

	}

	/**
	 * Update Payment Type Column in jobs 
	 *	 
	 * @since    1.0.0
	 */	
	private function update_payment_type_id($job_id, $payment_type_id){
		if(empty($job_id)){
			self::debug('update_payment_type_id: No job_id');
			return false;
		};

		if(empty($payment_type_id)){
			self::debug('update_payment_type_id: No update_payment_type_id');
			return false;
		};

		// update the payment status to the selected type in the db and update the job object
		$this->job = $this->cdb->update_field('jobs','payment_type_id', $payment_type_id, $job_id);
		if($this->job===false){
			return false;
		};
		return true;

	}	
}
