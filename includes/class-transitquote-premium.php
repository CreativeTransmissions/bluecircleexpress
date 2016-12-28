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
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/includes
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
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/includes
 * @author     Your Name <email@example.com>
 */
class TransitQuote_Premium {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      TransitQuote_Premium_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	const VERSION = '1.0.0';
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	protected $plugin_slug;	

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

		$this->plugin_name = 'TransitQuote Premium';
		$this->plugin_slug = 'transitquote-premium';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->api_hooks();
		
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
			'callback' => array($this, 'paddle_response'),
		));
	}


	/**
	 * return response for paddle API
	 * @since    1.0.0
	 * @access   public
	 */
	public function paddle_response( $data ) {
		$data = array('test'=>'test','test2'=>'test2');
		return new WP_REST_Response( $data, 200 );
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - TransitQuote_Premium_Loader. Orchestrates the hooks of the plugin.
	 * - TransitQuote_Premium_i18n. Defines internationalization functionality.
	 * - TransitQuote_Premium_Admin. Defines all hooks for the admin area.
	 * - TransitQuote_Premium_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-transitquote-premium-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-transitquote-premium-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-transitquote-premium-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-transitquote-premium-public.php';

		/**
		 * The class responsible for defining the database structure
		 * for the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/db/class-db-config.php';

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
		

		$this->loader = new TransitQuote_Premium_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the TransitQuote_Premium_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new TransitQuote_Premium_i18n();

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

		$plugin_admin = new TransitQuote_Premium_Admin( $this->get_plugin_name(),  $this->get_version(), $this->get_plugin_slug());

		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->get_plugin_slug() . '.php' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_admin_init' );
		// $this->loader->add_action( 'wp_ajax_ct_load_table', $plugin_admin, 'load_table_callback' );
		// $this->loader->add_action( 'wp_ajax_ct_save_record', $plugin_admin, 'save_record_callback' );
		$this->loader->add_filter( 'plugin_action_links_'.$plugin_basename, $plugin_admin, 'add_action_links' );


		$this->loader->add_action( 'wp_ajax_save_record', $plugin_admin, 'save_record_callback' );
		$this->loader->add_action( 'wp_ajax_delete_record', $plugin_admin, 'delete_record_callback' );
		$this->loader->add_action( 'wp_ajax_select_options', $plugin_admin, 'select_options_callback' );
		$this->loader->add_action( 'wp_ajax_load_table', $plugin_admin, 'load_table_callback' );
		$this->loader->add_action( 'wp_ajax_load_job_details', $plugin_admin, 'load_job_details_callback' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new TransitQuote_Premium_Public( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_slug());
		add_shortcode( 'ctwpvouchers', array( $plugin_public, 'display_TransitQuote_Premium' ) );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enqueue_styles');
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enqueue_scripts');	
		$this->loader->add_action( 'wp_ajax_save_customer', $plugin_public, 'save_customer');		
		$this->loader->add_action( 'wp_ajax_nopriv_save_customer', $plugin_public, 'save_customer');	

		$this->loader->add_action( 'wp_ajax_save_sale', $plugin_public, 'save_sale');
		$this->loader->add_action( 'wp_ajax_nopriv_save_sale', $plugin_public, 'save_sale');
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
	 * @return    TransitQuote_Premium_Loader    Orchestrates the hooks of the plugin.
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
		$cdb = new TransitQuote_Premium\CT_CDB(array('prefix'=>'premium'));
		$db_config = new TransitQuote_Premium\DB_Config();

		//Define tables from the configs in the DB_Config class
		$cdb->define_table($db_config->get_config('customers'));
		$cdb->define_table($db_config->get_config('quotes'));
		$cdb->define_table($db_config->get_config('vehicle_types'));
		$cdb->define_table($db_config->get_config('payment_types'));
		$cdb->define_table($db_config->get_config('payment_status_types'));
		$cdb->define_table($db_config->get_config('status_types'));
		$cdb->define_table($db_config->get_config('jobs'));
		$cdb->define_table($db_config->get_config('locations'));
		$cdb->define_table($db_config->get_config('surcharges'));
		$cdb->define_table($db_config->get_config('quote_surcharges'));
		$cdb->define_table($db_config->get_config('journeys'));
		$cdb->define_table($db_config->get_config('rates'));
		$cdb->define_table($db_config->get_config('event_logs')); 
		$cdb->define_table($db_config->get_config('event_data'));
		return $cdb;
	}

	/**
	 * Insert the tables 
	 *	 
	 * @since    1.0.0
	 */
	public function insert_default_data($cdb){
		//populate status table
		$created = date('Y-m-d G:i:s');
		$modified = $created;
		// if($cdb->get_count('tablename')==0){ //can insert some default data here by replacing the table name and fields
		// 	$cdb->update_row('ct_products', array('name'=>'TransitQuote Lite', 'description' => 'TransitQuote Lite', 'paddleid'=> '500997', 'created'=>$created, 'modified'=>$modified ));			
		// };	
		return;
	}
	

}
