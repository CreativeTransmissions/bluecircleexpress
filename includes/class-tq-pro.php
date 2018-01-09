<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
class TransitQuote_Pro3 {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      TransitQuote_Pro_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	const VERSION = '3.1.0';
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	protected $plugin_slug;	
	protected $debug;	
	protected $log_requests;	

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public function __construct() {

		$this->plugin_name = 'TransitQuote Pro';
		$this->plugin_slug = 'tq-pro';
		$this->version = '3.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->api_hooks();
		$this->debug = false;
		$this->log_requests = false;
	}

	/**
	 * Register API hooks for paddle API
	 * @since    1.0.0
	 * @access   public
	 */
	public function api_hooks(){
		$this->loader->add_action( 'rest_api_init', $this, 'api_routes' );	
	}


	/**
	 * Define routs for paddle API
	 * @since    1.0.0
	 * @access   public
	 */

	public function api_routes(){	
		register_rest_route( $this->plugin_slug.'/v1', '/paddle/', array(
			'methods' => 'GET',
			'callback' => array($this, 'custom_api_response'),
		));
	}


	/**
	 * return response for paddle API
	 * @since    1.0.0
	 * @access   public
	 */
	public function custom_api_response( $data ) {
		$data = array('test'=>'test','test2'=>'test2');
		return new WP_REST_Response( $data, 200 );
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - TransitQuote_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - TransitQuote_Pro_i18n. Defines internationalization functionality.
	 * - TransitQuote_Pro_Admin. Defines all hooks for the admin area.
	 * - TransitQuote_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tq-pro-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tq-pro-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tq-pro-public.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tq-pro-admin.php';

		/**
		 * The class responsible for defining all admin tabs in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tq-pro-tab.php';

		/**
		 * The class responsible for defining a gred tab  in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tq-pro-grid-tab.php';

		/**
		 * The class responsible for defining all settings sections in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-section.php';


		/**
		 * The base class responsible for defining a field in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field.php';

		/**
		 * The classes for different field types in the admin area
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field-checkbox.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field-check-group.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field-input.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field-radio.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field-select.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field-textarea.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-settings-field-addresspicker.php';

		/**
		 * The config class responsible for defining the database structure
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/config/class-db-config.php';

		/**
		 * The config class responsible for providing the admin tab structure
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/config/class-admin-config.php';


		/**
		 * The class responsible for defining data access methods
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ct-db/class-cdb.php';

		/**
		 * The class responsible for defining database UI methods
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ct-db/class-ct-dbui.php';

		/**
		 * The class responsible for ajax related util methods
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ct-utils/class-ct-ajax.php';
		
		/**
		 * The class responsible for PayPal methods
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ct-payment-pp/ct-paypal.php';		

		/**
		 * The class responsible for Calculation methods
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tq-pro-calculation.php';

		$this->loader = new TransitQuote_Pro_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the TransitQuote_Pro_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new TransitQuote_Pro_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new TransitQuote_Pro_Admin( $this->get_plugin_name(),  $this->get_version(), $this->get_plugin_slug());

		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->get_plugin_slug() . '.php' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_admin_init' );
		$this->loader->add_filter( 'plugin_action_links_'.$plugin_basename, $plugin_admin, 'add_action_links' );


		$this->loader->add_action( 'wp_ajax_tq_pro3_save_record', $plugin_admin, 'save_record_callback' );
		$this->loader->add_action( 'wp_ajax_delete_record', $plugin_admin, 'delete_record_callback' );
		$this->loader->add_action( 'wp_ajax_select_options', $plugin_admin, 'select_options_callback' );
		$this->loader->add_action( 'wp_ajax_tq_pro3_load_table', $plugin_admin, 'load_table_callback' );
		$this->loader->add_action( 'wp_ajax_load_details', $plugin_admin, 'load_details_callback' );
		$this->loader->add_action( 'wp_ajax_transactions_paypal', $plugin_admin, 'load_transactions_paypal_callback' );
		$this->loader->add_action( 'wp_ajax_update_job_status', $plugin_admin, 'update_job_status_callback');
		$this->loader->add_action( 'wp_ajax_update_payment_status', $plugin_admin, 'update_payment_status_callback');
		$this->loader->add_action( 'wp_ajax_filter_status_types', $plugin_admin, 'filter_status_types');
		$this->loader->add_action( 'wp_ajax_test_customer_email', $plugin_admin, 'test_customer_email_callback');
		$this->loader->add_action( 'wp_ajax_test_dispatch_email', $plugin_admin, 'test_dispatch_email_callback');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new TransitQuote_Pro_Public( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_slug());
		add_shortcode( 'TransitQuote_Pro', array( $plugin_public, 'display_TransitQuote_Pro' ) );
		add_shortcode( 'transitquote_pro', array( $plugin_public, 'display_TransitQuote_Pro' ) );
		add_filter( 'widget_text', 'do_shortcode', 11);
		$this->loader->add_action( 'init', $plugin_public, 'init_plugin');
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enqueue_styles');
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enqueue_scripts');	

		$this->loader->add_action( 'wp_ajax_tq_pro3_save_job', $plugin_public, 'tq_pro_save_job_callback');	
		$this->loader->add_action( 'wp_ajax_nopriv_tq_pro3_save_job', $plugin_public, 'tq_pro_save_job_callback');	
		$this->loader->add_action( 'wp_ajax_nopriv_get_quote', $plugin_public, 'tq_pro_save_job_callback' );
		$this->loader->add_action( 'wp_ajax_create_paypal_payment', $plugin_public, 'create_paypal_payment' );
		$this->loader->add_action( 'wp_ajax_nopriv_create_paypal_payment', $plugin_public, 'create_paypal_payment' );
		$this->loader->add_action( 'wp_ajax_execute_paypal_payment', $plugin_public, 'execute_paypal_payment' );
		$this->loader->add_action( 'wp_ajax_nopriv_execute_paypal_payment', $plugin_public, 'execute_paypal_payment' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The slug of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    TransitQuote_Pro_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	/**
	 * get custom db
	 *	 
	 * @since    1.0.0
	 */

	public static function get_custom_db(){
		//define and register tables
		$cdb = new TransitQuote_Pro3\CT_CDB(array('prefix'=>'tq_pro3'));
		$db_config = new TransitQuote_Pro3\DB_Config();

		//Define tables from the configs in the DB_Config class
		$cdb->define_table($db_config->get_config('companies'));
		$cdb->define_table($db_config->get_config('contacts'));
		$cdb->define_table($db_config->get_config('customers'));
		$cdb->define_table($db_config->get_config('currencies'));
		$cdb->define_table($db_config->get_config('quotes'));
		$cdb->define_table($db_config->get_config('services'));
		$cdb->define_table($db_config->get_config('vehicles'));
		$cdb->define_table($db_config->get_config('payment_types'));
		$cdb->define_table($db_config->get_config('payment_statuses'));
		$cdb->define_table($db_config->get_config('status_types'));
		$cdb->define_table($db_config->get_config('table_filters'));
		$cdb->define_table($db_config->get_config('jobs'));
		$cdb->define_table($db_config->get_config('locations'));
		$cdb->define_table($db_config->get_config('surcharges'));
		$cdb->define_table($db_config->get_config('quote_surcharges'));
		$cdb->define_table($db_config->get_config('journeys'));
		$cdb->define_table($db_config->get_config('journeys_locations'));
		$cdb->define_table($db_config->get_config('journey_lengths'));
		$cdb->define_table($db_config->get_config('transactions_paypal'));
		$cdb->define_table($db_config->get_config('transaction_logs_paypal'));
		$cdb->define_table($db_config->get_config('rates'));
		$cdb->define_table($db_config->get_config('request_types'));
		$cdb->define_table($db_config->get_config('event_logs')); 
		$cdb->define_table($db_config->get_config('event_data'));
		
		return $cdb;
	}

	public function init_settings(){
		$this->tabs_config = $this->define_tab_config();
		$this->settings = array();
		// update the conif with any saved settings
		foreach ($this->tabs_config as $tab_key => $tab) {
			$defaults = self::get_tab_defaults($tab);
			$saved_options = (array) get_option($tab_key, array());
			if(empty($saved_options)&&(!empty($defaults))){
				update_option($tab_key, $defaults);
			};
			
		};
	}

	public function define_tab_config(){
		return TransitQuote_Pro3\Admin_Config::get_config('tabs');
	}

	public function get_tab_defaults($tab){
		$defaults = array();
		foreach ($tab['sections'] as $section_key => $section) {
			foreach ($section['fields'] as $field_key => $field) {
				if(isset($field['default'])){
					$defaults[$field['id']] = $field['default'];
				}
			}
		}
		return $defaults;
	}

	/**
	 * Insert the tables 
	 *	 
	 * @since    1.0.0
	 */
	public function insert_default_data($cdb){
		self::insert_currencies($cdb);
		self::insert_rates($cdb);
		self::insert_payment_types($cdb);
		self::insert_payment_status_types($cdb);
		self::insert_request_types($cdb);
		self::insert_services($cdb);
		self::insert_status_types($cdb);
		self::insert_vehicles($cdb);
		self::insert_journey_lengths($cdb);
	}

	private function insert_currencies($cdb){

		if($cdb->get_count('currencies')==0){

			$created = date('Y-m-d G:i:s');
			$modified = $created;
			
		//	$cdb->update_row('currencies', array('name'=>'Nigerian Naira', 'currency_code' => 'NGN', 'symbol'=> '&#8358;', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Australian dollar', 'currency_code' => 'AUD', 'symbol'=> '&#36;', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Brazilian real', 'currency_code' => 'BRL', 'symbol'=> 'BRL', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Canadian dollar', 'currency_code' => 'CAD', 'symbol'=> '&#36;', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Czech koruna', 'currency_code' => 'CZK', 'symbol'=> 'CZK', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Danish krone', 'currency_code' => 'DKK', 'symbol'=> 'DKK', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Euro', 'currency_code' => 'EUR', 'symbol'=> 'EUR', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Hong Kong dollar', 'currency_code' => 'HKD', 'symbol'=> '&#36;', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Hungarian forint', 'currency_code' => 'HUF', 'symbol'=> 'HUF', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Israeli new shekel', 'currency_code' => 'ILS', 'symbol'=> 'ILS', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Japanese yen', 'currency_code' => 'JPY', 'symbol'=> 'JPY', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Malaysian ringgit', 'currency_code' => 'MYR', 'symbol'=> 'MYR', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Mexican peso', 'currency_code' => 'MXN', 'symbol'=> 'MXN', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'New Taiwan dollar', 'currency_code' => 'TWD', 'symbol'=> 'TWD', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'New Zealand dollar', 'currency_code' => 'NZD', 'symbol'=> '&#36;', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Norwegian krone', 'currency_code' => 'NOK', 'symbol'=> 'NOK', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Philippine peso', 'currency_code' => 'PHP', 'symbol'=> 'PHP', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Polish złoty', 'currency_code' => 'PLN', 'symbol'=> 'PLN', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Pound sterling', 'currency_code' => 'GBP', 'symbol'=> '&#163;', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Russian ruble', 'currency_code' => 'RUB', 'symbol'=> 'RUB', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Singapore dollar', 'currency_code' => 'SGD', 'symbol'=> '&#36;', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Swedish krona', 'currency_code' => 'SEK', 'symbol'=> 'SEK', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Swiss franc', 'currency_code' => 'CHF', 'symbol'=> 'CHF', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'Thai baht', 'currency_code' => 'THB', 'symbol'=> 'THB', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('currencies', array('name'=>'United States dollar', 'currency_code' => 'USD', 'symbol'=> '&#36;', 'created'=>$created, 'modified'=>$modified ));

		}

	}

	private function insert_journey_lengths($cdb){
		if($cdb->get_count('journey_lengths')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('journey_lengths', array('distance' => '0', 'created'=>$created, 'modified'=>$modified ));
		};
	}

	private function insert_rates($cdb){
		if($cdb->get_count('rates')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('rates', array('service_type_id'=>1, 'distance' => '0', 'unit'=> '2', 'journey_length_id'=>1, 'created'=>$created, 'modified'=>$modified ));
		};
	}

	private function insert_payment_types($cdb){
		if($cdb->get_count('payment_types')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('payment_types', array('name' => 'On Delivery', 'available'=>1, 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('payment_types', array('name' => 'Pay Online', 'available'=>1, 'created'=>$created, 'modified'=>$modified ));
			//$cdb->update_row('payment_types', array('name' => 'Stripe', 'available'=>0, 'created'=>$created, 'modified'=>$modified ));
		};
	}

	private function insert_payment_status_types($cdb){
		if($cdb->get_count('payment_statuses')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('payment_statuses', array('name' => 'Due', 'description'=> 'Due', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('payment_statuses', array('name' => 'Recieved', 'description'=> 'Recieved', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('payment_statuses', array('name' => 'Failed', 'description'=> 'Failed', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('payment_statuses', array('name' => 'Approved', 'description'=> 'Approved', 'created'=>$created, 'modified'=>$modified ));					
		};
	}

	private function insert_request_types($cdb){
		if($cdb->get_count('request_types')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('request_types', array('name'=>'Created', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('request_types', array('name'=>'Executed', 'created'=>$created, 'modified'=>$modified ));
		};
	}

	private function insert_services($cdb){
		if($cdb->get_count('services')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('services', array('name'=>'Standard', 'description' =>'Standard rates and turnaround apply.', 'amount'=>0,' created'=>$created, 'modified'=>$modified ));
		};
	}

	private function insert_status_types($cdb){
		if($cdb->get_count('status_types')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('status_types', array('name' => 'New', 'description'=> 'New request has been received', 'created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('status_types', array('name' => 'Assigned', 'description'=> 'Request has been assigned to a courier','created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('status_types', array('name' => 'In Progress', 'description'=> 'Courier is travelling to collect','created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('status_types', array('name' => 'Collected', 'description'=> 'Item has been collected','created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('status_types', array('name' => 'Delivered', 'description'=> 'Item has been delivered','created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('status_types', array('name' => 'Completed', 'description'=> 'Payment has been received','created'=>$created, 'modified'=>$modified ));
			$cdb->update_row('status_types', array('name' => 'Cancelled', 'description'=> 'Customer cancelled the delivery','created'=>$created, 'modified'=>$modified ));
		};
	}

	private function insert_vehicles($cdb){
		if($cdb->get_count('vehicles')==0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$cdb->update_row('vehicles', array('name'=>'Van', 'description' =>'Standard delivery vehicle.', 'amount'=>0,' created'=>$created, 'modified'=>$modified ));
		};
	}

	public function update_default_data($cdb){
		self::update_default_payment_types($cdb);
		self::migrate_rates($cdb);
	}

	public function update_default_payment_types($cdb){
		if($cdb->get_count('payment_types')>0){
			$created = date('Y-m-d G:i:s');
			$modified = $created;
			$payment_type_rows = $cdb->get_row('payment_types', 'PayPal', 'name');
			if($payment_type_rows === false){
				return false;
			};
 
			if(count($payment_type_rows)>0){
				$cdb->update_field('payment_types', 'name', 'Pay Online', 'PayPal', 'name');

			};
		}
	}

	public function migrate_rates($cdb){
		if(!$cdb->col_exists('rates','journey_length_id')){
			$col_def = array('name'=>'journey_length_id',
							'type'=>'int',
							'null'=>'null',
							'default'=>'default 1',
							'after'=>'after vehicle_id');
			$cdb->add_column('rates',$col_def);
		}
		
		if(!$cdb->col_exists('quotes','rate_tax')){
			$col_def = array('name'=>'rate_tax',
							'type'=>'decimal(10,2)',
							'null'=>'null',
							'default'=>'default 0',
							'after'=>'after rate_hour');
			$cdb->add_column('quotes',$col_def);
		}

		if(!$cdb->col_exists('quotes','tax_cost')){
			$col_def = array('name'=>'tax_cost',
							'type'=>'decimal(10,2)',
							'null'=>'null',
							'default'=>'default 0',
							'after'=>'after notice_cost');
			$cdb->add_column('quotes',$col_def);
		}

		if(!$cdb->col_exists('quotes','breakdown')){
			$col_def = array('name'=>'breakdown',
							'type'=>'text',
							'null'=>'null',
							'default'=>'',
							'after'=>'after tax_cost');
			$cdb->add_column('quotes',$col_def);
		}
	}
}
