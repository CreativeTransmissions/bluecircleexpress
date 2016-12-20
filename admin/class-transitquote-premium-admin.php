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

	private $tab_1_settings_key = 'ct_customers';
    private $tab_2_settings_key = 'ct_products';
	private $tab_3_settings_key = 'ct_sales';
	
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
	public function __construct( $plugin_name,  $version, $plugin_slug ) {
		$this->plugin_name = $plugin_name;
		$this->plugin_slug = $plugin_slug;
		$this->version = $version;
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


	public function load_table_callback(){
		$table = $this->ajax->param(array('name'=>'table'));
		$html = self::load_table($table);
		$response = array('success'=>'true',
								'html'=>$html);
		$this->ajax->respond($response);
	}
	private function load_table($table, $params = array()){
		if(empty($table)){
			return false;
		};
		switch ($table) {
			case 'ct_customers':
				$defaults = array(
					'table'=>'ct_customers',
					'fields'=>array('id','last_name', 'first_name','email','phone'),
					'inputs'=>false,
					'actions'=>array('Edit')
				);
			break;
			case 'ct_products':
				$defaults = array(
					'table'=>'ct_products',
					'fields'=>array('id','paddleid', 'name', 'description'),
					'inputs'=>false,
					'actions'=>array('Edit')
				);
			break;

			case 'ct_customers_products':
				$from_date 	= $this->ajax->param(array('name'=>'from_date'));
				$to_date 	= $this->ajax->param(array('name'=>'to_date'));

				$dates = array('from_date'=>$from_date, 'to_date'=>$to_date);
				//$filters = $this->plugin->get_job_filters();
				$sales_data = $this->get_sales($dates);
				$defaults = array(
					'data'=>$sales_data,
					'fields'=>array(
									'customer_name',
									'product_name',
									'purchase_date'),
					'formats'=>array('created'=>'ukdatetime', 'delivery_time'=>'ukdatetime'),
					'inputs'=>false,
					'table'=>'ct_customers_products',
					'tpl_row'=>'<tr class="expand"></tr>'
					);
			break;
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
		} else {
			if($rows===''){
				$rows = '<tr><td colspan="5" class="empty-table">There is no record in the database yet.</td></tr>';
			};
		};
		return $rows;
	}
	function get_sales($dates = null){
		global $wpdb;
    	//current and future only
    	$wpdb->prefix;
    	$clauses = array();
    	$filter_sql ='';    	
    	if(!empty($dates)){
	    	$filter_sql .= " where date(cp.purchase_date) <= '".$dates['to_date']."' and date(cp.purchase_date) >= '".$dates['from_date']."'"; 
    	};    	

    	$sql = "SELECT	cp.id,
				cp.product_id,
				cp.customer_id,						
				p.name as product_name,
				cp.purchase_date,
				trim(concat(c.first_name,' ',c.last_name)) as customer_name
				FROM ".$wpdb->prefix."sell_ct_customers_products cp 
				left join ".$wpdb->prefix."sell_ct_customers c 
				on cp.customer_id = c.id 
				left join ".$wpdb->prefix."sell_ct_products p
				on cp.product_id = p.id 				
				".$filter_sql." 
				order by cp.purchase_date desc;";

		$data = $this->cdb->query($sql);
		return $data;
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
			__( 'Wp Vouchers', $this->plugin_slug ),
			__( 'Wp Vouchers', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}


	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'partials/wp-balance-voucher-admin-display.php' );
	}

	public function settings_admin_init() {
		$this->ajax = new TransitQuote_Premium\CT_AJAX();
		$this->cdb = TransitQuote_Premium::get_custom_db();
		$this->dbui = new TransitQuote_Premium\CT_DBUI(array('cdb'=>$this->cdb));
		self::register_tab_1_settings();
		self::register_tab_2_settings();
		self::register_tab_3_settings();
	}


	function register_tab_1_settings(){
		// Define name displayed on tab
		$this->plugin_settings_tabs[$this->tab_1_settings_key] = 'Customers';
		// Register settings for tab with the settings API
		register_setting( $this->tab_1_settings_key, $this->tab_1_settings_key ); 
		// Add settings section for this tab including a callback function to display tab content
	    add_settings_section( 'ct_customers', 'Customers',  array( $this, 'customers_callbacks' ), $this->tab_1_settings_key);
	}
	function customers_callbacks(){
		//get the no of customers to determine whether to show empty message or loading message
		$this->customer_count = $this->cdb->get_count('ct_customers');
		if($this->customer_count == 0){
			$this->empty_message = 'There are no customers in the database yet.';
		} else {
			$this->empty_message = 'Loading customers...';
		};
		$help = '<p>All customers who have registered are listed here.</p>';
		echo $help;
	}


	function register_tab_2_settings(){
		// Define name displayed on tab
		$this->plugin_settings_tabs[$this->tab_2_settings_key] = 'Products';
		// Register settings for tab with the settings API
		register_setting( $this->tab_2_settings_key, $this->tab_2_settings_key ); 
		// Add settings section for this tab including a callback function to display tab content
	    add_settings_section( 'ct_products', 'Products',  array( $this, 'products_callback' ), $this->tab_2_settings_key);
	}

	function products_callback(){
		//get the no of customers to determine whether to show empty message or loading message
		$this->product_count = $this->cdb->get_count('ct_products');
		if($this->product_count == 0){
			$this->empty_message = 'There is no product in the database yet.';
		} else {
			$this->empty_message = 'Loading products...';
		};
		$help = '<p>Products will be listed here.</p>';
		echo $help;
	}

	function register_tab_3_settings(){
		// Define name displayed on tab
		$this->plugin_settings_tabs[$this->tab_3_settings_key] = 'Sales';
		// Register settings for tab with the settings API
		register_setting( $this->tab_3_settings_key, $this->tab_3_settings_key ); 
		// Add settings section for this tab including a callback function to display tab content
	    add_settings_section( 'ct_customers_products', 'Sales',  array( $this, 'customers_product_callback' ), $this->tab_3_settings_key);
	}
	function customers_product_callback(){
		//get the no of customers to determine whether to show empty message or loading message
		$this->customer_count = $this->cdb->get_count('ct_customers_products');
		if($this->customer_count == 0){
			$this->empty_message = 'There is no sale in the database yet.';
		} else {
			$this->empty_message = 'Loading Sales...';
		};
		$help = '<p>All sales will be listed here.</p>';
		echo $help;
	}


	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 *           Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */

	public function plugin_options_tabs() {
    	//Called from the admin.php view to display WordPress standard tabs

    	 //set current or default tab
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
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-balance-voucher-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
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
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_name.'jqui', 'http://code.jquery.com/ui/1.11.3/jquery-ui.min.js', '', 1.11, True );
			wp_enqueue_script( $this->plugin_name.'_TransitQuote_Premium_admin_main', plugin_dir_url( __FILE__ ) . 'js/TransitQuote_Premium_admin_main.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name.'_wp-balance-voucher-admin', plugin_dir_url( __FILE__ ) . 'js/wp-balance-voucher-admin.js', array( $this->plugin_name.'_TransitQuote_Premium_admin_main' ), $this->version, true );
		}
	}

}
