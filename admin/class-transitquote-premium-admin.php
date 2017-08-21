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
	private $tab_4_settings_key = 'premium_job_requests';
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
		$this->current_tab_key = isset( $_GET['tab'] ) ? $_GET['tab'] : 'premium_job_requests';

		//if url is not pointing to a tab, set to default
		if(!array_key_exists($this->current_tab_key, $this->tabs_config)){
			$this->current_tab_key = 'premium_job_requests';
		};
		$this->current_tab = $this->tabs[$this->current_tab_key];

		screen_icon();

		$this->render_settings_page_title();
		$this->render_admin_tabs_nav();
		$this->current_tab->render();
	}

	public function render_settings_page_title(){
		echo '<h2>'.esc_html( get_admin_page_title()).'</h2>';
	}

	/**
	 * Initialize plugin settings.
	 *
	 * @since    1.0.0
	 */
	public function settings_admin_init() {
		$this->ajax = new TransitQuote_Premium\CT_AJAX();
		$this->cdb = TransitQuote_Premium::get_custom_db();
		$this->plugin->cdb = $this->cdb;
		$this->dbui = new TransitQuote_Premium\CT_DBUI(array('cdb'=>$this->cdb));
		$this->tabs_config = $this->plugin->define_tab_config();
		$this->update_config_defaults();
		$this->init_data();
		$this->tabs = $this->create_tabs();

	}

	public function init_data(){
		$this->currency = $this->plugin->get_currency();
   		$this->distance_unit = $this->plugin->get_distance_unit();
	}
	
	public function update_config_defaults(){
		// update the conif with any saved settings
		foreach ($this->tabs_config as $tab_key => $tab) {
			$tab = $this->add_tab_sections_if_not_set($tab);
			$saved_options =  (array) get_option($tab_key);
			foreach ($tab['sections'] as $section_key => $section) {
				if(isset($section['fields'])){
					foreach ($section['fields'] as $field_key => $field) {
						// get save setting. if none exists use $field['value'] set in class-admin-config.php
						$default_value = '';
						if(isset($field['value'])){
							$default_value = $field['value'];
						};

						if(isset($saved_options[$field_key])){
							$field['value'] = $saved_options[$field_key];							
						} else {
							$field['value'] = $default_value;
						};

						//echo ' value: '.$field['value'];
						$section['fields'][$field_key] = $field;
					}
					$tab['sections'][$section_key] = $section;
				}
				
			};

			$this->tab_config[$tab_key] = $tab;
		};
		
	}

	public function add_tab_sections_if_not_set($tab){
		if(!isset($tab['sections'])){
				$tab['sections'] = array();
		};
		return $tab;
	}
	public function create_tabs(){
		$tabs = array();
		foreach ( $this->tabs_config as $tab_key => $tab_config) {
			
			$config = $this->tab_config[$tab_key];

		 	// include plugin_slug for use in tab name
		 	$config['admin'] =  $this;
		 	$config['plugin_slug'] = $this->plugin_slug;
		 	$config['partials_path'] =  'partials/';
		 	$config['tab_key'] = $tab_key;

		 	// instanciate tab
		 	switch ($tab_key) {
		 		case 'premium_job_requests':
		 			$tabs[$tab_key] = new TransitQuote_Premium_Grid_Tab($config);
		 			break;
		 		default:
		 			$tabs[$tab_key] = new TransitQuote_Premium_Tab($config);
		 			break;
		 	}

			// register tab with 
			$tabs[$tab_key]->register_tab();
         };

         return $tabs;
	}

   	/*** Render methods ***/

    function render_admin_tabs_nav(){

    	 echo '<h2 class="nav-tab-wrapper">';
         foreach ( $this->tabs as $tab) {
         	// pass class name for active tab
            $active = $this->current_tab_key == $tab->tab_key ? 'nav-tab-active' : '';
            // render nav link
            $tab->render_nav($active);
         };
         echo '<div class="spinner"></div></h2>';
    }

	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 * @since    1.0.0
	 */


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

	private function get_jobs($filters = null, $params = null){

    	//current and future only
    	$clauses = array();

		$filter_sql = " where date(jobs.created) <= '".$filters['to_date']."' and date(jobs.created) >= '".$filters['from_date']."'";

		if(!empty($filters)){
			foreach ($filters as $name => $values) {
				if(($name!='to_date')&&($name!='from_date')){
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
	    	};
	    	if(count($clauses)>0){
	    		$filter_sql .= ' and '.implode(' AND ', $clauses);  		    		
	    	}
    	};
//echo $filter_sql;
		if (!empty($params)){/***susheel***/
    		$orderby = $params['orderby'];
	    	$order   = $params['order'];
	    	switch ($orderby) {
			    case "name":
			        $orderby = 'last_name'; 
			        break;
			    case "delivery_time":
			        $orderby = 'delivery_time'; 
			        break;
			    case "pick_up":
			        $orderby = 'lo.address'; 
			        break;			    
			    case "drop_off":
			        $orderby = 'ld.address'; 
			        break;			    
			    case "received":
			        $orderby = 'received'; 
			        break;
			    default:
			       	$orderby = 'j.job_id'; 
			}

	    }else{
	    	$orderby = 'j.job_id'; 
	    	$order   = 'desc';
	    }

    	$sql = "SELECT distinct	jobs.id,
    							status_type_id,
								l.address as pick_up,
								ld.address as drop_off,
								jobs.customer_id,
								jobs.created,
								jobs.modified,
								trim(concat(c.first_name,' ',c.last_name)) as last_name,
								jobs.delivery_time,
								v.name as vehicle_type,
								q.total as quote,
								pt.name as payment_type,
								pst.description as payment_status
							FROM wp_tq_prm_jobs jobs
								left join wp_tq_prm_journeys j 
									on j.job_id = jobs.id 

								inner join (SELECT j.job_id, o.location_id as last_loc_id
												FROM wp_tq_prm_journeys_locations o                    
												  LEFT JOIN wp_tq_prm_journeys_locations b           
													  ON o.journey_id = b.journey_id AND o.journey_order < b.journey_order
													  inner join wp_tq_prm_journeys j 
														on o.journey_id = j.id	
												WHERE b.journey_order is NULL     
												order by j.job_id asc) last_stop
										on last_stop.job_id = jobs.id

								left join wp_tq_prm_journeys_locations jl 
									on j.id = jl.journey_id and
										jl.journey_order = 0
								left join wp_tq_prm_locations l 
									on jl.location_id = l.id and 
										jl.journey_order = 0

								left join wp_tq_prm_locations ld 
									on ld.id = last_stop.last_loc_id

								left join wp_tq_prm_customers c 
									on c.id = jobs.customer_id 
								left join wp_tq_prm_vehicles v 
									on v.id = jobs.vehicle_id 
								left join wp_tq_prm_services s 
									on v.id = jobs.service_id 
								left join wp_tq_prm_quotes q 
									on q.id = jobs.accepted_quote_id

								left join wp_tq_prm_payment_types pt 
									on pt.id = jobs.payment_type_id


								left join wp_tq_prm_payment_status_types pst 
									on pst.id = jobs.payment_status_id

								left join wp_tq_prm_status_types st 
									on pst.id = jobs.status_type_id
			".$filter_sql." 
			order by ".$orderby." ".$order.";";

		$data = $this->cdb->query($sql);
		return $data;
    }

	private function set_filter($filter_name, $values){
		if(is_array($values)){
			$values = implode(',', $values);
		};
		$record_data = array('name'=>$filter_name,
					'filter_values'=>$values);
		$current_filter = self::get_filter($filter_name);
		if($current_filter!==false){
			$record_data['id'] = $current_filter['id'];
		};
		return $this->plugin->save_record('table_filters', $record_data);
	}

	private function get_filter($filter_name){
		//get current filter by name
		return $this->cdb->get_row('table_filters',$filter_name,'name');
	}

	public function filter_status_types(){
		//get check box name / value array from post data
		$filter_status_types = $this->ajax->param(array('name'=>'filter_status_types',
														'type'=>'array',
														'optional'=>true));

		//dont filter if there is nothing selected
		if(empty($filter_status_types)){
			$this->job_filters = false;
		} else {
			//save the filter state to the database 
			self::set_filter('status_type_id', $filter_status_types);
		};

		//get the filtered table rows
		$html = self::load_table('jobs');

		//return success message and table rows html
		$response = array('success' => 'true',
                                	'msg'=>'Updated filters ok',
                                	'html'=>$html);

		$this->ajax->respond($response);
	}
	
	private function get_transactions(){

    	$sql = "SELECT distinct	pt.id as id,
						trim(concat(c.first_name,' ',c.last_name)) as customer_name,
						c.email as email,
						jobs.id as jobid, 
						q. total as amount,
						pt.currency as currency,
						pt.paypal_status as paypal_status
					FROM wp_tq_prm_transactions_paypal pt
						inner join wp_tq_prm_jobs jobs 
							on pt.job_id = jobs.id

						inner join wp_tq_prm_customers c 
							on c.id = jobs.customer_id 

						inner join wp_tq_prm_quotes q 
							on q.id = jobs.accepted_quote_id

				order by pt.id desc;";

		$data = $this->cdb->query($sql);
		return $data;
    }

	public function load_details_callback(){
		//get the job id for the post parameters
		$row_id = $this->ajax->param(array('name'=>'row_id', 'optional'=>false));
		$table_name = $this->ajax->param(array('name'=>'table_name', 'optional'=>false));

		switch ($table_name) {
			case 'jobs_table':
				self::render_job_details($row_id);
				break;
			case 'transactions_paypal_table':
				self::render_transaction_details($row_id);
				break;
		}
		
		die();
	}

	private function render_job_details($job_id){
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
		if($this->plugin->job_is_available($this->job)){
			$this->job = $this->plugin->get_job_details($this->job);
		} else {
			echo "job not available";
		}

		//output the view which will be returned via ajax and inserted into the hidden
		include('partials/premium_job_details.php'); 
	}


	public function render_transaction_details($transaction_id){

		$this->plugin->init_paypal();

		//load the transaction record from the database
		$this->transaction_logs = self::get_transaction_logs($transaction_id);

		if(is_array($this->transaction_logs)){
			$params = array(
							'table'=>'transaction_logs_paypal',
							'data'=>$this->transaction_logs,
							'fields'=>array('id','created', 'request_type_id','success','message'),
							'inputs'=>false
						);

			$rows = $this->dbui->table_rows($params);

			//output the view which will be returned via ajax and inserted into the hidden
			include('partials/premium_paypal_transactions_details.php'); 
		} else {
			echo 'Payment Not Created';
		};
		
		die();
	}

	private function get_transaction_logs($id){

    	$transaction_logs = $this->plugin->paypal->get_logs_for_transaction($id);

    	return $transaction_logs;
    	
    }

	public function load_transactions_paypal_callback(){
		$html = self::load_table('transactions_paypal');
		$this->ajax->respond(array('success'=>'true',
										'msg'=>'Success',
                               		    'html'=>$html));
	}


	public function render_transaction_details_table(){

		include('partials/premium_paypal_transactions_details.php'); 
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
				// by default use standard options for table_rows to allow for only returning a single row to ui after an update
				$defaults = array(
							'table'=>'rates',
							'fields'=>array('id', 'distance','amount','unit','hour'),
							'inputs'=>false,
							'actions'=>array('Edit', 'Delete')
						);

				// if there is no query, ie not an update or is a delete then get the full list
				if(!isset($params['query'])){
					//returning whole table so get rates sorted for admin panel with 0 at the end

					$filters = self::get_rates_filters();
					$rates_data = $this->plugin->get_rates_list($filters);
					$defaults['data'] = $rates_data; //supply data instead of running a query
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
					
					//get data
					$date_filters = self::get_date_filters();
					$status_filters = self::get_job_filters(); // status filters

					if(!empty($status_filters)){
						$filters = array_merge($date_filters, $status_filters);
					};

					$params = self::get_sort_params();
					
					$job_data = $this->get_jobs($filters, $params);

					$defaults = array(
									'data'=>$job_data,
									'fields'=>array(/*'move_type',*/
													'status_type_id',
													'created',
													'c.last_name as last_name',
													'l.address as pick_up',
													'ld.address as drop_off',									
													'delivery_time',
													'payment_type',
													'payment_status'),
									'formats'=>array('created'=>'ukdatetime', 'delivery_time'=>'ukdatetime','status_type_id'=>'select'),
									'inputs'=>false,
									'table'=>'jobs',
									'actions'=>array('Delete'),
									'tpl_row'=>'<tr class="expand"></tr>'
								);
			break;
			case 'services':
				$defaults = array(
					'table'=>'services',
					'fields'=>array('id','name', 'description'),
					'inputs'=>false,
					'actions'=>array('Edit','Delete')
				);
			break;
			case 'transactions_paypal':
				$transaction_data = $this->get_transactions();
				$defaults = array(
					'data'=>$transaction_data,
					'table'=>'transactions_paypal',
					'fields'=>array('id', 'jobid', 'customer_name', 'email', 'amount', 'currency', 'paypal_status'),
					'inputs'=>false,
					'tpl_row'=>'<tr class="expand"></tr>'
				);
			break;
			case 'vehicles':
				$defaults = array(
					'table'=>'vehicles',
					'fields'=>array('id','name', 'description'),
					'inputs'=>false,
					'actions'=>array('Edit','Delete')
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
		};

		return $rows;
	}

	public function get_sort_params(){
		$orderby = $this->ajax->param(array('name'=>'orderby', 'optional'=>true, 'type'=>'alpha'));
		if(!$orderby){
			$orderby = 'created';
		};

		$order = $this->ajax->param(array('name'=>'order', 'optional'=>true, 'type'=>'alpha'));
		if(!$order){
			$order = 'desc';
		};

		return array('orderby'=>$orderby, 'order'=>$order);
	}

	public function get_job_filters(){
		//return filter status for jobs table
		//use field name for the table being filtered
		if(!isset($this->job_filters)){
			$status_filter = self::get_filter('status_type_id');
			if(empty($status_filter)){
				$this->job_filters = false;
			} else {
				//there is a filter row
				if($status_filter['filter_values']!=''){
					$values = explode(',', $status_filter['filter_values']);
					$this->job_filters = array('status_type_id'=>$values);
				} else {
					$this->job_filters = false;
				}
			}

		};
		return $this->job_filters;
	}

	public function get_date_filters(){
		$from_date = $this->ajax->param(array('name'=>'from_date'));
		$to_date = $this->ajax->param(array('name'=>'to_date'));

		$filters = array('from_date'=>$from_date, 'to_date'=>$to_date);
		return $filters;
	}

	private function get_rates_filters(){
		$filters = null;
		// check for filter params
		$service_id = $this->ajax->param(array('name'=>'service_id'));
		$vehicle_id = $this->ajax->param(array('name'=>'vehicle_id'));
		
		// create array if there are either
		if($service_id || $vehicle_id){
			$filters = array();
		};

		if($service_id){
			$filters['service_id'] = $service_id;
		};
		
		if($vehicle_id){
			$filters['vehicle_id'] = $vehicle_id;
		};
		return $filters;
	}

	private function render_empty_table($table){
		switch ($table) {
			case 'jobs':
				$empty_colspan = 8;
				$table_output_name = $table;
				break;
			case 'customers':
				$empty_colspan = 4;
				$table_output_name = $table;
				break;
			case 'rates':
				$empty_colspan = 6;
				$table_output_name = $table;
				break;
			case 'transactions_paypal':
				$empty_colspan = 5;
				$table_output_name = 'payments';
				break;
			default:
				$empty_colspan = 999;
				break;
		};

		return '<tr><td colspan="'.$empty_colspan.'" class="empty-table">There are no '.$table_output_name.' in the database yet.</td></tr>';
	}

	public function update_job_status_callback(){
		$job_id = $this->ajax->param(array('name'=>'job_id', 'optional'=>false));
		$status_type_id = $this->ajax->param(array('name'=>'status_type_id', 'optional'=>false));
		$success = $this->plugin->update_job_status($job_id, $status_type_id);
		if($success!==false){
			$view = $this->ajax->param(array('name'=>'view', 'optional'=>true));
			$html = self::load_table('jobs');
			$response = array('success' => 'true',
                                	'msg'=>'Updated status ok',
                                	'html'=>$html);
		} else {
			$response = array('success' => 'false',
                    	'msg'=>'Could not update status');
		}
		$this->ajax->respond($response);
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
