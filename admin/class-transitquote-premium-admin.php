<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 * @author     Your Name <email@example.com>
 */
class TransitQuote_Premium_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	private $plugin_slug;
	protected $plugin_screen_hook_suffix = null;

    private $tab_1_settings_key = 'premium_rates';
	private $tab_2_settings_key = 'premium_quote_options';
	private $tab_3_settings_key = 'premium_customers';
	private $tab_4_settings_key = 'premium_transportation_requests';
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_slug ) {
		$this->plugin_name = $plugin_name;
		$this->plugin_slug = $plugin_slug;
		$this->version = $version;
		$this->plugin = new TransitQuote_Premium_Public($plugin_name,  $version, $plugin_slug);
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * @TODO:
		 *
		 * - Change 'Page Title' to the title of your plugin admin page
		 * - Change 'Menu Text' to the text for menu item for the plugin settings page
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */
		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'TransitQuote Premium', $this->plugin_slug ),
			__( 'TransitQuote Premium', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_admin_page() {
		include_once( 'partials/transitquote-premium-admin-display.php' );
	}


	/**
	 * Initialize plugin settings.
	 *
	 * @since    1.0.0
	 */
	public function settings_admin_init() {
		$this->ajax = new TransitQuote_Premium\CT_AJAX();
		$this->cdb = TransitQuote_Premium::get_custom_db();
		$this->dbui = new TransitQuote_Premium\CT_DBUI(array('cdb'=>$this->cdb));
		self::register_tab_4_settings();		
		self::register_tab_1_settings();
		self::register_tab_2_settings();
		self::register_tab_3_settings();
		self::register_tab_5_settings();
		self::register_tab_6_settings();
		$this->plugin->load_settings();
	}

	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 * @since    1.0.0
	 */

	public function plugin_options_tabs() {
         $this->current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->tab_1_settings_key;
         //if url is not pointing to a tab, set to default
         if(!array_key_exists($this->current_tab, $this->plugin_settings_tabs)){
			$this->current_tab = $this->tab_4_settings_key;
         };
         screen_icon();
         echo '<h2 class="nav-tab-wrapper">';
         foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
             $active = $this->current_tab == $tab_key ? 'nav-tab-active' : '';
             echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_slug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
         }
         echo '<div class="spinner"></div></h2>';
    }

	function register_tab_1_settings(){
		$this->plugin_settings_tabs[$this->tab_1_settings_key] = 'Rates'; //Tab name
		register_setting( $this->tab_1_settings_key, $this->tab_1_settings_key ); //register settings for tab
	    add_settings_section( 'premium_rates', 'Rates',  array( $this, 'rates_callback' ), $this->tab_1_settings_key);
	}
	function rates_callback(){
		$this->distance_unit = $this->plugin->get_setting('premium_quote_options', 'distance_unit', 'Kilometer');
		$help = '<p>Rates are either a set price up to a maximum driving distance, a price per mile or km travelled, a price per each hour of travel time or a combination of both.</p>'.
				'<p>Prices will be used for distances up to the Max Distance entered below.</p>'.
				'<p>You can set multiple rates depending on the Max Distance, for example $2 per mile for up to Max Distance 20 miles and then $4 per mile for up to Max Distance 40 miles.</p>'.
				'<p>Enter a rate with Max Distance 0 to calculate the rate for journeys over the highest distance boundary.</p>'.
				'<p>For flats rate without any distance boundaries set Max Distance to 0 only.</p>';

		echo $help;
	}
	function register_tab_2_settings(){
		$this->plugin_settings_tabs[$this->tab_2_settings_key] = 'Quote Options'; //Tab name
		register_setting( $this->tab_2_settings_key, $this->tab_2_settings_key ); //register settings for tab
	    add_settings_section( 'premium_quote_options', 'Quote Options',  array( $this, 'premium_quote_options_callback' ), $this->tab_2_settings_key);
   	    add_settings_field( 'success_message', 'Success Message',  array( $this, 'success_message_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'min_notice', 'Minimum Notice Period',  array( $this, 'min_notice_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'min_notice_charge', 'Minimum Notice Charge',  array( $this, 'min_notice_charge_callback' ), $this->tab_2_settings_key, 'premium_quote_options');   	    
   	    add_settings_field( 'currency', 'Currency Symbol',  array( $this, 'currency_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'quote_element', 'Quote Display Element',  array( $this, 'quote_element_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'distance_unit', 'Distance Unit',  array( $this, 'distance_unit_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'layout', 'Layout',  array( $this, 'layout_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'start_location', 'Start Location',  array( $this, 'start_location_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'geolocate', 'Geolocation',  array( $this, 'geolocate_callback' ), $this->tab_2_settings_key, 'premium_quote_options');
   	    add_settings_field( 'api_key', 'API Key',  array( $this, 'api_key_callback' ), $this->tab_2_settings_key, 'premium_quote_options' );
	}
	function min_notice_callback(){
		$value = $this->plugin->get_setting('premium_quote_options', 'min_notice', '24:00');
		echo '<input type="text" name="'.$this->tab_2_settings_key.'[min_notice]" value="'.$value.'"/>';
		echo "<p>Please enter minimum notice period before which an additional charge is incurred.</p>";
	}
	function min_notice_charge_callback(){
		$value = $this->plugin->get_setting('premium_quote_options', 'min_notice_charge', '200');
		echo '<input type="text" name="'.$this->tab_2_settings_key.'[min_notice_charge]" value="'.$value.'"/>';
		echo "<p>Please enter the additional charge in dollars for jobs booked within 24 hours..</p>";
	}
	function currency_callback(){
		$value = $this->plugin->get_currency();
		echo '<input type="text" name="'.$this->tab_2_settings_key.'[currency]" value="'.$value.'"/>';
		echo "<p>Please enter the currency symbol or text to display. For example: £, $, GBP, USD etc..</p>";
	}
	function quote_element_callback(){
		$value = $this->plugin->get_setting('premium_quote_options', 'quote_element', 'quote');
		echo '<input type="text" name="'.$this->tab_2_settings_key.'[quote_element]" value="'.$value.'"/>';
		echo "<p>Please enter the class or id of the html element in which to display the final quote.</p>".
			"<p>Note that by specifying a class you can have the quote amount appear in multiple elements such as a visible element for displaying to the customer and a hidden form element for saving the amount.</p>";
	}
	function distance_unit_callback(){
		$value =  $this->plugin->get_distance_unit();
		if($value=='Kilometer'){
			$km_selected = 'selected="selected"';
			$m_selected = '';
		} else {
			$m_selected = 'selected="selected"';
			$km_selected = '';
		};
		echo '<select name="'.$this->tab_2_settings_key.'[distance_unit]">';
		echo '<option '.$km_selected.'>Kilometer</option><option '.$m_selected.'>Mile</option></select>';
		echo '<p>Please choose the distance unit to use for the quote calculation.</p>';
	}
	function start_location_callback(){
		include_once( 'partials/place_selector.php' );
	}
	function geolocate_callback(){
		$value = $this->plugin->get_geolocate();
		echo '<label for "'.$this->tab_2_settings_key.'[geolocate]['.$value.']">Detect Location</label>';
		echo '<input type="checkbox" id="geolocate"  name="'.$this->tab_2_settings_key.'[geolocate]" value="1" '.checked( 1 == $value,true,false).'/>';
		echo '<p>Choose whether to attempt to detect the customers location to determine the location displayed on the map.</p>';		
	}
	public function api_key_callback() {
	    $value = $this->plugin->get_setting($this->tab_2_settings_key, 'api_key');
		echo '<label for="'.$this->tab_2_settings_key.'[api_key]">Google Maps API Key:</label>';
		echo '<input type="text" name="'.$this->tab_2_settings_key.'[api_key]" value="'.$value.'"/><br/>';
		echo '<p>The API Key is only valid on your registered domain so this field should only be populated in the live environment.</p>';
	}	
	function success_message_callback(){
		$value = $this->plugin->get_success_message();
		echo '<textarea class="wide" name="'.$this->tab_2_settings_key.'[success_message]">'.$value.'</textarea>';
		echo "<p>Please enter the message that will be displayed to the customer after their quote has been saved and displayed on screen.<br/>This should explain any next steps they must take to confirm their booking.</p>";
	}
	function layout_callback() {	 
	    $options = get_option( $this->tab_2_settings_key );
	    $html = '<input type="radio" id="radio_example_one" name="'.$this->tab_2_settings_key.'[layout]" value="1"' . checked( 1, $options['layout'], false ) . '/>';
	    $html .= '<label for="radio_example_one">Inline Map</label>&nbsp;&nbsp;&nbsp;';	     
	    $html .= '<input type="radio" id="radio_example_two" name="'.$this->tab_2_settings_key.'[layout]" value="2"' . checked( 2, $options['layout'], false ) . '/>';
	    $html .= '<label for="radio_example_two">Pop-Up Map</label>';	     
	    $html .= "<p>Please select which format you want to display for map.</p>";	     
	    echo $html;	 
	}
	function premium_quote_options_callback(){
	}
	function register_tab_3_settings(){

		// Define name displayed on tab
		$this->plugin_settings_tabs[$this->tab_3_settings_key] = 'Customers';

		// Register settings for tab with the settings API
		register_setting( $this->tab_3_settings_key, $this->tab_3_settings_key ); 

		// Add settings section for this tab including a callback function to display tab content
	    add_settings_section( 'premium_customers', 'Customers',  array( $this, 'customers_callback' ), $this->tab_3_settings_key);
	}
	function customers_callback(){
		//get the no of customers to determine whether to show empty message or loading message
		$this->customer_count = $this->cdb->get_count('customers');
		if($this->customer_count == 0){
			$this->empty_message = 'There are no customers in the database yet.';
		} else {
			$this->empty_message = 'Loading customers...';
		};
		$help = '<p>All customers who have previously requested transportation are listed here.</p>';
		echo $help;
	}
	function register_tab_4_settings(){
		$this->plugin_settings_tabs[$this->tab_4_settings_key] = 'Jobs'; //Tab name
		register_setting( $this->tab_4_settings_key, $this->tab_4_settings_key ); //register settings for tab
	    add_settings_section( 'premium_jobs', 'Jobs',  array( $this, 'jobs_callback' ), $this->tab_4_settings_key);
	}
	function jobs_callback(){
		$this->jobs_count = $this->cdb->get_count('jobs');
		if($this->jobs_count == 0){
			$this->empty_message = 'There are no jobs in the database yet.';
		} else {
			$this->empty_message = 'Loading jobs list...';
		};		
		$help = '<p>All jobs are listed below. Click on a job to show the full details.</p>';
		echo $help;
	}
	function register_tab_5_settings(){

		$this->plugin_settings_tabs[$this->tab_5_settings_key] = 'Email Options'; //Tab name
		register_setting( $this->tab_5_settings_key, $this->tab_5_settings_key ); //register settings for tab
	    add_settings_section( 'premium_email_options', 'Emails Options',  array( $this, 'email_options_callback' ), $this->tab_5_settings_key);

 		add_settings_field( 'notify', 'Send New Job Emails To',  array( $this, 'notify_callback' ), $this->tab_5_settings_key, 'premium_email_options');
	   	add_settings_field( 'from_address', 'Reply Address for Customer Quote Emails',  array( $this, 'from_address_callback' ), $this->tab_5_settings_key, 'premium_email_options');
	   	add_settings_field( 'from_name', 'Contact Name for Customer Quote Emails',  array( $this, 'from_name_callback' ), $this->tab_5_settings_key, 'premium_email_options');
	   	add_settings_field( 'customer_subject', 'Customer Quote Email Subject',  array( $this, 'customer_subject_callback' ), $this->tab_5_settings_key, 'premium_email_options');
	   	add_settings_field( 'customer_message', 'Customer Quote Email Message',  array( $this, 'customer_message_callback' ), $this->tab_5_settings_key, 'premium_email_options');
   	}
	function email_options_callback(){
	}
	function notify_callback(){
		$value = $this->plugin->get_notification_emails();
		echo '<input class="wide" type="text" name="'.$this->tab_5_settings_key.'[notify]" value="'.$value.'"/>';
		echo "<p>Please enter the email addresses that will recieve new job requests. You can enter more than one by separating them with a comma.<br/>Example: <b>boss@mycompany.com, staff@mycompany.com</b></p>";
	}
	function from_address_callback(){
		$value = $this->plugin->get_from_address();
		echo '<input class="wide" type="text" name="'.$this->tab_5_settings_key.'[from_address]" value="'.$value.'"/>';
		echo "<p>Please enter the <em>From</em> email address that customers will recieve their quote emails from.<br/>Example: <b>customerservice@mycompany.com</b></p>";
	}
	function from_name_callback(){
		$value = $this->plugin->get_from_name();
		echo '<input class="wide" type="text" name="'.$this->tab_5_settings_key.'[from_name]" value="'.$value.'"/>';
		echo "<p>Please enter the contact name for the email address that customers will recieve their quote emails from.<br/>Example: <b>My Company Name</b> &ltcustomerservice@mycompany.com&gt;</p>";
	}
	function customer_subject_callback(){
		$value = $this->plugin->get_customer_subject();
		echo '<input class="wide" type="text" name="'.$this->tab_5_settings_key.'[customer_subject]" value="'.$value.'"/>';
		echo "<p>Please enter the email subject for customer quote emails.<br/>Example: <b>Your Tranporation Quote</b></p>";
	}
	function customer_message_callback(){
		$value = $this->plugin->get_customer_message();
		echo '<textarea class="wide" name="'.$this->tab_5_settings_key.'[customer_message]">'.$value.'</textarea>';
		echo "<p>Please enter the message to your customer that will appear above the journey details and quote.</p>";
	}


	function register_tab_6_settings(){

		$this->plugin_settings_tabs[$this->tab_6_settings_key] = 'PayPal Options'; //Tab name
		register_setting( $this->tab_6_settings_key, $this->tab_6_settings_key ); //register settings for tab
	    add_settings_section( 'premium_paypal_options', 'PayPal Options',  array( $this, 'paypal_options_callback' ), $this->tab_6_settings_key);

		add_settings_field( 'business_email', 'PayPal Email Address',  array( $this, 'business_email_callback' ), $this->tab_6_settings_key, 'premium_paypal_options');	
		add_settings_field( 'item_name', 'Item Name',  array( $this, 'item_name_callback' ), $this->tab_6_settings_key, 'premium_paypal_options');
		add_settings_field( 'endpoint', 'Live API Endpoint',  array( $this, 'endpoint_callback' ), $this->tab_6_settings_key, 'premium_paypal_options');
 		add_settings_field( 'sandbox', 'Use Sandbox/Testing Mode',  array( $this, 'sandbox_callback' ), $this->tab_6_settings_key, 'premium_paypal_options');
	   	add_settings_field( 'test_business_email', 'PayPal Test Email Address',  array( $this, 'test_business_email_callback' ), $this->tab_6_settings_key, 'premium_paypal_options');
	   	add_settings_field( 'sandbox_endpoint', 'Sandbox API Endpoint',  array( $this, 'sandbox_endpoint_callback' ), $this->tab_6_settings_key, 'premium_paypal_options');
   	}

	function paypal_options_callback(){

	}

	function endpoint_callback(){
		$value = $this->plugin->get_setting('premium_paypal_options', 'endpoint', 'https://www.paypal.com/uk/cgi-bin/webscr');
		echo '<input class="wide" type="text" name="'.$this->tab_6_settings_key.'[endpoint]" value="'.$value.'"/>';
		echo "<p>This is the PayPal URL  that live payment information is sent to. Changing this is not recommended.</p>";
	}

	function sandbox_callback(){
		$value = $this->plugin->get_setting('premium_paypal_options', 'sandbox');
	    echo '<input type="checkbox" name="'.$this->tab_6_settings_key.'[sandbox]" value="1" '.checked(1,$value,false).'/>Enable Sandbox/Test Mode.<br/>';
	    echo "<p>When this box is ticked all payments will be simulated using the PayPal sandbox website.</p>";
	}

	function sandbox_endpoint_callback(){
		$value = $this->plugin->get_setting('premium_paypal_options', 'sandbox_endpoint', 'https://www.sandbox.paypal.com/uk/cgi-bin/webscr');
		echo '<input class="wide" type="text" name="'.$this->tab_6_settings_key.'[sandbox_endpoint]" value="'.$value.'"/>';
		echo "<p>This is the PayPal URL that test payment information is sent to. Changing this is not recommended.</p>";
	}

	function business_email_callback(){
		$value = $this->plugin->get_setting('premium_paypal_options', 'business_email');
		echo '<input class="wide" type="text" name="'.$this->tab_6_settings_key.'[business_email]" value="'.$value.'"/>';
		echo "<p>This is the email address that you use to login to PayPal and accept payments.</p>";
	}

	function test_business_email_callback(){
		$value = $this->plugin->get_setting('premium_paypal_options', 'test_business_email');
		echo '<input class="wide" type="text" name="'.$this->tab_6_settings_key.'[test_business_email]" value="'.$value.'"/>';
		echo "<p>This is the email address that will be used to test payments in sandbox mode. This should be set up in your PayPal developer account if you would like a dummy PayPal account for testing payments. </p>";
	}

	function item_name_callback(){
		$value = $this->plugin->get_setting('premium_paypal_options', 'item_name', 'TransitQuote Payment');
		echo '<input class="wide" type="text" name="'.$this->tab_6_settings_key.'[item_name]" value="'.$value.'"/>';
		echo "<p>This is the item name that will be displayed in your PayPal account when a customer purchases one of your products.</p>";
	}

	/**
	 * Register the stylesheets for the admin area.
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
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/transitquote-premium-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			$this->api_key = $this->plugin->get_api_key();
			$this->start_place_name = $this->plugin->get_setting('premium_quote_options', 'start_place_name', 'Glasgow');
			$this->start_lat = $this->plugin->get_setting('premium_quote_options', 'start_lat','55.870853');
			$this->start_lng = $this->plugin->get_setting('premium_quote_options', 'start_lng', '-4.252036');
			$this->min_notice = $this->plugin->get_setting('premium_quote_options', 'min_notice', '24:00');
			$this->min_notice_charge = $this->plugin->get_setting('premium_quote_options', 'min_notice_charge', '200');
			$this->oldest_job_date = $this->plugin->get_oldest_job_date();
			$this->api_string = $this->plugin->get_api_string();
			
			$tq_settings = array('startLat'=>$this->start_lat,
								'startLng'=>$this->start_lng,
								'startPlaceName'=>$this->start_place_name,
								'oldestJobDate'=>$this->oldest_job_date
							);
			
			if(!empty($this->api_key)){
				$tq_settings['apiKey'] = $this->api_key;
			};
			wp_enqueue_script( $this->plugin_slug.'-gmapsapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places'.$this->api_string, '', 3.14, True );
			wp_enqueue_script( $this->plugin_slug.'-jqui', 'http://code.jquery.com/ui/1.10.4/jquery-ui.min.js', '', 1.10, True );
			wp_enqueue_script( $this->plugin_slug.'-jqui-maps', plugins_url( 'public/js/jquery.ui.map.js', dirname(__FILE__) ), array( 'jquery',$this->plugin_slug.'-jqui'), '', True );
			wp_enqueue_script( $this->plugin_slug.'-place-selector',plugins_url( '/js/place-selector.js', __FILE__ ) , array( 'jquery' ), '', True );

			wp_enqueue_script( $this->plugin_slug.'-admin-js', plugin_dir_url( __FILE__ ) . 'js/transitquote-premium-admin.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_slug.'-admin-mainscript', plugin_dir_url( __FILE__ ). 'js/transitquote-premium-admin-main.js', array( $this->plugin_slug.'-admin-js' ), $this->version, True );


			wp_localize_script( $this->plugin_slug . '-admin-mainscript', 'TransitQuotePremiumSettings', $tq_settings);


		}

	}










	private function debug($data = null){
		$this->plugin->debug($data);
	}
	public function get_job($job_id = null){
    	//get job record from property or database
    	if(empty($job_id)){
    		//no id passed so 
    		if(empty($this->job)){
    			/// no current job property so return false
    			return false;
    		};
			//return current job property if there is one
			return $this->job;
    	};
		//a job id has been passed so get the job record from the database
		return $this->cdb->get_row('jobs',$job_id);
    }

	function get_jobs($filters = null, $dates = null){

    	//current and future only
    	$clauses = array();/*"date(jobs.delivery_date) >= CURDATE() ",*/
    	$filter_sql = '';
    	/*if(!empty($filters)){
			foreach ($filters as $name => $values) {
	     		if(strpos($name, '.')==-1){
	     			//no table specified so filter jobs table
	    			$clauses[] = 'jobs.'.$name.' IN('.implode(',',$values).')';
	    		} else {
	    			if(is_array($values)){
	    				$clauses[] = $name.' IN('.implode(',',$values).')';
	    			} else {
	    				$clauses[] = $name.' IN('.$values.')';
	    			}
	    		}
	    	}

	    	$filter_sql = 'where '.implode(' AND ', $clauses);  	
    	};*/

    	if(!empty($dates)){
	    	$filter_sql .= " where date(jobs.created) <= '".$dates['to_date']."' and date(jobs.created) >= '".$dates['from_date']."'"; 
    	};    	

    	$sql = "SELECT	distinct jobs.id,
						jobs.delivery_contact_name,
						-- jobs.service_type_id,
						-- CASE service_type_id WHEN 1 THEN 'Commercial' ELSE 'Domestic' END as move_type,
						jobs.delivery_time,
						jobs.description,
						jobs.customer_id,
						jobs.accepted_quote_id,
						jobs.vehicle_type_id,
						jobs.payment_type_id,
						jobs.payment_status_type_id,
						jobs.created,
						jobs.modified,
						trim(concat(c.first_name,' ',c.last_name)) as last_name,
						ifnull(lo.address, '') as pick_up,
						ifnull(ld.address,'') as drop_off,
						v.name as vehicle_type,
						q.total as quote,
						pt.name as payment_type,
						pst.description as payment_status
					FROM wp_premium_tp_jobs jobs
						left join wp_premium_tp_journeys j 
							on jobs.id = j.job_id 
						left join wp_premium_tp_locations lo 
							on j.origin_location_id = lo.id 
						left join wp_premium_tp_locations ld 
							on j.dest_location_id = ld.id
						left join wp_premium_tp_customers c 
							on c.id = jobs.customer_id 
						left join wp_premium_tp_vehicle_types v 
							on v.id = jobs.vehicle_type_id 
						left join wp_premium_tp_quotes q 
							on q.id = jobs.accepted_quote_id
						left join wp_premium_tp_payment_types pt 
							on jobs.payment_type_id = pt.id
						left join wp_premium_tp_payment_status_types pst 
							on jobs.payment_status_type_id = pst.id 
			".$filter_sql." 
			order by jobs.id desc;";

		$data = $this->cdb->query($sql);
		return $data;
    }

	public function load_job_details_callback(){
		//get the job id for the post parameters
		$job_id = $this->ajax->param(array('name'=>'job_id', 'optional'=>false));

		//load the job record from the database
		$this->job = self::get_job($job_id);

		if($this->job===false){
			//couldnt find a job record
			$this->ajax->log_error(array('name'=>'Could not details for request',
                            'value'=>'job_id: '.$job_id));

			//return error to display on screen
			$this->ajax->respond('Could not load request reference: '.$job_id);
			return false;
		};

		//get related data
		$this->job = $this->plugin->get_job_details($this->job);

		//output the view which will be returned via ajax and inserted into the hidden
		include('partials/job_details.php'); 
		
		die();
	}

	public function load_table_callback(){
		$table = $this->ajax->param(array('name'=>'table'));
		$html = self::load_table($table);
		$response = array('success'=>'true',
								'html'=>$html);
		$this->ajax->respond($response);
	}

	private function delete_record($options){
		if(!isset($options['table'])){
			return false;
		};
		if(!isset($options['id'])){
			return false;
		}
		
		return $this->cdb->delete_row($options);
	}

	private function load_table($table, $params = array()){
		if(empty($table)){
			return false;
		};

		//check if table has data
		$no_rows = $this->cdb->get_count($table);
		if($no_rows==0){
			// if not data return empty message
			return self::render_empty_table($table);
		};

		//get table data
		switch ($table) {
			case 'rates':
				if(isset($params['query'])){
					//use standard options for table_rows to allow for only returning a single row to ui after an update
					$defaults = array(
							'table'=>'rates',
							'fields'=>array('id', 'distance','amount','unit','hour'),
							'inputs'=>false,
							'actions'=>array('Edit', 'Delete')
							);
				} else {
					//returning whole table so get rates sorted for admin panel with 0 at the end
					$rates_data = $this->plugin->get_rates_list();

					$defaults = array(
								'data'=>$rates_data, //supply data instead of running a query
								'table'=>'rates',
								'fields'=>array('id', 'distance','amount','unit','hour'),
								'inputs'=>false,
								'actions'=>array('Edit', 'Delete')
								);
				};
			break;
			case 'customers':
				$defaults = array(
					'table'=>'customers',
					'fields'=>array('id','last_name', 'first_name','email','phone'),
					'inputs'=>false
				);
			break;
			case 'jobs':
					$from_date = $this->ajax->param(array('name'=>'from_date'));
					$to_date = $this->ajax->param(array('name'=>'to_date'));

					$dates = array('from_date'=>$from_date, 'to_date'=>$to_date);
					//get data
					//$filters = $this->plugin->get_job_filters();

					$job_data = $this->get_jobs($filters, $dates);
					$defaults = array(
									'data'=>$job_data,
									'fields'=>array(/*'move_type',*/
													'created',
													'c.last_name as last_name',
													'lo.address as pick_up',
													'ld.address as drop_off',									
													'delivery_time',
													'payment_type',
													'payment_status'),
									'joins'=>array( 
											array('customers c','id','customer_id', '', 'left'),
										),
									'formats'=>array('created'=>'ukdatetime', 'delivery_time'=>'ukdatetime'),
									'inputs'=>false,
									'table'=>'jobs',
									'actions'=>array('Delete'),
									'tpl_row'=>'<tr class="expand"></tr>'
								);
		};

		if(is_array($defaults)){
			$params = array_merge($defaults, $params);
		} else {
			$params = $defaults;
		};

		$rows = $this->dbui->table_rows($params);

		if($rows===false){
			$response = array('success'=>'false',
								'msg'=>'could not run query',
								'sql'=> $this->dbui->cdb->last_query);
		};

		return $rows;
	}

	private function render_empty_table($table){
		switch ($table) {
			case 'jobs':
				$empty_colspan = 8;
				break;
			case 'customers':
				$empty_colspan = 4;
				break;
			case 'rates':
				$empty_colspan = 6;
				break;
			default:
				$empty_colspan = 999;
				break;
		}
		return '<tr><td colspan="'.$empty_colspan.'" class="empty-table">There are no '.$table.' in the database yet.</td></tr>';
	}

	public function save_record_callback(){
		//get table name from update param
		$table = $this->ajax->param(array('name'=>'update'));
		$update_id = $this->ajax->param(array('name'=>'id', 'optional'=>true));
		$refresh = $this->ajax->param(array('name'=>'refresh', 'optional'=>true));
		$record_data = self::save($table);
		if($record_data === false){
			$this->ajax->respond(array('success'=>'false',
										 'msg'=>'Unable to save records',
                               		     'sql'=>$this->cdb->last_query));
		};

		if(empty($update_id)){
			$html = self::load_table($table);
			$this->ajax->respond(array('success'=>'true',
										'msg'=>'Updated Successfully',
                               		    'html'=>$html));
		} else {
			$html = self::load_table($table, array('query'=>array('id'=>$update_id)));
			$this->ajax->respond(array('success'=>'true',
										'id'=>$update_id,
										'msg'=>'Updated Successfully',
                               		    'html'=>$html));			
		}
	}

	public function delete_record_callback(){
		$table = $this->ajax->param(array('name'=>'update'));
		$id = $this->ajax->param(array('name'=>'id'));
		if(self::delete_record(array('table'=>$table, 'id'=>$id))){
			$this->ajax->respond(array('success'=>'true',
										'msg'=>'Record Deleted'));
		} else {
			$this->ajax->respond(array('success'=>'false',
								 		'msg'=>'Unable to delete record'));
		}
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

		//save
		$row_id = self::save_record($table, $record_data);
		if($row_id === false){
			$this->ajax->respond(array('success'=>'false',
										 'msg'=>'Unable to save '.rtrim($table,'s'),
                               		     'sql'=>$this->cdb->last_query));
		}
		$record_data['id'] = $row_id;		
		return $record_data;
	}
	public function save_record($table, $record_data){
		//save or update
		$rec_id = $this->cdb->update_row($table, $record_data);

		if($rec_id === false){
			$this->ajax->respond(array('success' => 'false',
                                    'msg'=>'Unable to update '.$table,
                                    'sql'=>$this->cdb->last_query));
		};

		return $rec_id;
	}
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
					$record_data[$field] = date('Y-m-d G:i:s');
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
	

}
