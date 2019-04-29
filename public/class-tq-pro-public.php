<?php
/*error_reporting(E_ERROR | E_PARSE );
ini_set('display_errors', 1);
 ini_set('display_errors', 1);
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
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
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
    public function __construct($plugin_name, $version, $plugin_slug) {
        $this->plugin_name = $plugin_name;
        $this->plugin_slug = $plugin_slug;
        $this->version = $version;
        $this->debug = false;
        $this->log_requests = false;
        $this->prefix = 'tq_pro4';
        $this->cdb = TransitQuote_Pro4::get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));
        if (self::woocommerce_is_activated()) {
            self::get_woocommerce_config();
        }
        $this->dbui = new TransitQuote_Pro4\CT_DBUI(array('cdb' => $this->cdb));
        $this->tq_woocommerce_customer = new TransitQuote_Pro4\TQ_WooCommerceCustomer(array('cdb' => $this->cdb, 'public' => $this, 'debug' => $this->debug));
    }

    public function enqueue_styles() {
        if (!self::check_shortcode()) {
            return false;
        }
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
        if (!$add_my_script_flag) {
            return;
        }

        $this->theme = self::get_setting('tq_pro_form_options', 'form_theme', 'classic');
        wp_enqueue_style($this->plugin_slug . '-calc-styles', plugins_url('js/js-transitquote/css/map-quote-calculator.css', __FILE__), array(), $this->version);
        wp_enqueue_style($this->plugin_slug . '-jqueryui-styles', plugins_url('css/jquery-ui.css', __FILE__), array(), $this->version);
        wp_enqueue_style($this->plugin_slug . '-timepicker-styles', plugins_url('css/jquery-ui-timepicker-addon.css', __FILE__), array(), $this->version);

        wp_enqueue_style($this->plugin_slug . '-datetimepicker-styles', plugins_url('css/datetimepicker.css', __FILE__), array(), $this->version);
        wp_enqueue_style($this->plugin_slug . '-shared-plugin-styles', plugins_url('css/shared.css', __FILE__), array(), $this->version);
        wp_enqueue_style($this->plugin_slug . '-plugin-styles', plugin_dir_url(__FILE__) . 'themes/' . strtolower($this->theme) . '/css/theme.css', array(), $this->version);

        wp_enqueue_style($this->plugin_slug . '-parsley-styles', plugin_dir_url(__FILE__) . 'css/parsley.css', array(), $this->version);
        wp_enqueue_style($this->plugin_slug . '-popup-styles', plugins_url('css/magnific-popup.css', __FILE__), array(), $this->version);
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */

    public function enqueue_scripts() {
        if (!self::check_shortcode()) {
            return false;
        }

        self::get_plugin_settings();

        $tq_settings = self::get_settings_for_js();

        self::dequeue_maps(); // uncomment to debug multiple maps installs

        wp_enqueue_script($this->plugin_slug . '-gmapsapi', '//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places' . $this->api_string, '', 3.14, True);
        wp_enqueue_script($this->plugin_slug . '-jqui', '//code.jquery.com/ui/1.10.4/jquery-ui.js', '', 1.10, True);

        wp_enqueue_script($this->plugin_slug . '-jqui-maps', plugins_url('js/jquery.ui.map.js', __FILE__), array('jquery', $this->plugin_slug . '-jqui', $this->plugin_slug . '-gmapsapi'), '', True); //was commented

        wp_enqueue_script($this->plugin_slug . '-picker', plugins_url('js/picker.js', __FILE__), array('jquery', $this->plugin_slug . '-gmapsapi'), '', True);
        wp_enqueue_script($this->plugin_slug . '-picker-date', plugins_url('js/picker.date.js', __FILE__), array('jquery', $this->plugin_slug . '-picker'), '', True);
        wp_enqueue_script($this->plugin_slug . '-picker-time', plugins_url('js/picker.time.js', __FILE__), array('jquery', $this->plugin_slug . '-picker-date'), '', True);
        wp_enqueue_script($this->plugin_slug . '-picker-legacy', plugins_url('js/legacy.js', __FILE__), array('jquery', $this->plugin_slug . '-picker-time'), '', True);

        wp_enqueue_script($this->plugin_slug . '-map-quote-calculator', plugins_url('js/js-transitquote/js/map-quote-calculator.js', __FILE__), array('jquery', $this->plugin_slug . '-jqui', $this->plugin_slug . '-jqui-maps'), '', True);

        wp_enqueue_script($this->plugin_slug . '-tq-pro', plugins_url('js/tq-pro-public.js', __FILE__), array($this->plugin_slug . '-map-quote-calculator'), $this->version, true);
        wp_localize_script($this->plugin_slug . '-tq-pro', 'TransitQuoteProSettings', $tq_settings);

        wp_enqueue_script($this->plugin_slug . '-parsley-script', plugins_url('js/parsley.js', __FILE__), array($this->plugin_slug . '-tq-pro'), $this->version, true);
        wp_enqueue_script($this->plugin_slug . '-plugin-script', plugins_url('js/public-main.js', __FILE__), array($this->plugin_slug . '-tq-pro'), $this->version, true);
        wp_localize_script($this->plugin_slug . '-plugin-script', 'TransitQuoteProSettings', $tq_settings);

    }

    public function get_plugin_settings() {

        $this->start_lat = $this->get_setting('tq_pro_quote_options', 'start_lat', '55.870853');
        $this->start_lng = $this->get_setting('tq_pro_quote_options', 'start_lng', '-4.252036');
        $this->start_place_name = $this->get_setting('tq_pro_quote_options', 'start_location', 'Glasgow');
        self::get_currency_code();
        $this->distance_unit = self::get_distance_unit();
        $this->max_address_pickers = $this->get_setting('tq_pro_quote_options', 'max_address_pickers', '1');
        $this->min_notice = $this->get_setting('tq_pro_quote_options', 'min_notice', '');
        $this->min_notice_charge = $this->get_setting('tq_pro_quote_options', 'min_notice_charge', '');
        $this->min_price = $this->get_setting('', 'min_price');
        $this->min_distance = $this->get_setting('', 'min_distance');
        $this->min_distance_msg = self::get_min_distance_msg();
        $this->max_distance = $this->get_setting('', 'max_distance', 0);
        $this->max_distance_msg = $this->get_setting('', 'max_distance_message');
        $this->min_travel_time = $this->get_setting('', 'min_travel_time', 0);
        $this->min_travel_time_msg = $this->get_setting('', 'min_travel_time_message');
        $this->max_travel_time = $this->get_setting('', 'max_travel_time', 0);
        $this->max_travel_time_msg = $this->get_setting('', 'max_travel_time_message');
        $this->transportation_mode = $this->get_setting('', 'transportation_mode', 'Driving');

        $this->quote_element = $this->get_setting('tq_pro_quote_options', 'quote_element', 'quote');
        $this->api_key = self::get_api_key();
        $this->api_string = self::get_api_string();
        $this->pick_start_address = (bool) $this->get_setting('', 'pick_start_address', true);
        $geolocate = self::get_geolocate();
        $sandbox = self::get_sandbox();
        $this->sandbox = self::bool_to_text_sandbox($sandbox);
        $this->woocommerce_include_tax = (bool) $this->get_setting('', 'woocommerce_include_tax', true);

        $this->geolocate = self::bool_to_text($geolocate);

        $this->insert_dest_link_text = $this->get_setting('', 'insert_destination_link', '+ Insert Destination');
        $this->remove_dest_link_text = $this->get_setting('', 'remove_destination_link', '- Remove This Destination');
        $this->cant_find_address_text = $this->get_setting('', 'cant_find_address_text', 'I can&#39;t find my address');
        $this->destination_address_label = $this->get_setting('', 'destination_address_label', 'Destination Address');

        $this->unit_no_label = self::get_setting('tq_pro_form_options', 'appartment_no_label', 'Unit No');
        $this->contact_name_label = self::get_setting('tq_pro_form_options', 'contact_name_label', 'Contact Name');
        $this->contact_phone_label = self::get_setting('tq_pro_form_options', 'contact_phone_label', 'Contact Phone');
        $this->postal_code_label = self::get_setting('tq_pro_form_options', 'postal_code_label', 'Postal Code');

        $this->ask_for_date = (bool) $this->get_setting('', 'ask_for_date', true);
        $this->ask_for_time = (bool) $this->get_setting('', 'ask_for_time', true);
    }

    public function check_shortcode() {
        global $posts;

        // false because we have to search through the posts first
        $found = false;
        // search through each post
        foreach ($posts as $post) {
            // check the post content for the short code
            if (strrpos(strtolower($post->post_content), '[transitquote_pro') > -1) {
                // we have found a post with the short code
                return true;
            };
            if (strrpos(strtolower($post->post_content), '[tq_pro_display_rates_list') > -1) {
                // we have found a post with the short code
                return true;
            }

        };
        return false;

    }

    public function get_sandbox() {
        $sandbox = self::get_setting('', 'sandbox', '');
        if ($sandbox == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function bool_to_text($bool) {
        if ($bool === true) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function bool_to_text_sandbox($bool) {
        if ($bool === true) {
            return 'sandbox';
        } else {
            return 'production';
        }
    }
    public function get_settings_for_js() {
        //get varibles to pass to JS
        // $holidays = self::get_holidays();

        $rates = self::get_rates_list();
        $blocked_dates = self::get_blocked_dates();

        $get_date_format = self::get_date_format();
        $get_time_format = self::get_time_format();

        $time_interval = self::get_setting('tq_pro_form_options', 'time_interval', 30);
        $booking_start_time = strtotime(self::get_setting('tq_pro_form_options', 'booking_start_time', '07:00 AM'));
        $booking_end_time = strtotime(self::get_setting('tq_pro_form_options', 'booking_end_time', '09:00 PM'));
        // $surcharges = self::get_service_surcharges();
        $ajax_url = admin_url('admin-ajax.php');

        $this->ask_for_unit_no = (bool) $this->get_setting('', 'ask_for_unit_no', false);
        $this->ask_for_postcode = (bool) $this->get_setting('', 'ask_for_postcode', false);
        $this->show_contact_name = (bool) $this->get_setting('', 'show_contact_name', false);
        $this->destination_address_label = $this->get_setting('', 'destination_address_label', 'Destination Address');
        $this->show_contact_number = (bool) $this->get_setting('', 'show_contact_number', false);
        $this->restrict_to_country = (bool) $this->get_setting('', 'restrict_to_country', true);

        $this->destination_address_label = $this->get_setting('', 'destination_address_label', 'Destination Address');
        $this->insert_dest_link_text = $this->get_setting('', 'insert_destination_link', '+ Insert Destination');
        $this->remove_dest_link_text = $this->get_setting('', 'remove_destination_link', '- Remove This Destination');
        $this->cant_find_address_text = $this->get_setting('', 'cant_find_address_text', 'I can&#39;t find my address.');
        $this->country_code = $this->get_setting('', 'country_code', '');
        $this->city_code = $this->get_setting('', 'city_code', '');
        $this->search_radius = $this->get_setting('', 'search_radius', '');
		$this->route_type = $this->get_setting('', 'route_type','');

        $tq_settings = array('ajaxurl' => $ajax_url,
            'ask_for_unit_no' => self::bool_to_text($this->ask_for_unit_no),
            'ask_for_postcode' => self::bool_to_text($this->ask_for_postcode),
            'country_code' => $this->country_code,
            'restrict_to_country' => self::bool_to_text($this->restrict_to_country),
            'search_radius' => $this->search_radius,
            'destination_address_label' => $this->destination_address_label,
            'show_contact_name' => self::bool_to_text($this->show_contact_name),
            'show_contact_number' => self::bool_to_text($this->show_contact_number),
            'geolocate' => $this->geolocate,
            'imgurl' => plugins_url('assets/images/', __FILE__),
            'distance_unit' => $this->distance_unit,
            'startLat' => $this->start_lat,
            'startLng' => $this->start_lng,
            'startPlaceName' => $this->start_place_name,
            'rates' => $rates,
            'min_notice' => $this->min_notice,
            'min_notice_charge' => $this->min_notice_charge,
            'min_price' => $this->min_price,
            'min_distance' => $this->min_distance,
            'pick_start_address' => self::bool_to_text($this->pick_start_address),
            'transportation_mode' => $this->transportation_mode,
            'max_distance' => $this->max_distance,
            'max_distance_msg' => $this->max_distance_msg,
            'min_travel_time' => $this->min_travel_time,
            'min_travel_time_msg' => $this->min_travel_time_msg,
            'max_travel_time' => $this->max_travel_time,
            'max_travel_time_msg' => $this->max_travel_time_msg,
            'quote_element' => $this->quote_element,
            'max_address_pickers' => $this->max_address_pickers,
							'route_type'=>$this->route_type,
            'sandbox' => $this->sandbox,
            'insert_dest_link_text' => $this->insert_dest_link_text,
            'remove_dest_link_text' => $this->remove_dest_link_text,
            'cant_find_address_text' => $this->cant_find_address_text,
            'unit_no_label' => $this->unit_no_label,
            'contact_name_label' => $this->contact_name_label,
            'contact_phone_label' => $this->contact_phone_label,
            'postal_code_label' => $this->postal_code_label,

            'blocked_dates' => $blocked_dates,
            'time_interval' => $time_interval,
            'booking_start_time' => $booking_start_time,
            'booking_end_time' => $booking_end_time,
            'date_format' => $get_date_format,
            'time_format' => $get_time_format,
        );

        if (!empty($this->api_key)) {
            $tq_settings['apiKey'] = $this->api_key;
        };

        $paypal_settings = array();
        $paypal_settings['createPaymentUrl'] = $ajax_url . '?action=create_paypal_payment';
        $paypal_settings['executePaymentURL'] = $ajax_url . '?action=execute_paypal_payment';

        if (!empty($paypal_settings)) {
            $tq_settings['paypal'] = $paypal_settings;
        };
        return $tq_settings;
    }

    function get_date_format() {
        return get_option('date_format');
    }
    function get_time_format() {
        return get_option('time_format');
    }

    function datepicker_format() {
        $date_format = self::get_date_format();
        $month_symboles = ['F', 'm', 'M', 'n', 't'];
        $date_symboles = ['D', 'd', 'j'];
        $month_pos = $date_pos = 'no'; //dummy value
        foreach ($month_symboles as $month_symbole) {
            $pos = stripos($date_format, $month_symbole);
            if (($pos !== false)) {
                $month_pos = $pos;
                break;
            }
        }
        foreach ($date_symboles as $date_symbole) {
            $pos = stripos($date_format, $date_symbole);
            if (($pos !== false)) {
                $date_pos = $pos;
                break;
            }
        }
        $date_first = 'dd/mm/yy';
        $return_format = $date_first;
        $month_first = 'mm/dd/yy';
        if ($month_pos !== 'no' && $month_pos >= 0) { // if month found
            if ($date_pos !== 'no' && $date_pos >= 0) {
                if ($month_pos > $date_pos) {
                    $return_format = $date_first;
                } else {
                    $return_format = $month_first;
                }
            } else { // no date
                $return_format = $month_first;
            }
        } else if ($date_pos !== 'no' && $date_pos >= 0) { // if date found
            if ($month_pos !== 'no' && $month_pos >= 0) {
                if ($date_pos > $month_pos) {
                    $return_format = $month_first;
                } else {
                    $return_format = $date_first;
                }
            } else { // no month
                $return_format = $date_first;
            }
        } else {
            $return_format = $date_first;
        }

        return $return_format;
    }

    private function get_blocked_dates() {
        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $today = date('Y-m-d');
        $all_blocked_dates = $this->cdb->get_rows('blocked_dates', array("CAST(end_date as DATE) >" => $today), array(), null, false);
        $blocked_dates_array = array();

        foreach ($all_blocked_dates as $key => $blocked_dates) {
            $start_date = $blocked_dates['start_date'];
            $sdate = $blocked_dates['start_date'];
            $end_date = $blocked_dates['end_date'];
            if ($end_date == $start_date) {
                $blocked_dates_array[] = array(date("Y-m-d", strtotime($start_date)));
            } else {
                while (strtotime($sdate) <= strtotime($end_date)) {
                    $blocked_dates_array[] = array(date("Y-m-d", strtotime($sdate)));
                    $sdate = date("Y-m-d", strtotime("+1 day", strtotime($sdate)));
                }
            }
        };
        return $blocked_dates_array;
    }
    public function dequeue_maps() {
        self::dequeue_script('googlemapapis');
        //self::inspect_scripts();
    }

    function inspect_scripts() {
        //for finding out if gmamps installed more than once.
        global $wp_scripts;
        echo 'scriptlist:';
        foreach ($wp_scripts->queue as $handle):
            echo $handle . ' | ';
        endforeach;
    }

    private function dequeue_script($handle) {
        wp_dequeue_script($handle);
    }

    public function check_payment_config($payment_type_id = null) {
        // Check we have all required paypal config values
        $payment_config_is_ok = false;

        if (empty($payment_type_id)) {
            self::debug('check_payment_config: no payment_type_id');
            return false;
        };

        switch ($payment_type_id) {
        case 1: // payment on delivery
            $payment_config_is_ok = true;
            break;
        case 2: // payment by paypal

            break;
        case 3: // payment by woocommerce
            self::get_woocommerce_config();
            $payment_config_is_ok = self::woocommerce_is_activated();
            break;
        };

        return $payment_config_is_ok;
    }

    private function woocommerce_is_activated() {
        if (class_exists('WooCommerce')) {
            return true;
        } else {
            return false;
        }
    }

    public function debug($error) {
        if ($this->debug == true) {
            $plugin = new TransitQuote_Pro4();
            $this->cdb = $plugin->get_custom_db();
            $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));
            $this->ajax->error_log_request($error, 'log');
            if (is_array($error)) {
                echo '<pre>';
                print_r($error);
                echo '</pre>';
                $error = print_r($error, true);
            } else {
                echo '<br/>' . $error;
            }
            trigger_error($error, E_USER_WARNING);
        }
    }

    public function define_tab_config() {
        return TransitQuote_Pro4\Admin_Config::get_config('tabs');
    }

    public function load_settings() {
        $this->tabs_config = $this->define_tab_config();
        $this->settings = array();
        // update the conif with any saved settings
        foreach ($this->tabs_config as $tab_key => $tab) {
            $defaults = self::get_tab_defaults($tab);
            $saved_options = (array) get_option($tab_key, array());
            //$this->ajax->pa($saved_options);

            $this->settings = array_merge($this->settings, $defaults, $saved_options);
        };
    }

    public function save_setting($tab_key, $setting_name, $value) {
        self::load_settings();
        $tab_options = (array) get_option($tab_key, array());
        $tab_options[$setting_name] = $value;
        update_option($tab_key, $tab_options);
    }

    private function get_tab_defaults($tab) {
        $defaults = array();
        foreach ($tab['sections'] as $section_key => $section) {
            foreach ($section['fields'] as $field_key => $field) {
                if (isset($field['default'])) {
                    $defaults[$field['id']] = $field['default'];
                }
            }
        }
        return $defaults;
    }
    public function get_prefix() {
        return $this->prefix;
    }

    private function get_rates() {
        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $all_rates = $this->cdb->get_rows('rates', array(), array(), null, 'distance');
        $rates = array();
        foreach ($all_rates as $key => $rate) {
            if ($rate['distance'] === 0) {
                $max_distance_rate = $rate;
            } else {
                $rates[] = $rate;
            };
        };

        if (isset($max_distance_rate)) {
            $rates[] = $max_distance_rate;
        };

        return $rates;
    }

    public function get_rates_list($filters = null) {
        $filter_clause = '';
        $filter_sql = '';
        if (is_array($filters)) {
            // start sql with and if there is at least one filter
            $filter_sql = ' and ';
            // array for the separate parts of the where statement
            $filter_clauses = array();
            foreach ($filters as $key => $value) {
                $filter_clauses[] = $key . ' = ' . $value;
            };
            // concatenate individual filters with AND
            $filter_sql .= implode(' and ', $filter_clauses);
        };

        $rates_table_name = $this->cdb->get_table_full_name('rates');
        // get ordered list of rates with distance 0 as the final record
        $sql = "select distinct *
    				from (select distinct *
								from " . $rates_table_name . "
								where distance <> 0
								" . $filter_sql . "
							order by service_id, vehicle_id, distance
							) r
					union
				select distinct * from (
					select distinct *
						from " . $rates_table_name . "
					where distance = 0
					" . $filter_sql . ") r2;";
        //echo $sql;
        $data = $this->cdb->query($sql);
        return $data;
    }

    public function init_plugin() {
        $plugin = new TransitQuote_Pro4();
        self::load_settings();

        $this->cdb = $plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));

        if (!self::api_keys_are_present()) {
            add_action('admin_notices', array($this, 'api_key_notice'));
        };

    }

    public function api_keys_are_present() {
        $this->api_setup_message = '';
        $success = true;
        $this->application_client_id = self::get_setting('tq_pro_paypal_options', 'application_client_id');
        $this->application_client_secret = self::get_setting('tq_pro_paypal_options', 'application_client_secret');

        if (!self::get_api_key()) {
            $this->api_setup_message = '<li>Please enter a valid Google Maps API Key in the Map Options tab of your TransitQuote Pro Dashboard.</li>';
        };

        if (empty($this->application_client_id)) {
            $this->api_setup_message .= '<li>Please enter a valid PayPal Application Client ID in the PayPal tab of your TransitQuote Pro Dashboard.</li>';

        };

        if (empty($this->application_client_id)) {
            $this->api_setup_message .= '<li>Please enter a valid PayPal Application Client Secret in the PayPal tab of your TransitQuote Pro Dashboard.</li>';
        };

        if (!self::rates_exist()) {
            $this->api_setup_message .= '<li>Please enter your rates in the Rates tab of your TransitQuote Pro Dashboard.</li>';
        }

        if ($success === false) {
            $this->api_setup_message = '<p>To use TransitQuote Pro please update your settingss follows:</p><ul>' . $this->api_setup_message . '</ul>';
        }

        return $success;

    }

    public function rates_exist() {
        $rates = self::get_rates();
        if (empty($rates)) {

            return false;
        } else {
            return true;
        }
    }

    public function api_key_notice() {
        ?><div class="update-nag notice">
    		<h3>TransitQuote Pro Setup Notice</h3>
    		<?php echo $this->api_setup_message; ?>
    	</div>
    	<?php
}
    public function display_quote_page($atts) {
        // display the quote and payment page
        global $add_my_script_flag;
        $add_my_script_flag = true;

        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));

        //get paths for includes
        self::get_paths_for_includes();

        $this->job_id = $this->ajax->param(array('name' => 'job_id', 'optional' => true));
        if (empty($this->job_id)) {
            return '';
        } else {
            self::get_job_details_from_id($this->job_id);
            $this->currency_code = self::get_currency_code();
            $this->currency_symbol = self::get_currency_symbol();
            $this->distance_unit = self::get_distance_unit();
            $this->success_message = self::get_success_message();
            $this->confirm_quote_before_sending = true;

            $this->distance = $this->job['journey']['distance'];
            $this->time = $this->job['journey']['time'];

            $this->distance_cost = $this->job['quote']['distance_cost'];
            $this->time_cost = $this->job['quote']['time_cost'];

            $this->rate_hour = $this->job['quote']['rate_hour'];

            $this->total_cost = $this->job['quote']['total'];

            $view_name = 'tq-quote-page';
            $this->view_labels = self::get_view_labels($view_name);
            $this->view = 'partials/' . $view_name . '.php';
            ob_start();
            include $this->view;
            return ob_get_clean();
        }
    }

    private function get_view_labels($view_name = null) {
        $label_fetcher = new TransitQuote_Pro4\TQ_LabelFetcher(array('public' => $this));
        return $label_fetcher->fetch_labels_for_view($view_name);
    }

    public function job_details_quote_table($header, $data) {
        $html = '';
        $rows = array();
        foreach ($data as $field) {
            $type_attribute = '';
            if (isset($field['type'])) {
                $type_attribute = ' data-type="' . $field['type'] . '" ';
            }

            $name_attribute = '';
            if (isset($field['name'])) {
                $name_attribute = ' data-name="' . $field['name'] . '" ';
            };

            $edit_attribute = '';
            if (isset($field['editable'])) {
                $edit_attribute = ' class="tq-editable" ';
            };

            $click_attribute = '';
            if (isset($field['clickable'])) {
                $click_attribute = ' class="tq-clickable" ';
            }

            $update_attribute = '';
            if (isset($field['update'])) {
                $update_attribute = ' data-update="' . $field['update'] . '" ';
            };

            $surcharge_attribute = '';
            if (isset($field['surcharge_id'])) {
                $surcharge_attribute = ' data-id="' . $field['surcharge_id'] . '" ';
            };

            if (empty($field['label'])) {
                $row = '<tr><td>' . $field['value'] . '</td></tr>';

                $html = '<table><tr><th colspan="1">' . $header . '</th></tr>';
            } else {
                $row = '<tr><td>' . $field['label'] . '</td><td>' . $field['value'] . '</td></tr>';

                $html = '<table><tr><th colspan="2">' . $header . '</th></tr>';
            }

            $rows[] = $row;
        };
        if (count($rows) === 0) {
            $html = '';
        } else {
            $html .= implode('', $rows);
            $html .= '</table>';
        }
        echo $html;
    }
    public function route_details_table($html = false) {
        $route_row_data = self::get_route_list();
        return $this->web_details_list('Route', $route_row_data);
    }

    public function web_details_list($header, $data) {
        //return job details info in list for text email
        $html = '<table><tr><th colspan="1">' . $header . '</th></tr>';

        $rows = array();
        foreach ($data as $field) {
            if (!empty($field['value'])) {
                if (empty($field['label'])) {
                    $rows[] = '<tr><td>' . $field['value'] . '</td></tr>';
                } else {
                    $rows[] = '<tr><td>' . $field['label'] . '</td><td>' . $field['value'] . '</td></tr>';
                }
            }
        };
        $html .= implode('', $rows);
        $html .= '</table>';
        echo $html;

    }

    private function get_route_list() {
        $route_row_data = array();
        foreach ($this->locations_in_journey_order as $key => $waypoint) {
            switch ($waypoint['journey_order']) {
            case '0':
                $route_row_data[] = array('value' => 'Collect From:');
                $route_row_data[] = array('value' => $this->format_waypoint_list($waypoint, true));
                break;
            default:
                $route_row_data[] = array('value' => 'Drop Off:');
                $route_row_data[] = array('value' => $this->format_waypoint_list($waypoint, true));
                break;
            }

        };
        return $route_row_data;
    }

    public function format_surcharges_web($surcharge = null) {
        //format for display in job details view
        if (empty($surcharge)) {
            return false;
        };
        $currency = self::get_currency_code();
        $out = array();
        foreach ($surcharge as $key => $surcharge) {
            //init new field
            $field = array();
            //include only label, value and template_id set to text incase needed for output
            switch ($surcharge['name']) {
            case 'Add Surcharge..':
                break;
            default:
                $field['label'] = $surcharge['name'] . '<span style="display: inline-block; float: right;">£</span>';
                $field['value'] = $surcharge['amount'];
                $field['name'] = 'amount';
                $out[] = $field;

                break;
            };

        };
        return $out;
    }
    public function format_quote_web($quote = null) {
        //format for display in job details view
        if (empty($quote)) {
            return false;
        };
        $currency = self::get_currency_code();
        $out = array();
        $output_order = array('distance_cost', 'tax_cost', 'total');

        foreach ($output_order as $key => $field_name) {
            //init new field
            $field = array();
            $value = $quote[$field_name];

            //include only label, value and template_id set to text incase needed for output
            switch ($field_name) {
            case 'distance_cost':
                $field['label'] = 'Delivery Cost <span style="display: inline-block; float: right;">£</span>';
                $field['value'] = $value;
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            case 'tax_cost':
                $field['label'] = 'VAT <span style="display: inline-block; float: right;">£</span>';
                $field['value'] = $value;
                $field['type'] = 'text';
                $field['editable'] = false;
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            case 'total':
                $field['label'] = 'Total Including VAT <span style="display: inline-block; float: right;">£</span>';
                $field['value'] = $value;
                $field['type'] = 'text';
                $field['editable'] = true;
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            };

        };
        return $out;
    }

    //Sets dynamic price to product and adds job id to session
    public function set_price_to_woocommerce($price, $product) {

        $product_id = $product->get_id();
        $woo_product_id = self::get_setting('tq_pro_paypal_options', 'woo_product_id');
        $this->woocommerce_include_tax = (bool) $this->get_setting('', 'woocommerce_include_tax', true);

        if ($product_id == $woo_product_id) {

            if (!session_id()) {
                session_start();
            };

            if (isset($_GET['dynamic_price']) && !isset($_SESSION['dynamic_price'])) {

                $job_id = $_POST["job_id"];
                self::get_job_details_from_id($job_id);
                if ($this->woocommerce_include_tax === true) {
                    $price = $this->quote['total'];
                } else {
                    $price = $this->quote['basic_cost'];
                };

                if (!empty($price)) {
                    $_SESSION['dynamic_price'] = $price;
                    $_SESSION['job_id'] = $job_id;
                    $_SESSION['billing_first_name'] = $_POST["billing_first_name"];
                    $_SESSION['billing_last_name'] = $_POST["billing_last_name"];
                    $_SESSION['billing_phone'] = $_POST["billing_phone"];
                    $_SESSION['billing_email'] = $_POST["billing_email"];
                    $_SESSION['order_comments'] = $_POST["order_comments"];
                } else {
                    global $woocommerce;
                    $woocommerce->cart->empty_cart();
                    $this->get_woocommerce_config();

                    if ($this->woocommerce->config['disable_cart']) {
                        wp_redirect(site_url());
                    } else {
                        wp_redirect($woocommerce->cart->get_cart_url());
                    }
                }
            };

            if (isset($_SESSION['dynamic_price'])) {
                $price = $_SESSION['dynamic_price'];
            };
        }
        return $price;
    }

    public function get_msg_auth_success() {
        return 'Thank you! Your Payment has been authorized successfully.<br/>You will recieve a confirmation email as soon as the payment has been processed.';
    }

    public function get_msg_auth_fail() {
        return 'Sorry, we were unable to process your payment. Please check your PayPal account for more information.';
    }

    private function create_payment_item($job_id) {
        self::get_job_details_from_id($job_id);
        $price = $this->quote['total'];

        return array('name' => self::get_description(),
            'currency' => self::get_currency_code(),
            'quantity' => '1',
            'order_no' => $job_id,
            'price' => $price,
            'customer_id' => $this->job['customer_id'],
        );
    }

    private function get_woocommerce_config() {
        if (!self::woocommerce_is_activated()) {
            return false;
        };
        if (!isset($this->woocommerce)) {
            $disable_cart = self::get_setting('tq_pro_paypal_options', 'disable_cart');
            if ($disable_cart) {
                $this->add_to_cart_redirect_url = wc_get_checkout_url();
            } else {
                $this->add_to_cart_redirect_url = wc_get_cart_url();
            };

            $redirect_page_after_payment = self::get_setting('tq_pro_paypal_options', 'redirect_page_after_payment');
            $woo_product_id = self::get_setting('tq_pro_paypal_options', 'woo_product_id');
            $this->woocommerce = new CT_WOOCOMMERCE(array('disable_cart' => $disable_cart, 'redirect_page_after_payment' => $redirect_page_after_payment, 'woo_product_id' => $woo_product_id));
        };
        // check we have a woocommerce product and if not we add one
        $woo_product_id = self::get_setting('tq_pro_paypal_options', 'woo_product_id');
        if (empty($woo_product_id) || (!$this->woocommerce->product_exists($woo_product_id))) {
            $sales_item_description = self::get_setting('', 'sales_item_description', 'Transportation Fee');
            $woo_product_id = $this->woocommerce->add_transitquote_product(array('name' => $sales_item_description));
            self::save_setting('tq_pro_paypal_options', 'woo_product_id', $woo_product_id);
        };
        $this->woo_product_id = $woo_product_id;

    }

    private function has_paypal_config() {
        if ((!empty($this->application_client_id)) && (!empty($this->application_client_secret))) {
            return true;
        } else {
            return false;
        }
    }

    public function get_description() {
        return $this->sales_item_description = self::get_setting('tq_pro_paypal_options', 'sales_item_description', 'Delivery');
    }

    /**
     * Register the shortcode and display the form.
     *
     * @since    1.0.0
     */
    public function display_rates_list($atts) {
        // display the plugin form

        //set flag to include scripts, only include where plugin is used
        global $add_my_script_flag;
        $add_my_script_flag = true;

        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));

        $this->pick_start_address = (bool) $this->get_setting('', 'pick_start_address', true);

        $this->show_deliver_and_return = $this->get_setting('', 'show_deliver_and_return');
        if ($this->show_deliver_and_return) {
            $deliver_and_return_hidden_class = '';
        } else {
            $deliver_and_return_hidden_class = 'hidden';
        };

        //get paths for includes
        self::get_paths_for_includes();

        // added layout option if given and inline then form will  be inline map else admin setting
        $attributes = shortcode_atts(array(
            'range_start' => 0,
            'range_end' => 100,
            'step' => 5,
        ), $atts);

        $step = $attributes['step'];
        $range_start = $attributes['range_start'];
        $range_end = $attributes['range_end'];
        $this->currency_code = self::get_currency_code();
        $this->currency_symbol = self::get_currency_symbol();
        $this->distance_unit = self::get_distance_unit();
        $this->tax_rate = self::get_tax_rate();
        $this->rounding_type = self::get_rounding_type();
        $this->rates_list = new TransitQuote_Pro4\TQ_Rates_List(array('cdb' => $this->cdb,
            'debug' => $this->debug,
            'tax_rate' => $this->tax_rate,
            'range_start' => $range_start,
            'range_end' => $range_end,
            'step' => $step,
        ));

        $this->view = 'partials/tq-pro-rates-list.php';

        ob_start();
        include $this->view;
        return ob_get_clean();
    }

    public function display_TransitQuote_Pro($atts) {
        // display the plugin form

        //set flag to include scripts, only include where plugin is used
        global $add_my_script_flag;
        $add_my_script_flag = true;

        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));

        $this->pick_start_address = (bool) $this->get_setting('', 'pick_start_address', true);
        $this->ask_for_unit_no = (bool) $this->get_setting('', 'ask_for_unit_no', false);
        $this->ask_for_postcode = (bool) $this->get_setting('', 'ask_for_postcode', false);
        $this->show_contact_name = (bool) $this->get_setting('', 'show_contact_name', false);
        $this->show_contact_number = (bool) $this->get_setting('', 'show_contact_number', false);
        $this->show_driving_time = (bool) $this->get_setting('', 'show_driving_time', true);
        $this->tax_name = $this->get_setting('', 'tax_name', 'VAT');
        $this->tax_rate = $this->get_setting('', 'tax_rate', 0);
        $this->ask_for_date = (bool) $this->get_setting('', 'ask_for_date', true);
        $this->ask_for_time = (bool) $this->get_setting('', 'ask_for_time', true);

        $this->autofill_customer_details = (bool) $this->get_setting('', 'autofill_customer_details', false);
        $this->autofill_collection_address = (bool) $this->get_setting('', 'autofill_collection_address', false);

        if ($this->show_driving_time) {
            $drive_time_hidden_class = '';
        } else {
            $drive_time_hidden_class = 'hidden';
        };

        $this->show_deliver_and_return = $this->get_setting('', 'show_deliver_and_return');
        if ($this->show_deliver_and_return) {
            $deliver_and_return_hidden_class = '';
        } else {
            $deliver_and_return_hidden_class = 'hidden';
        };

        $this->show_tax = ($this->tax_rate > 0);
        if ($this->show_tax) {
            $tax_hidden_class = '';
        } else {
            $tax_hidden_class = 'hidden';
        };

        //get paths for includes
        self::get_paths_for_includes();

        // added layout option if given and inline then form will  be inline map else admin setting
        $attributes = shortcode_atts(array(
            'layout' => '',
            'service' => '',
        ), $atts);

        if ($attributes['layout'] == 'inline') {
            $layout = 1;
        } elseif ($attributes['layout'] == 'popup') {
            $layout = 2;
        } else {
            $layout = 1;
        }
        $this->currency_code = self::get_currency_code();
        $this->currency_symbol = self::get_currency_symbol();
        $this->distance_unit = self::get_distance_unit();
        $this->success_message = self::get_success_message();
        $this->form_section_order = self::get_form_section_order();
        if ($layout == 1) { //Inline Map public
            $this->build_form_include_list();
            $view_name = 'tq-pro-inline-display';
            $this->view_labels = self::get_view_labels($view_name);
            $this->view = 'partials/' . $view_name . '.php';
        } else { //Popup
            $this->build_form_include_list_popup();
            $this->view = 'partials/tq-pro-popup-view.php';
        };
        $this->theme = self::get_setting('tq_pro_form_options', 'form_theme', 'light');
        ob_start();
        include $this->view;
        return ob_get_clean();
    }

    public function get_default_service() {
        //return services which have rates set
        $journey_lengths_table_name = $this->cdb->get_table_full_name('journey_lengths');
        $services_table_name = $this->cdb->get_table_full_name('services');
        $vehicles_table_name = $this->cdb->get_table_full_name('vehicles');
        $rates_table_name = $this->cdb->get_table_full_name('rates');
        // get ordered list of rates with distance 0 as the final record
        $sql = "select distinct s.*
				FROM " . $services_table_name . " s
				inner join " . $rates_table_name . " r
					on r.service_id = s.id
				inner join " . $vehicles_table_name . " v
					on r.vehicle_id = v.id
				inner join " . $journey_lengths_table_name . " jl
					on r.journey_length_id = jl.id
				order by s.id asc
				limit 1;";
        //echo $sql;
        $services = $this->cdb->query($sql);
        if (count($services) > 0) {
            return $services[0];
        };
        return false;
    }

    public function get_default_vehicle() {
        //return services which have rates set
        $journey_lengths_table_name = $this->cdb->get_table_full_name('journey_lengths');
        $services_table_name = $this->cdb->get_table_full_name('services');
        $vehicles_table_name = $this->cdb->get_table_full_name('vehicles');
        $rates_table_name = $this->cdb->get_table_full_name('rates');
        // get ordered list of rates with distance 0 as the final record
        $sql = "select distinct v.*
				FROM wp_tq_pro4_services s
				inner join " . $rates_table_name . " r
					on r.service_id = s.id
				inner join " . $vehicles_table_name . " v
					on r.vehicle_id = v.id
				inner join " . $journey_lengths_table_name . " jl
					on r.journey_length_id = jl.id
				order by v.id asc
				limit 1;";
        //echo $sql;
        $vehicles = $this->cdb->query($sql);
        if (count($vehicles) > 0) {
            return $vehicles[0];
        };
        return false;
    }

    public function get_default_journey_length() {
        //return services which have rates set
        $journey_lengths_table_name = $this->cdb->get_table_full_name('journey_lengths');
        $services_table_name = $this->cdb->get_table_full_name('services_table_name');
        $vehicles_table_name = $this->cdb->get_table_full_name('vehicles_table_name');
        // get ordered list of rates with distance 0 as the final record
        $sql = "select distinct jl.*
				FROM wp_tq_pro4_services s
				inner join " . $services_table_name . " r
					on r.service_id = s.id
				inner join " . $vehicles_table_name . " v
					on r.vehicle_id = v.id
				inner join " . $journey_lengths_table_name . " jl
					on r.journey_length_id = jl.id
				order by jl.id asc
				limit 1;";
        //echo $sql;
        $services = $this->cdb->query($sql);
        if (count($services) > 0) {
            return $services[0];
        };
        return false;
    }

    public function get_services_with_rates_by_id($id) {
        //return services which have rates set
        $services = $this->cdb->get_rows('rates',
            array('service_id' => $id),
            array(),
            null,
            array()
        );
        return $services;

    }
    public function get_services_by_id($id) {
        $services = $this->cdb->get_rows('services',
            array('id' => $id),
            array(),
            null,
            array()
        );
        return $services;
    }

    public function build_form_include_list() {
        $this->form_includes = array();
        //repeat_customer_search_fields

        if ($this->pick_start_address == true) {
            if ($this->autofill_collection_address) {
                $is_repeat_customer = $this->tq_woocommerce_customer->is_repeat_customer();
                if ($is_repeat_customer) {
                    $this->customer = $this->tq_woocommerce_customer->get_tq_customer();
                    if (!empty($this->customer)) {
                        $job = $this->tq_woocommerce_customer->get_latest_job($this->customer['id']);
                        if (!empty($job)) {
                            $this->job_details = $this->tq_woocommerce_customer->get_latest_job_details($job);
                            $search_fields_include = 'repeat_customer_search_fields';
                        } else {
							$search_fields_include = 'search_fields';
						}
                    } else {
                        $search_fields_include = 'search_fields';
                    }
                } else {
                    $search_fields_include = 'search_fields';
                }
            } else {
                $search_fields_include = 'search_fields';
            }

        } else {
            $search_fields_include = 'search_fields_fixed_start';
        };

        // check for repeated customer and load view on that basis

        $customer_fields = 'customer_fields';
        if ($this->autofill_customer_details) {
            $is_repeat_customer = $this->tq_woocommerce_customer->is_repeat_customer();
            if ($is_repeat_customer) {
                $this->customer = $this->tq_woocommerce_customer->get_tq_customer();
                if (!empty($this->customer)) {
                    $job = $this->tq_woocommerce_customer->get_latest_job($this->customer['id']); // no need for this as $this->customer has values till
                    if (!empty($job)) {
                        $this->job_details = $this->tq_woocommerce_customer->get_latest_job_details($job);
                        $customer_fields = 'repeat_customer_fields';
                    }
                }
            }
        }

        switch ($this->form_section_order) {
        case 'Delivery Information':
            $this->form_includes = array(
                array('template' => $search_fields_include,
                    'hidden' => ''),
                array('template' => 'service_vehicle',
                    'hidden' => ''),
                array('template' => 'map',
                    'hidden' => ''),
                array('template' => 'quote_fields',
                    'hidden' => 'hidden'),
                array('template' => $customer_fields,
                    'hidden' => 'hidden'),
                array('template' => 'form-messages',
                    'hidden' => 'hidden'),
            );
            break;
        case 'Customer Information':
            $this->form_includes = array(

                array('template' => $customer_fields,
                    'hidden' => ''),
                array('template' => 'service_vehicle',
                    'hidden' => ''),
                array('template' => $search_fields_include,
                    'hidden' => ''),
                array('template' => 'map',
                    'hidden' => ''),
                array('template' => 'quote_fields',
                    'hidden' => 'hidden'),
                array('template' => 'form-messages',
                    'hidden' => 'hidden'),
            );
            break;
        case 'Quote Only':
            $this->form_includes = array(

                array('template' => $search_fields_include,
                    'hidden' => ''),
                array('template' => 'service_vehicle',
                    'hidden' => ''),
                array('template' => 'map',
                    'hidden' => ''),
                array('template' => 'quote_fields',
                    'hidden' => 'hidden'),
            );
            break;
        }
    }

    public function build_form_include_list_popup() {
        $this->form_includes = array();
        switch ($this->form_section_order) {
        case 'Delivery Information':
            $this->form_includes = array(
                array('template' => 'search_fields_popup',
                    'hidden' => ''),
                array('template' => 'service_vehicle',
                    'hidden' => ''),
                array('template' => 'quote_fields',
                    'hidden' => 'hidden'),
                array('template' => 'customer_fields',
                    'hidden' => 'hidden'),
            );
            break;
        case 'Customer Information':
            $this->form_includes = array(

                array('template' => 'customer_fields',
                    'hidden' => ''),
                array('template' => 'service_vehicle',
                    'hidden' => ''),
                array('template' => 'search_fields_popup',
                    'hidden' => ''),
                array('template' => 'quote_fields',
                    'hidden' => 'hidden'),
            );
            break;
        }
    }

    private function check_payment_status_type_id($payment_status_type_id) {
        if (empty($payment_status_type_id)) {
            $payment_status_type_id = $this->payment_status_type_id;
        };
        if (empty($payment_status_type_id)) {
            return false;
        };
        return $payment_status_type_id;
    }

    public function get_min_price_msg() {
        return $this->get_setting('', 'min_price_message');
    }

    public function get_min_distance_msg() {
        return $this->get_setting('', 'min_distance_message');
    }

    public function get_max_price_msg() {
        return $this->get_setting('', 'max_price_message');
    }

    public function get_max_distance_msg() {
        return $this->get_setting('', 'max_distance_message');
    }

    private function get_result_class($payment_status_type_id = null) {
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

    private function get_result_title($payment_status_type_id = null) {
        $payment_status_type_id = self::check_payment_status_type_id($payment_status_type_id);
        switch ($payment_status_type_id) {
        case 2:
            $result_title = 'Thank You. Your Payment Has Been received Successfully.';
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

    private function get_result_message($payment_status_type_id = null) {
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

    function get_paths_for_includes() {
        $file = dirname(dirname(__FILE__)) . '/tq-pro.php';
        $this->plugin_root_dir = plugin_dir_path($file);
        $this->paypal_partials_dir = $this->plugin_root_dir . 'includes/ct-payment-pp/partials/';
    }

    public function get_service_name($service_id = null) {
        //get service name from id
        if (empty($service_id)) {
            //return 'No service id for job';
            return false;
        };

        if (!isset($this->services[$service_id])) {
            //return "no service_id: ".$service_id.print_r($this->services, true);
            return false;
        };

        if (!isset($this->services[$service_id]['name'])) {
            //return "no name for service_id: ".$service_id.print_r($this->services, true);
            return false;
        };

        return $this->services[$service_id]['name'];
    }

    public function get_services() {
        //return services which have rates set
        $services = $this->cdb->get_rows('services');
        return $services;

    }

    public function get_services_with_rates() {
        //return services which have rates set
        $services = $this->cdb->get_rows('services', array(),
            array('id', 'name', 'description'),
            array('rates' => array('rates', 'service_id', 'id'))
        );
        return $services;

    }

    public function get_vehicle_name($vehicle_id = null) {
        //get service name from id
        if (empty($vehicle_id)) {
            return false;
        };

        if (!isset($this->vehicles)) {
            return false;
        };

        if (empty($this->vehicles)) {
            return false;
        };

        if (!isset($this->vehicles[$vehicle_id])) {
            return false;
        };

        if (!isset($this->vehicles[$vehicle_id]['name'])) {
            return false;
        };

        return $this->vehicles[$vehicle_id]['name'];
    }

    public function get_vehicles() {
        //return services which have rates set
        $vehicles = $this->cdb->get_rows('vehicles');

        return $vehicles;
    }

    public function get_vehicles_with_rates() {
        //return services which have rates set
        $vehicles = $this->cdb->get_rows('vehicles', array(),
            array('id', 'name', 'description'),
            array('rates' => array('rates', 'vehicle_id', 'id'))
        );

        return $vehicles;
    }

    public function has_services() {
        // is there more than one service?

        // is there more than one services in the services table?
        if ($this->cdb->get_count('services') > 1) {
            // do we have rates for more than one service in the rates table?
            if ($this->cdb->get_count_distinct('rates', 'service_id') > 1) {
                return true;
            };
        };
        return false;
    }

    public function has_vehicles() {
        // is there more than one vehicle?
        if ($this->cdb->get_count('vehicles') > 1) {
            // do we have rates for more than one service in the rates table?
            if ($this->cdb->get_count_distinct('rates', 'vehicle_id') > 1) {
                return true;
            };
        };
        return false;
    }

    /*** Front end ajax methods ***/
    public function get_quote() {
        $this->quote = false;
        $this->response_msg = 'There was an error calculating the quote'; //default error
        $this->rate_options = self::get_rate_affecting_options();
        $this->tax_rate = self::get_tax_rate();
        $this->rounding_type = self::get_rounding_type();
        $this->return_percentage = self::get_return_percentage();
        if ($this->rate_options['distance'] > 0) {
            $this->quote = self::calc_quote();
        } else {
            $this->response_msg = 'Distance must be greater than 0';
        };

        $response = self::build_get_quote_response();
        return $response;

    }

    public function get_tax_rate() {
        return self::get_setting('', 'tax_rate', 0);

    }

    public function get_rounding_type() {
        return self::get_setting('', 'round_of_currency', 'Round to 2 decimal points');

    }

    public function get_return_percentage() {
        return self::get_setting('', 'return_journey_adjustment', 100);
    }

    public function calc_quote() {
        $this->rates = self::get_rates_for_journey_options();
        if ($this->rates === false) {
            return false;
        };

        $calc_config = array('debugging' => $this->debug,
            'rates' => $this->rates,
            'include_return_journey' => (bool) $this->rate_options['deliver_and_return'],
            'distance' => $this->rate_options['distance'],
            'return_percentage' => $this->return_percentage,
            'hours' => $this->rate_options['hours'],
            'return_distance' => $this->rate_options['return_distance'],
            'return_time' => $this->rate_options['return_time'],
            'tax_rate' => $this->tax_rate,
            'tax_name' => 'VAT',
            'rounding_type' => $this->rounding_type);

        $this->calculation = new TransitQuote_Pro4\TQ_Calculation($calc_config);

        $quote = $this->calculation->run();
        return $quote;
    }

    private function get_rate_affecting_options() {

        $service = self::get_default_service();
        $vehicle = self::get_default_vehicle();

        $vehicle_id = $this->ajax->param(array('name' => 'vehicle_id', 'optional' => true));
        if (empty($vehicle_id)) {
            $vehicle_id = $vehicle['id'];
        };

        $service_id = $this->ajax->param(array('name' => 'service_id', 'optional' => true));
        if (empty($service_id)) {
            $service_id = $service['id'];
        };

        $distance = $this->ajax->param(array('name' => 'distance', 'optional' => true));
        if (empty($distance)) {
            $distance = 0;
        };

        $hours = $this->ajax->param(array('name' => 'hours', 'optional' => true));
        if (empty($hours)) {
            $hours = 0;
        };

        $return_time = $this->ajax->param(array('name' => 'return_time', 'optional' => true));
        if (empty($return_time)) {
            $return_time = 0;
        };

        $return_distance = $this->ajax->param(array('name' => 'return_distance', 'optional' => true));
        if (empty($return_distance)) {
            $return_distance = 0;
        };

        $deliver_and_return = $this->ajax->param(array('name' => 'deliver_and_return', 'optional' => true));
        if (empty($deliver_and_return)) {
            $deliver_and_return = 0;
        };

        $no_destinations = $this->ajax->param(array('name' => 'no_destinations', 'optional' => true));
        if (empty($no_destinations)) {
            $no_destinations = 1;
        };

        return array('vehicle_id' => $vehicle_id,
            'service_id' => $service_id,
            'distance' => $distance,
            'return_time' => $return_time,
            'deliver_and_return' => $deliver_and_return,
            'return_distance' => $return_distance,
            'no_destinations' => $no_destinations,
            'hours' => $hours);
    }

    private function get_rates_for_journey_options() {
        $rates = false;
        $query = self::get_rates_query_for_journey_options();
        if ($query === false) {
            //echo 'could not get query';
            return false;
        }
        //echo 'rates query';
        //print_r($query);
        return $this->cdb->get_rows('rates', $query);

    }

    private function get_rates_query_for_journey_options() {
        $journey_length_id = self::get_journey_length_id_for_distance();
        if ($journey_length_id === false) {
            //echo 'no journey_length_id.';
            return false;
        } else {
            $rates_query = array('service_id' => $this->rate_options['service_id'],
                'vehicle_id' => $this->rate_options['vehicle_id'],
                'journey_length_id' => $journey_length_id);
        };
        return $rates_query;

    }

    private function get_journey_length_id_for_distance() {
        $this->journey_lengths = self::get_journey_lengths_except_max();
        $journey_length_id = self::get_range_for_number($this->rate_options['distance'], $this->journey_lengths);
        if ($journey_length_id === false) {
            $journey_length_id = self::get_max_journey_length_id();
            //    echo ' OVER MAX JL so jlid is: '.$journey_length_id;
        }
        return $journey_length_id;
    }

    private function get_max_journey_length_id() {
        $query = array('distance' => 0);
        $journey_lengths = $this->cdb->get_rows('journey_lengths', $query);
        if (is_array($journey_lengths)) {
            return $journey_lengths[0]['id'];
        } else {
            $this->response_msg = 'No range set for longest journeys';
            return false;
        }

    }

    public function get_journey_lengths_except_max() {
        $journey_lengths_table_name = $this->cdb->get_table_full_name('journey_lengths');
        // get ordered list of rates with distance 0 as the final record
        $sql = "select distinct *
					from " . $journey_lengths_table_name . "
					where distance > 0
					order by distance asc;";
        //echo $sql;
        $data = $this->cdb->query($sql);
        return $data;
    }

    public function get_range_for_number($number, $ranges) {
        $range_lower_limit = 0;
        foreach ($ranges as $key => $range_limit) {
            $range_upper_limit = $range_limit['distance'];

            if (self::number_in_range($number, $range_lower_limit, $range_upper_limit)) {
                //echo $number.' is betweeten '.$range_lower_limit.' and '.$range_upper_limit;
                return $range_limit['id'];
            } else {
                //echo $number.' is NOT betweeten '.$range_lower_limit.' and '.$range_upper_limit;
                $range_lower_limit = $range_upper_limit;
            }
        };
        return false; //not between any range
    }

    private function number_in_range($number, $range_lower_limit, $range_upper_limit) {
        if ($number > $range_lower_limit && $number <= $range_upper_limit) {
            return true;
        };
        return false;

    }

    private function build_get_quote_response() {
        if (is_array($this->quote)) {
            $response = array('success' => 'true',
                'data' => array('quote' => $this->quote,
                    'rates' => $this->rates,
                    'rate_options' => $this->rate_options));

        } else {
            $response = array('success' => 'false',
                'msg' => $this->response_msg,
                'data' => array('rates' => $this->rates,
                    'rate_options' => $this->rate_options));

        }
        return $response;
    }

    public function tq_pro_get_quote_callback() {
        $this->plugin = new TransitQuote_Pro4();
        $this->cdb = $this->plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));
        self::get_plugin_settings();
        // save job request from customer facing form
        if ($this->log_requests == true) {
            $this->ajax->log_requests();
        };

        // get the submit type for the submitted qutoe form
        $submit_type = $this->ajax->param(array('name' => 'submit_type', 'optional' => true));
        $response = self::get_quote($submit_type);

        if ($response === false) {
            $response = array('success' => false,
                'msg' => 'Sorry, an error occured and we are unable to process this request.');
        };

        $this->ajax->respond($response);
    }

    public function tq_pro_pay_now_callback() {
        $this->plugin = new TransitQuote_Pro4();
        $this->cdb = $this->plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));
        self::get_plugin_settings();
        // save job request from customer facing form
        if ($this->log_requests == true) {
            $this->ajax->log_requests();
        };

        if (self::job_data_is_valid()) {

            $job_id = self::save_new_job();
            if (empty($job_id)) {
                $response = array('success' => 'false',
                    'msg' => 'Unable to save new job');
                $this->ajax->respond($response);
                return false;
            };
            self::get_job_details_from_id($job_id);
            self::get_woocommerce_config();
            if (!self::update_payment_type_id($job_id, 3)) {
                $response = array('success' => 'false',
                    'msg' => 'Unable to update job ' . $job_id . ' to payment by woocommerce');
                $this->ajax->respond($response);
            };

            //set payment status to 1 = Awaiting Payment
            if (!self::update_payment_status_id($job_id, 1)) {
                $response = array('success' => 'false',
                    'msg' => 'Unable to update job ' . $job_id . ' to payment by woocommerce');
                $this->ajax->respond($response);
            };

            $response = self::build_response_save_job_for_woocommerce($job_id);

        } else {
            $response = self::build_invalid_job_response();
        }

        if ($response === false) {
            $response = array('success' => false,
                'msg' => 'Sorry, an error occured and we are unable to process this request.');
        };

        $this->ajax->respond($response);
    }

    public function tq_pro_save_job_callback() {
        $this->plugin = new TransitQuote_Pro4();
        $this->cdb = $this->plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));
        self::get_plugin_settings();
        // save job request from customer facing form
        if ($this->log_requests == true) {
            $this->ajax->log_requests();
        };

        if (self::job_data_is_valid()) {
            $job_id = self::save_new_job();
            if (empty($job_id)) {
                $response = array('success' => 'false',
                    'msg' => 'Unable to save new job');
                $this->ajax->respond($response);
                return false;
            };
            self::get_job_details_from_id($job_id);

            if (!self::update_payment_type_id($job_id, 1)) {
                $response = array('success' => 'false',
                    'msg' => 'Unable to update job ' . $job_id . ' to payment on delivery');
                $this->ajax->respond($response);
                return false;
            };

            //set payment status to 1 = Awaiting Payment
            if (!self::update_payment_status_id($job_id, 1)) {
                return array('success' => 'false',
                    'msg' => 'Unable to update job ' . $job_id . ' to awaiting payment');
                $this->ajax->respond($response);
                return false;
            };

            $response = self::build_response_save_job($job_id);

        } else {
            $response = self::build_invalid_job_response();
        };

        $this->ajax->respond($response);
    }

    public function job_data_is_valid() {
        $this->invalid_fields = array();
        $required_customer_fields = array('first_name', 'last_name', 'email');
        foreach ($required_customer_fields as $key => $field_name) {
            if (!$this->ajax->param_check(array('name' => $field_name, 'optional' => false))) {
                array_push($this->invalid_fields, array('name' => str_replace('_', ' ', $field_name),
                    'error' => 'empty'));
            };
        };

        $journey_order = self::get_journey_order_from_post_data();
        if (count($journey_order) < 2) {
            array_push($this->invalid_fields, array('name' => $field_name,
                'error' => 'Less than 2 addresses'));

        };

        foreach ($journey_order as $key => $address_index) {
            $record_data = self::get_location_record_data('locations', $address_index);
            $location_name = 'location ' . $address_index;
            if (empty($record_data['lat'])) {
                $field_name = $location_name . '.lat';
                array_push($this->invalid_fields, array('name' => $field_name,
                    'error' => 'empty'));
            };
            if (empty($record_data['lng'])) {
                $field_name = $location_name . '.lng';
                array_push($this->invalid_fields, array('name' => $field_name,
                    'error' => 'empty'));
            };
            if (empty($record_data['address'])) {
                $field_name = $location_name . '.address';
                array_push($this->invalid_fields, array('name' => $field_name,
                    'error' => 'empty'));
            };
        };

        return (count($this->invalid_fields) === 0);
    }

    public function build_invalid_job_response() {
        $error_list = '';
        foreach ($this->invalid_fields as $key => $invalid_field) {
            $error_list .= $invalid_field['name'] . ' - ' . $invalid_field['error'] . '<br/>';
        }

        return array('success' => 'false',
            'msg' => 'Invalid information received:<br/>' . $error_list,
            'invalid_fields' => $this->invalid_fields);
    }

    public function save_new_job() {
        //get the job id in submitted form, unless it is a quote request submission
        $job_id = $this->ajax->param(array('name' => 'job_id', 'optional' => true));
        if (empty($job_id)) { //save and return job id
            return self::save_job();
        };
        return $job_id;
    }

    private function build_response_save_job($job_id = null) {

        return array('success' => 'true',
            'success_message' => 'Your job was received successfully<br/>The delivery reference number is: ' . $job_id . '</p>',
            'data' => array('customer_id' => $this->customer['id'],
                'job_id' => $job_id,
                'quote_id' => $this->quote['id'],
                'email' => $this->customer['email']));

    }

    private function build_response_save_job_for_woocommerce($job_id = null) {

        return array('success' => 'true',
            'success_message' => 'Your job was received successfully<br/>The delivery reference number is: ' . $job_id . '</p>',
            'data' => array('customer_id' => $this->customer['id'],
                'job_id' => $job_id,
                'quote_id' => $this->quote['id'],
                'email' => $this->customer['email'],
                'product_id' => $this->woo_product_id,
                'add_to_cart_redirect_url' => $this->add_to_cart_redirect_url));

    }

    public function get_job_details_from_id($job_id) {

        $this->job = self::get_job($job_id);
        if ($this->job === false) {
            $this->ajax->log_error(array('name' => 'Could not get job to update',
                'value' => 'job_id: ' . $this->job['id']));
            return false;
        };

        if (self::job_is_available($this->job)) {
            $this->job = self::get_job_details($this->job);
        };
    }

    public function get_job_id() {
        //return curernt job id
        if (!isset($this->job)) {
            return false;
        };

        if (empty($this->job['id'])) {
            return false;
        };
        return $this->job['id'];
    }

    public function save_job() {
        $success = 'true';
        //default message
        $message = 'Request booked successfully';

        //get email for notification
        $email = $this->ajax->param(array('name' => 'email'));

        $existing_customer = self::get_customer_by_email($email);
        $wp_user_id = $this->tq_woocommerce_customer->is_logged_in();
        if ($existing_customer === false) {
            //save new customer as we have a new email address
            if ($wp_user_id) {
                $this->customer = self::save('customers', null, array('wp_user_id' => $wp_user_id));
            } else {
                $this->customer = self::save('customers');
            }
        } else {
            //save against an existing customer email
            //we can pass id and it will not be overwritten as it is not in the post data
            if ($wp_user_id) {
                $this->customer = self::save('customers', null, array('id' => $existing_customer['id'], 'wp_user_id' => $wp_user_id));
            } else {
                $this->customer = self::save('customers', null, array('id' => $existing_customer['id']));
            }
        };

        $this->quote = self::save('quotes');
        //$this->quote_surcharge_ids = self::save_surcharges($this->quote['id']);

        //To do: create a many to many address relationship with job with an order index
        //save job, passing id values not included in post data

        $this->job = self::save('jobs', null, array('customer_id' => $this->customer['id'],
            'accepted_quote_id' => $this->quote['id']));

        $this->save_journey();
        $this->journey_order = $this->get_journey_order_from_post_data();
        if (!$this->save_locations()) {
            $success = 'false';
            $message = 'Unable to save locations';
        };
        if (!$this->save_journeys_locations()) {
            $success = 'false';
            $message = 'Unable to save route information';
        };
        if (self::job_is_available()) {
            $this->job = self::get_job_details($this->job);
        };

        //echo 'success: '.$success.' '.$message;
        if ($success === 'true') {
            $email = self::email_dispatch('New Job Booking - ref: ' . $this->job['id'] . " " . $this->customer['first_name'] . " " . $this->customer['last_name']);
            $customer_email = self::email_customer();
            return $this->job['id'];
        } else {
            return false;
        }
    }

    private function save_journey() {
        //a job could potentially have multiple journeys so save job id against table
        $this->journey = self::save('journeys', null, array('job_id' => $this->job['id']));
    }

    function get_journey_order_from_post_data() {
        // build array of address post field indexes in order of journey_order
        $journey_order = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'journey_order')) {
                // key example: address_1_journey_order
                $key_array = explode('_', $key);
                $address_index = $key_array[1];
                $journey_order[$value] = $address_index;
            }
        };
        return $journey_order;
    }

    private function load_journey_locations() {
        // load all locations in journey
        $this->locations_in_journey_order = array();
        foreach ($this->journey_order as $key => $journey_stop) {
            $location = $this->load_location($journey_stop['location_id']);
            if ($location === false) {
                self::debug('Unable to save location: ' . $address_index);
                return false;
            };
            // store ids in array ready for save
            $this->locations_in_journey_order[$key] = array('location' => $location,
                'journey_id' => $journey_stop['journey_id'],
                'location_id' => $journey_stop['location_id'],
                'journey_order' => $key,
                'created' => date('Y-m-d G:i:s'),
                'modified' => date('Y-m-d G:i:s'),
                'contact_name' => $journey_stop['contact_name'],
                'contact_phone' => $journey_stop['contact_phone']);
        };
    }

    private function load_location($location_id) {
        return $this->cdb->get_row('locations', $location_id);
    }

    private function save_locations() {
        // save all locations in journey
        $this->locations_in_journey_order = array();
        foreach ($this->journey_order as $key => $address_index) {
            $location = $this->save_location($address_index);
            if (empty($location)) {
                self::debug('Unable to save location: ' . $address_index);
                return false;
            };
            if ($location['id'] == 0) {
                self::debug('Unable to save location: ' . $address_index);
                return false;
            };

            $journey_order_rec = array('journey_id' => $this->journey['id'],
                'location_id' => $location['id'],
                'journey_order' => $key,
                'created' => date('Y-m-d G:i:s'),
                'modified' => date('Y-m-d G:i:s'));

            $journey_order_optional_fields = self::get_journey_order_optional_fields($key);
            $journey_order_rec = array_merge($journey_order_rec, $journey_order_optional_fields);

            // store ids in array ready for save
            $this->locations_in_journey_order[$key] = $journey_order_rec;
        };

        return true;

    }

    private function get_journey_order_optional_fields($idx) {
        $journey_order_optional_fields = array();

        $contact_name_field_name = 'address_' . $idx . '_contact_name';
        $contact_name = $this->ajax->param(array('name' => $contact_name_field_name, 'optional' => true));
        if (!empty($contact_name)) {
            $journey_order_optional_fields['contact_name'] = $contact_name;
        };

        $contact_phone_field_name = 'address_' . $idx . '_contact_name';
        $contact_phone = $this->ajax->param(array('name' => $contact_phone_field_name, 'optional' => true));
        if (!empty($contact_name)) {
            $journey_order_optional_fields['contact_phone'] = $contact_phone;
        };
        return $journey_order_optional_fields;
    }

    private function save_location($address_index) {
        $record_data = self::get_location_record_data('locations', $address_index);
        if (empty($record_data['lat']) || empty($record_data['lng']) || empty($record_data['address'])) {
            return false;
        };
        $location_id = self::get_location_by_address($record_data);
        if (empty($location_id)) {
            //no match, create new location in database
            $location_id = self::save_record('locations', $record_data);
            if (empty($location_id)) {
                return false;
            };
            // add new id to array of location details
            $location['id'] = $location_id;
        } else {

            //existing location
            $location = $this->cdb->get_row('locations', $location_id);
        };

        if (empty($location)) {
            return false;
        };

        return $location;
    }

    private function get_location_record_data($table, $idx = null) {
        //get params for records data from front end
        //idx is a 0 based index for where more than one rec is passed
        //get the field names to save
        $fields = $this->cdb->get_table_col_names($table);
        if ($fields === false) {
            $this->ajax->respond(array('success' => 'false',
                'msg' => 'Invalid table for update ' . $table));
        };

        //append string to param name for instances of more than 1 rec
        $idx_str = '';
        if (is_numeric($idx)) {
            $idx_str = '_' . $idx;
        };

        //init the record array
        $record_data = array();

        //get parameters
        foreach ($fields as $key => $field) {
            switch ($field) {
            case 'created':
            case 'modified':
                $record_data[$field] = date('Y-m-d G:i:s');
                break;
            default:
                $param_name = 'address' . $idx_str . '_' . $field;
                $val = $this->ajax->param(array('name' => $param_name, 'optional' => true));
                if (!empty($val)) {
                    $record_data[$field] = sanitize_text_field($val);
                };
                if (strrpos($field, '_date') > -1) {
                    $record_data[$field] = $this->cdb->mysql_date($record_data[$field]);
                };
            };
        };

        return $record_data;
    }

    private function get_location_by_address($record_data) {
        //check for an existing location by its address and lat lng coordinates
        if (empty($record_data['lat'])) {
            return false;
        };
        if (empty($record_data['lng'])) {
            return false;
        };

        $lat = round($record_data['lat'] / 10, 7) * 10;
        $lng = round($record_data['lng'] / 10, 7) * 10;
        $query = array('address' => $record_data['address'],
            'lat' => $lat,
            'lng' => $lng);
        $location = $this->cdb->get_rows('locations', $query,
            array('id'));

        if (empty($location)) {
            return false;
        };

        return $location[0]['id'];

    }

    private function load_journey_order($journey_id) {

        $this->journey_order = $this->cdb->get_rows('journeys_locations',
            array('journey_id' => $journey_id),
            array(),
            null,
            array('journey_order' => 'asc')
        );

    }

    private function save_journeys_locations() {
        // save all locations in journey
        foreach ($this->locations_in_journey_order as $key => $step) {
            $row_id = self::save_record('journeys_locations', $step);
            if ($row_id === false) {
                self::debug(array('msg' => 'Unable to save journeys_locations: ' . $key,
                    'data' => $step));
                return false;
            }
        }
        return true;
    }
    /*
    Payment Methods After Recieving Quote
     */

    private function request_payment_after_confirmation($job_id = null) {
        if (empty($job_id)) {
            return array('success' => 'false',
                'msg' => 'No job_id for payment on delivery');
        };

        return array('success' => 'true',
            'success_message' => 'Your job was received successfully<br/>The delivery reference number is: ' . $job_id . '</p>',
            'data' => array('customer_id' => $this->customer['id'],
                'job_id' => $job_id,
                'quote_id' => $this->quote['id'],
                'email' => $this->customer['email']),
            'payment_method' => 1);

    }

    private function request_payment_on_delivery($job_id = null) {
        if (empty($job_id)) {
            return array('success' => 'false',
                'msg' => 'No job_id for payment on delivery');
        };

        if (!self::update_payment_type_id($job_id, 1)) {
            self::debug('could not update payment_type');
            return false;
        };

        //set payment status to 1 = Awaiting Payment
        if (!self::update_payment_status_id($job_id, 1)) {
            return array('success' => 'false',
                'msg' => 'Unable to update job ' . $job_id . ' to payment on delivery');
        };

        return array('success' => 'true',
            'success_message' => '<h2>Thank You.</h2><p>Your job has now been booked with payment due on delivery.<br/>Your reference number is: ' . $job_id . '</p>',
            'data' => array('customer_id' => $this->customer['id'],
                'job_id' => $job_id,
                'quote_id' => $this->quote['id'],
                'email' => $this->customer['email']),
            'payment_method' => 1);

    }

    private function request_payment_paypal($job_id = null) {
        if (empty($job_id)) {
            return array('success' => 'false',
                'msg' => 'No job_id for payment by PayPal');
        };

        if (!self::update_payment_type_id($job_id, 2)) {
            self::debug('could not update payment_type');
            return false;
        };

        //set payment status to 1 = Awaiting Payment
        if (!self::update_payment_status_id($job_id, 1)) {
            return array('success' => 'false',
                'msg' => 'Unable to update job ' . $job_id . ' to payment by paypal');
        };

        return array('success' => 'true',
            'msg' => 'Job booked successfully',
            'data' => array('customer_id' => $this->customer['id'],
                'job_id' => $this->job['id'],
                'quote_id' => $this->quote['id'],
                'email' => $this->customer['email']),
            'payment_method' => 2);

    }

    private function request_payment_woocommerce($job_id = null) {
        if (empty($job_id)) {
            return array('success' => 'false',
                'msg' => 'request_payment_woocommerce: No job_id for payment by woocommerce');
        };

        if (!self::woocommerce_is_activated()) {
            return array('success' => 'false',
                'msg' => 'Error: WooCommerce has not been activated.');
        };
        self::get_woocommerce_config();

        $product_id = $this->woo_product_id;

        if (!self::update_payment_type_id($job_id, 3)) {
            self::debug('could not update payment_type');
            return false;
        };

        //set payment status to 1 = Awaiting Payment
        if (!self::update_payment_status_id($job_id, 1)) {
            return array('success' => 'false',
                'msg' => 'Unable to update job ' . $job_id . ' to payment by woocommerce');
        };

        return array('success' => 'true',
            'msg' => 'Job booked successfully',
            'data' => array('customer_id' => $this->customer['id'],
                'job_id' => $this->job['id'],
                'quote_id' => $this->quote['id'],
                'email' => $this->customer['email'],
                'product_id' => $product_id),
            'payment_method' => 3);

    }

    public function get_record_data($table, $idx = null) {
        //get params for records data from front end
        //idx is a 0 based index for where more than one rec is passed
        //get the field names to save
        $fields = $this->cdb->get_table_col_names($table);
        if ($fields === false) {
            $this->ajax->respond(array('success' => 'false',
                'msg' => 'Invalid table for update ' . $table));
        };
        //append string to param name for instances of more than 1 rec
        $idx_str = '';
        if (is_numeric($idx)) {
            $idx_str = '_' . $idx;
        };

        //init the record array
        $record_data = array();
        //get parameters
        foreach ($fields as $key => $field) {
            switch ($field) {
            case 'start_date':
            case 'end_date':
                $chosen_date = $this->ajax->param(array('name' => $field, 'optional' => false));
                $record_data[$field] = date('Y-m-d H:i:s', strtotime($chosen_date));
                break;
            case 'created':
            case 'modified':
            case 'purchase_date':
                $record_data[$field] = date('Y-m-d G:i:s');
                break;
            case 'delivery_time':
                $delivery_date = $this->ajax->param(array('name' => 'delivery_date', 'optional' => !$this->ask_for_date));
                if (!empty($delivery_date)) {
                    $date = new DateTime($delivery_date);
                } else {
                    $date = new DateTime();
                };

                $delivery_time = $this->ajax->param(array('name' => 'delivery_time_submit', 'optional' => !$this->ask_for_time));
                if (!empty($delivery_time)) {
                    $time_parts = explode(':', $delivery_time);
                    $hours = $time_parts[0];
                    $mins = $time_parts[1];
                    $mins_parts = explode(' ', $mins);
                    $date->setTime($hours, $mins_parts[0]);
                }
                $record_data[$field] = $date->format('Y-m-d H:i:s');
                break;
            default:
                $field_name = $field . $idx_str;
                //$this->ajax->pa($field_name);
                $val = $this->ajax->param(array('name' => $field_name, 'optional' => true));
                if (!empty($val)) {
                    $record_data[$field] = sanitize_text_field($val);
                };
                if (strrpos($field, '_date') > -1) {
                    $record_data[$field] = $this->cdb->mysql_date($record_data[$field]);
                };
            };
        };
        return $record_data;
    }

    public function job_details_list($header, $data) {
        //return job details info in list for text email
        $text = $header . "\r\n\r\n";
        $rows = array();
        foreach ($data as $field) {
            if (empty($field['label'])) {
                $rows[] = $field['value'];
            } else {
                $rows[] = $field['label'] . ': ' . $field['value'];
            }

        };
        $text .= implode("\r\n", $rows);
        echo $text . "\r\n\r\n";
    }
    public function job_details_table($header, $data) {

        $rows = array();
        foreach ($data as $field) {
            if (empty($field['label'])) {
                $row = '<td>' . $field['value'] . '</td>';
                $html = '<table><tr><th colspan="1">' . $header . '</th></tr><tr>';
            } else {
                $row = '<td>' . $field['label'] . '</td><td>' . $field['value'] . '</td>';
                $html = '<table><tr><th colspan="2">' . $header . '</th></tr><tr>';
            }

            $rows[] = $row;
        };

        if (count($rows) === 0) {
            echo '<table><tr><th colspan="1">' . $header . '</th></tr><tr><tr><td>No information available.</td></tr>';
        };
        $html .= implode('</tr><tr>', $rows);
        $html .= '</tr></table>';
        echo $html;
    }

    public function get_job($job_id = null) {
        //get job record from property or database
        if (empty($job_id)) {
            // if no job passed, get the job currently being processed from the job property
            if (empty($this->job)) {
                // if the job property is not set return false
                return false;
            } else {
                // return the job property
                return $this->job;
            }
        };
        //if we do have a passed job id, get the job from the table
        return $this->cdb->get_row('jobs', $job_id);
    }

    function job_is_available($job = null) {
        if (empty($job)) {
            $job = $this->job;
        };

        if (empty($job)) {
            return false;
        };
        return true;
    }

    public function get_job_details($job = null) {
        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        //add the details to a job record

        $job['customer'] = $this->customer = self::get_customer($job['customer_id']);
        $job['journey'] = $this->journey = self::get_journey_by_job_id($job['id']);
        $job['stops'] = self::get_journey_stops($job['journey']['id']);
        self::load_journey_order($job['journey']['id']);
        self::load_journey_locations();

        if (!isset($this->quote)) {
            if (!empty($job['accepted_quote_id'])) {
                $this->quote = $this->cdb->get_row('quotes', $job['accepted_quote_id']);
                if ($this->quote === false) {
                    self::debug(array('name' => 'Could not load quote',
                        'value' => 'job_id: ' . $job['id']));
                };
            }
        };
        $job['quote'] = $this->quote;
        $job['job_date'] = self::get_job_date($job);
        $job['payment'] = self::get_job_payment($job);
        return $job;
    }

    public function get_customer($customer_id) {
        $customer = $this->cdb->get_row('customers', $customer_id);
        if ($customer === false) {
            self::debug(array('name' => 'get_customer:Could not load customer',
                'value' => 'customer_id: ' . $customer_id));
        };
        return $customer;
    }

    public function get_journey_by_job_id($job_id) {

        $journey = $this->cdb->get_row('journeys', $job_id, 'job_id');
        if ($journey === false) {
            self::debug(array('name' => 'Could not load journey',
                'value' => 'job_id: ' . $job_id));
        };
        return $journey;
    }

    function get_journey_stops($journey_id = null) {
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
                'lng',
                'jl.contact_name as contact_name',
                'jl.contact_phone as contact_phone'),
            array(
                array('journeys_locations jl',
                    'location_id',
                    'id',
                    'journey_id = ' . $journey_id,
                    'inner'),
            ),
            array('journey_order' => 'asc')
        );
    }

    public function get_job_date($job = null) {

        //get date and time for job in separate  array elements
        if (empty($job)) {
            $job = $this->job;
        };

        if (empty($job)) {
            //no job passed
            self::debug(array('name' => 'No job to get move day.'));
            return false;
        };

        if (empty($job['delivery_time'])) {
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

        $date = $this->dbui->format_date($job['delivery_time']);
        $time = $this->dbui->format_time($job['delivery_time']);

        // $date = $dt->format('m/d/y');

        $job_date[0] = array('label' => 'Pick Up Date',
            'value' => $date);

        // $job_date[1] = array('label'=>'Pick Up Time', 'value'=>$hours.':'.$mins);
        $job_date[1] = array('label' => 'Pick Up Time', 'value' => $time);

        return $job_date;
    }

    public function get_job_payment($job) {
        $job_payment = array();

        $payment_method = self::get_job_payment_method($job);
        if (!empty($payment_method)) {
            $job_payment[] = array('label' => 'Payment Method',
                'value' => $payment_method);
        };

        $payment_status = self::get_job_payment_status($job);
        if (!empty($payment_status)) {
            $job_payment[] = array('label' => 'Payment Status',
                'value' => $payment_status);
        };
        return $job_payment;
    }

    private function get_job_payment_method($job) {
        if (empty($job['payment_type_id'])) {
            return false;
        };

        $payment_type_id = $job['payment_type_id'];
        $payment_type = $this->cdb->get_field('payment_types', 'name', $payment_type_id);
        if (empty($payment_type)) {
            return false;
        } else {
            return $payment_type;
        };

    }

    private function get_job_payment_status($job) {
        if (empty($job['payment_status_id'])) {
            return false;
        };

        $payment_status_id = $job['payment_status_id'];
        $payment_status = $this->cdb->get_field('payment_statuses', 'description', $payment_status_id);
        if (empty($payment_status)) {
            return false;
        } else {
            return $payment_status;
        };
    }

    public function save($table, $idx = null, $defaults = null) {
        if (empty($table)) {
            return false;
        };

        //get param data
        $record_data = self::get_record_data($table, $idx);

        if (!empty($defaults)) {
            //merge with passed data
            $record_data = array_merge($defaults, $record_data);
        }

        $row_id = self::save_record($table, $record_data);
        $record_data['id'] = $row_id;
        return $record_data;
    }
    public function save_record($table, $record_data) {
        ////Save the main event record
        //    $prefix = $this->cdb->get_prefix();
        //    $this->ajax->pa(array('prefix'=>$prefix));
        $success = false;
        //save or update
        $rec_id = $this->cdb->update_row($table, $record_data);
        if ($rec_id === false) {
            $this->ajax->respond(array('success' => 'false',
                'msg' => 'Unable to update ' . $table,
                'sql' => $this->cdb->last_query));
        };
        return $rec_id;
    }

    public function get_layout() {
        return self::get_setting($this->tab_2_settings_key, 'layout', 'inline');
    }
    public function get_customer_by_email($email) {
        //check for the email address to see if this is a previous customer
        if (empty($email)) {
            return false;
        };
        //load customer by email
        $customer = $this->cdb->get_row('customers', $email, 'email');
        return $customer;
    }

    public function get_customer_email() {
        return $this->customer['email'];
    }

    public function test_customer_email($job_id) {
        $this->job = self::get_job($job_id);

        //get details for the job
        if (self::job_is_available()) {
            $this->job = self::get_job_details($this->job);
        };

        $message = self::get_customer_message();

        ob_start();
        include 'partials/emails/email_customer.php';
        $html_email = ob_get_clean();

        echo $html_email;
    }

    public function test_dispatch_email($job_id) {
        $this->job = self::get_job($job_id);

        //get details for the job
        if (self::job_is_available()) {
            $this->job = self::get_job_details($this->job);
        };

        ob_start();
        include 'partials/emails/email_job_details.php';
        $html_email = ob_get_clean();

        echo $html_email;
    }

    private function email_customer() {
        //send email to customer

        $to = self::get_customer_email();
        $from = self::get_from_address();
        $from_name = self::get_from_name();
        $subject = self::get_customer_subject();
        $message = self::get_customer_message();

        //test address
        //$headers = "Bcc: contact@creativetransmissions.com"."\r\n";
        $headers = "";

        ob_start();
        include 'partials/emails/email_customer.php';
        $html_email = ob_get_clean();

        //    add_filter('wp_mail_content_type', array( $this, 'set_content_type' ) );
        //$this->ajax->set_email_debug(true);
        $email = $this->ajax->send_notification($to,
            $from,
            $from_name,
            $subject,
            $html_email, $headers);

        //    remove_filter( 'wp_mail_content_type', array( $this, 'set_content_type' ) );

        return $html_email;
    }
    private function email_dispatch($subject) {

        //get email addresses to send notifications to
        $notification_addresses = self::get_notification_emails();

        //spit email addresses field incase there is more than one
        $this->notification_emails = explode(',', $notification_addresses);

        if (count($this->notification_emails) === 0) {
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
            $headers .= "Bcc: " . $address . "\r\n";
        };

        ob_start();
        include 'partials/emails/email_job_details.php';
        $html_email = ob_get_clean();

        //    add_filter('wp_mail_content_type', array( $this, 'set_content_type' ) );
        //$this->ajax->set_email_debug(true);
        $email = $this->ajax->send_notification($to,
            $from,
            $from_name,
            $subject,
            $html_email, $headers);

        //    remove_filter( 'wp_mail_content_type', array( $this, 'set_content_type' ) );

        return $email;
    }

    public function display_internal_email_preview($atts) {
        // display the quote and payment page

        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));

        //get paths for includes
        self::get_paths_for_includes();

        $this->job_id = $this->ajax->param(array('name' => 'job_id', 'optional' => true));
        if (empty($this->job_id)) {
            return '';
        } else {
            echo 'Email from job: ' . $this->job_id . '<br/><br/>';
            $this->view_labels = self::get_view_labels('email_job_details');
            self::get_job_details_from_id($this->job_id);
            ob_start();
            include 'partials/emails/email_job_details.php';
            $html_email = ob_get_clean();
        };
        return nl2br($html_email);
    }

    public function display_customer_email_preview($atts) {
        // display the quote and payment page

        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $this->ajax = new TransitQuote_Pro4\CT_AJAX(array('cdb' => $this->cdb, 'debugging' => $this->debug));

        //get paths for includes
        self::get_paths_for_includes();

        $this->job_id = $this->ajax->param(array('name' => 'job_id', 'optional' => true));
        if (empty($this->job_id)) {

            return 'no job id';
        } else {
            echo 'Email for job ref: ' . $this->job_id . '<br/><br/>';
            $this->view_labels = self::get_view_labels('email_customer');
            self::get_job_details_from_id($this->job_id);
            ob_start();
            include 'partials/emails/email_customer.php';
            $html_email = ob_get_clean();
        };
        return nl2br($html_email);
    }

    public function get_api_string() {
        $api_string = '';
        $this->api_key = self::get_api_key();
        if (!empty($this->api_key)) {
            $api_string = '&key=' . $this->api_key;
        };

        return $api_string;
    }
    public function get_api_key() {
        //get google maps api key
        $this->api_key = self::get_setting($this->tab_2_settings_key, 'api_key', '');
        if (empty($this->api_key)) {
            return false;
        };
        return $this->api_key;
    }
    public function get_customer_subject() {
        return self::get_setting($this->tab_5_settings_key, 'customer_subject', 'Your Quote Is Enclosed.');
    }
    public function get_geolocate() {
        return self::get_setting($this->tab_2_settings_key, 'geolocate');
    }
    public function get_distance_unit() {
        return self::get_setting($this->tab_2_settings_key, 'distance_unit', 'Kilometer');
    }

    public function get_payment_buttons() {
        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $methods = $this->cdb->get_rows('payment_types', array('available' => 1), array('id', 'name'), null);
        if (count($methods) === 0) {
            // no payment methods available. Perhaps for quote only.
            return '';
        };

        $selected_payment_methods = self::get_selected_payment_methods();
        if (empty($selected_payment_methods)) {
            return 'No Payment Methods Are Currently Available';
        };

        //build array of buttons based on payment methods available in the payment_types table
        $button_html = '';

        $buttons = array();
        $options = get_option('tq_pro_paypal_options');

        foreach ($methods as $key => $payment_method) {
            if (self::check_payment_config($payment_method['id'])) {
                if (in_array($payment_method['id'], $selected_payment_methods)) {
                    $payment_button_name = self::get_payment_button_name($payment_method);
                    $button_html = '<button id="pay_method_' . $payment_method['id'] . '" class="tq-button" type="submit" name="submit" value="pay_method_' . $payment_method['id'] . '">' . $payment_button_name . '</button>';
                    array_push($buttons, $button_html);
                }
            };
        };

        $button_panel = '<div class="tq-payment-buttons btn_wrap">';
        $button_panel .= implode('', $buttons);
        $button_panel .= '</div>';

        return $button_panel;

    }

    public function get_selected_payment_methods() {
        return self::get_setting('tq_pro_paypal_options', 'payment_types', array());
    }

    private function get_payment_button_name($payment_method) {
        if ($payment_method['id'] == 3) {
            $payment_button_name = self::get_setting('tq_pro_paypal_options', 'payment_button_name', 'Pay Online');
        } elseif ($payment_method['id'] == 1) {
            $payment_button_name = self::get_setting('tq_pro_paypal_options', 'payment_button_on_delivery_name', 'On Delivery');
        } else {
            $payment_button_name = $payment_method['name'];
        };
        return $payment_button_name;
    }

    private function get_return() {
        // get return address, note this only works when included not when called via ajax
        $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        if (strpos($url, '?') > -1) {
            $glue = '&';
        } else {
            $glue = '?';
        };
        return 'http://' . $url . $glue . 'action=paypal';
    }

    public function get_success_message() {
        return self::get_setting($this->tab_2_settings_key, 'success_message',
            'Thank you for your enquiry, we accept credit card payments online via PayPal (no login required) or on delivery.');
    }
    public function get_customer_message() {
        return self::get_setting($this->tab_5_settings_key, 'customer_message', 'Thank you for your request.');
    }

    public function get_currency() {
        $currency = self::get_setting($this->tab_2_settings_key, 'currency');
        return $currency;
    }

    public function get_currency_code() {
        $this->currency = self::get_currency();
        if (empty($this->currency)) {
            return false;
        };
        $this->currency_code = $this->cdb->get_field('currencies', 'currency_code', $this->currency);
        if (($this->currency_code === 'custom') || empty($this->currency_code)) {
            $this->currency_code = self::get_setting('', 'custom_currency_code');
        }
        return $this->currency_code;
    }

    public function get_currency_symbol() {
        $this->currency = self::get_currency();
        if (empty($this->currency)) {
            return false;
        };
        $this->currency_symbol = $this->cdb->get_field('currencies', 'symbol', $this->currency);
        if (($this->currency_symbol === 'custom') || empty($this->currency_symbol)) {
            $this->currency_symbol = self::get_setting('', 'custom_currency_symbol');
        }
        return $this->currency_symbol;
    }

    public function get_form_section_order() {
        $form_section_order = self::get_setting('tq_pro_form_options', 'form_section_order', 'Delivery Information');
        if (empty($form_section_order)) {
            return false;
        };
        return $form_section_order;
    }

    public function get_oldest_job_date() {
        $plugin = new TransitQuote_Pro4();
        $this->cdb = $plugin->get_custom_db();
        $jobs = $this->cdb->get_rows('jobs', array(), array('id', 'created'), null);
        if (empty($jobs)) {
            return 'no jobs';
        };
        if (!isset($jobs[0])) {
            return 'no first job';
        };
        return $jobs[0]['created'];
    }

    public function get_setting($tab, $name, $default = '') {
        if (empty($this->settings)) {
            self::load_settings();
        };
        //get and escape setting
        if (!isset($this->settings[$name])) {
            return $default;
        };

        $setting_val = $this->settings[$name];

        if (empty($setting_val) && ($setting_val != 0)) {
            return $default;
        } else {
            if (is_array($setting_val)) {
                return $setting_val;
            } else {
                return esc_attr($setting_val);
            }
        }
    }
    public function get_notification_emails() {
        return self::get_setting('', 'notify', null);
    }

    public function get_from_address() {
        return self::get_setting('', 'from_address', null);
    }

    public function get_from_name() {
        return self::get_setting('', 'from_name', null);
    }

    public function format_customer($customer) {

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
    public function format_table($data) {
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

    public function format_job($job) {
        $services = self::get_services();
        $this->services = $this->index_array_by_db_id($services);

        $vehicles = self::get_vehicles();
        $this->vehicles = $this->index_array_by_db_id($vehicles);
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
                if ($field['value'] != '') {
                    $out[] = $field;
                }
                break;
            case 'service_id':
                if (self::using_service_types($value)) {
                    $out[] = self::format_service_type($value);
                };
                break;
            case 'vehicle_id':
                if (self::using_vehicle_types($value)) {
                    $out[] = self::format_vehicle_type($value);
                };
                break;
            default:
                break;
            };
        };
        return $out;
    }

    public function index_array_by_db_id($array) {
        $indexed_array = array();
        foreach ($array as $key => $record) {
            $indexed_array[$record['id']] = $record;
        }
        return $indexed_array;
    }

    private function format_service_type($value) {
        $field = array('label' => 'Service');
        $service_name = '';
        if (isset($this->services[$value])) {
            $service_name = $this->services[$value]['name'];
        };
        $field['value'] = $service_name;
        return $field;
    }

    private function format_vehicle_type($value) {
        $field = array('label' => 'Vehicle');
        $vehicle_name = '';
        if (isset($this->vehicles[$value])) {
            $vehicle_name = $this->vehicles[$value]['name'];
        };
        $field['value'] = $vehicle_name;
        return $field;
    }

    public function format_journey($journey) {
        $distance_unit = self::get_distance_unit();
        //format for display in job details view
        $out = array();
        foreach ($journey as $key => $value) {
            //init new field
            $field = array();
            //include only label, value and template_id set to text incase needed for output
            switch ($key) {
            case 'distance':
                $field['label'] = 'Distance (' . $distance_unit . 's)';
                $field['value'] = $value;
                $out[] = $field;
                break;
            case 'time':
                $field['label'] = 'Estimated Travel Time (Hours)';
                $field['value'] = number_format((float) $value, 2, '.', '');
                $out[] = $field;
                break;
            };
        };
        return $out;
    }
    public function format_location($loc) {
        //format for display in customise forms
        $out = array();
        foreach ($loc as $key => $value) {
            //skip empty fields
            if (empty($value)) {
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
    public function format_quote($quote = null) {
        //format for display in job details view
        if (empty($quote)) {
            return false;
        };
        $currency = self::get_currency_code();
        $output_order = array('distance_cost', 'rate_hour', 'time_cost', 'rate_tax', 'tax_cost', 'total');
        $out = array();
        foreach ($output_order as $key => $field_name) {
            //init new field
            if (!isset($quote[$field_name])) {
                continue;
            };
            $field = array();
            $value = $quote[$field_name];
            //include only label, value and template_id set to text incase needed for output
            switch ($field_name) {
            case 'total':
                $field['label'] = 'Total (' . $currency . ')';
                $field['value'] = $value;
                $field['type'] = 'text';
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            case 'rate_tax':
                $field['label'] = 'Tax Rate (%)';
                $field['value'] = $value;
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            case 'tax_cost':
                $field['label'] = 'Tax (' . $currency . ')';
                $field['value'] = $value;
                $field['type'] = 'text';
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            case 'rate_per_unit':
                break;
            case 'distance_cost':
                $field['label'] = 'Distance Cost (' . $currency . ')';
                $field['value'] = $value;
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            case 'notice_cost':
                if ($value != 0) {
                    $field['label'] = 'Short Notice Cost';
                    $field['value'] = $currency . ' ' . $value;
                    $field['update'] = 'quote';
                    $field['name'] = $field_name;
                    $out[] = $field;
                }
                break;
            case 'rate_hour':
                $field['label'] = 'Hourly Rate';
                $field['value'] = $value;
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            case 'time_cost':
                $field['label'] = 'Time Cost  (' . $currency . ')';
                $field['value'] = $value;
                $field['type'] = 'text';
                $field['update'] = 'quote';
                $field['name'] = $field_name;
                $out[] = $field;
                break;
            };

        };
        return $out;
    }

    public function using_service_types($value) {
        if (empty($value)) {
            return false;
        };
        return true;
    }

    public function using_vehicle_types($value) {
        if (empty($value)) {
            return false;
        };
        return true;
    }

    public function render_route_details($waypoints) {
        $route_row_data = array();
        foreach ($waypoints as $key => $waypoint) {
            $route_row_data[] = array('value' => $this->format_waypoint($waypoint));
        };

        return $this->job_details_table('<h3>Route</h3>', $route_row_data);
    }

    public function route_details_list() {
        $route_row_data = array();
        foreach ($this->locations_in_journey_order as $key => $waypoint) {
            switch ($waypoint['journey_order']) {
            case '0':
                $route_row_data[] = array('value' => 'Collect From:');
                $route_row_data[] = array('value' => $this->format_waypoint_list($waypoint));
                break;
            default:
                $route_row_data[] = array('value' => 'Drop Off:');
                $route_row_data[] = array('value' => $this->format_waypoint_list($waypoint));
                break;
            }

        };

        return $this->email_details_list('Route', $route_row_data);
    }

    public function email_details_list($header, $data) {
        //return job details info in list for text email
        $text = $header . "\r\n\r\n";
        $rows = array();
        foreach ($data as $field) {
            if (!empty($field['value'])) {
                if (empty($field['label'])) {
                    $rows[] = $field['value'];
                } else {
                    $rows[] = $field['label'] . ': ' . $field['value'];
                }
            }
        };
        $text .= implode("\r\n", $rows);
        echo $text . "\r\n";
    }

    private function format_waypoint($waypoint) {
        $html = '<ul>';
        if (!empty($waypoint['appartment_no'])) {
            $html .= '<li>' . self::get_setting('tq_pro_form_options', 'unit_no_label', 'Unit No') . ':' . $waypoint['appartment_no'] . '</li>';
        };
        $html .= '<li>Address: ' . stripslashes($waypoint['address']) . '</li>';
        if (!empty($waypoint['postal_code'])) {
            $html .= '<li>Postcode: ' . $waypoint['postal_code'] . '</li>';
        };
        if (!empty($waypoint['contact_name'])) {
            $html .= '<li>Contact Name: ' . $waypoint['contact_name'] . '</li>';
        };
        if (!empty($waypoint['contact_phone'])) {
            $html .= '<li>Contact Phone: ' . $waypoint['contact_phone'] . '</li>';
        };
        $html .= '</ul>';

        return $html;
    }

    private function format_waypoint_list($waypoint, $html = false) {
        if ($html === true) {
            $line_ending = "<br/><br/>";
        } else {
            $line_ending = "\r\n";
        }
        $text = "";
        if (!empty($waypoint['location']['appartment_no'])) {
            $text .= self::get_setting('tq_pro_form_options', 'unit_no_label', 'Unit No') . ": " . $waypoint['location']['appartment_no'] . $line_ending;
        };
        $text .= "Address: " . stripslashes($waypoint['location']['address']) . $line_ending;
        if (!empty($waypoint['location']['postal_code'])) {
            $text .= "Postcode: " . $waypoint['location']['postal_code'] . $line_ending;
        };
        if (!empty($waypoint['contact_name'])) {
            $text .= "Contact Name: " . $waypoint['contact_name'] . $line_ending;
        };
        if (!empty($waypoint['contact_phone'])) {
            $text .= "Contact Phone: " . $waypoint['contact_phone'] . $line_ending;
        };

        return $text;
    }

    public function render_journey_length_options($selected_id = 1) {
        // get list of services from db
        $journey_lengths = $this->get_journey_lengths();
        return $this->render_select_options($journey_lengths, $selected_id);
    }

    public function get_journey_lengths() {
        //return services which have rates set
        $journey_lengths = $this->cdb->get_rows('journey_lengths', array(), array('id', 'distance as name'), array(), array('distance' => 'asc'));
        return $journey_lengths;
    }

    public function render_service_options($selected_id = 1) {
        // get list of services from db
        $services = $this->get_services();
        return $this->render_select_options($services, $selected_id);
    }

    public function render_service_options_with_rates($selected_id = 1) {
        // get list of services from db
        $services = $this->get_services_with_rates();
        return $this->render_select_options($services, $selected_id);
    }

    public function render_vehicle_options($selected_id = 1) {
        // get list of vehicles from db
        $vehicles = $this->get_vehicles();
        return $this->render_select_options($vehicles, $selected_id);
    }

    public function render_vehicle_options_with_rates($selected_id = 1) {
        // get list of vehicles from db
        $vehicles = $this->get_vehicles_with_rates();
        return $this->render_select_options($vehicles, $selected_id);
    }

    public function render_select_options($options = null, $selected_id = null) {
        if (empty($options)) {
            return false;
        };

        if (!is_array($options)) {
            return false;
        };

        // loop through list
        foreach ($options as $key => $option) {
            // set selected attribute if item is selected
            $selected = ($option['id'] == $selected_id) ? 'selected="selected" ' : '';
            echo '<option value="' . $option['id'] . '" ' . $selected . '>' . $option['name'] . '</option>';
        }
    }

    private function using_vehicle_links() {
        $using_link = self::get_setting('tq_pro_form_options', 'show_vehicle_link', false);
        if ($using_link == 1) {
            return true;
        };
        return false;
    }
    private function using_service_links() {
        $using_link = self::get_setting('tq_pro_form_options', 'show_service_link', false);
        if ($using_link == 1) {
            return true;
        };
        return false;
    }

    public function using_service_descript() {
        $using_service_descript = self::get_setting('tq_pro_form_options', 'show_service_description', false);
        if ($using_service_descript == 1) {
            return true;
        };
        return false;
    }

    public function using_vehicle_descript() {
        $vehicle_descript = self::get_setting('tq_pro_form_options', 'show_vehicle_description', false);
        if ($vehicle_descript == 1) {
            return true;
        };
        return false;
    }

    private function build_vehicle_link($vehicle) {
        $page_name = self::format_string_for_url($vehicle['name']);
        $link_text = $this->view_labels['view_vehicle_link_text'];
        return '<a target="_blank" href="/' . $page_name . '">' . $link_text . '</a>';

    }

    private function build_service_link($service) {
        $page_name = self::format_string_for_url($service['name']);
        $link_text = $this->view_labels['view_service_link_text'];
        return '<a target="_blank" href="/' . $page_name . '">' . $link_text . '</a>';

    }

    public function format_string_for_url($string) {
        $string = self::remove_spaces($string);
        $string = self::strip_non_alphanum($string);
        $url_friendly = strtolower($string);
        return $url_friendly;

    }

    public function remove_spaces($string) {
        return str_replace(' ', '', $string);
    }

    public function strip_non_alphanum($string) {
        return preg_replace("/[^A-Za-z0-9 ]/", '', $string);
    }

    public function update_job_status($job_id, $status_type_id) {
        if (empty($job_id)) {
            return false;
        };

        if (empty($status_type_id)) {
            return false;
        };

        $this->job = self::get_job($job_id);

        $this->job['status_type_id'] = $status_type_id;
        $success = self::save_record('jobs', $this->job);
        if ($success === false) {
            return false;
        }

        //get details for the job
        $this->job = self::get_job_details($this->job);

        //status updated ok, send email
        $subject = self::get_status_subject($status_type_id, $job_id);
        $notify = false;
        if ($this->job['status_type_id'] !== 1) {
            $notify = true;
        };
        self::email_dispatch($subject, $notify);

        return true;
    }

    function set_content_type($content_type) {
        return 'text/html';
    }

    private function get_status_subject($status_type_id = null, $job_id = null) {
        if (empty($job_id)) {
            //use current job if none is passed
            $job = $this->job;
        } else {
            //get job for passed id
            $job = self::get_job($job_id);
        };

        if (empty($job)) {
            //job id not valide
            return false;
        };
        $this->status_types = self::get_status_types();
        $status_type_rec = self::get_status_type($status_type_id);
        if (empty($status_type_rec)) {
            //status type
            return false;
        };

        //create email subject
        $customer = trim($this->customer['first_name'] . " " . $this->customer['last_name']);

        $subject = 'Delivery for ' . $customer . ' ' . $status_type_rec['name'];

        return $subject;
    }

    private function get_status_type($status_type_id = null) {
        //get the status type record for an id
        if (empty($status_type_id)) {
            return false;
        };
        if (empty($this->status_types[$status_type_id])) {
            return false;
        };
        return $this->status_types[$status_type_id];
    }

    private function get_status_types() {
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
    public function update_payment_status_id($job_id, $payment_status_id) {
        if (empty($job_id)) {
            self::debug('update_payment_status_id: No job_id');
            return false;
        };

        if (empty($payment_status_id)) {
            self::debug('payment_status_id: No payment_status_id');
            return false;
        };

        // update the payment status to the selected type in the db and update the job object
        $this->job = $this->cdb->update_field('jobs', 'payment_status_id', $payment_status_id, $job_id);
        if ($this->job === false) {
            return false;
        };
        return true;

    }

    /**
     * Update Payment Type Column in jobs
     *
     * @since    1.0.0
     */
    public function update_payment_type_id($job_id, $payment_type_id) {
        if (empty($job_id)) {
            self::debug('update_payment_type_id: No job_id');
            return false;
        };

        if (empty($payment_type_id)) {
            self::debug('update_payment_type_id: No update_payment_type_id');
            return false;
        };

        // update the payment status to the selected type in the db and update the job object
        $this->job = $this->cdb->update_field('jobs', 'payment_type_id', $payment_type_id, $job_id);
        if ($this->job === false) {
            return false;
        };
        return true;

    }

    /**
     * Delete rates there there is no vehicle or service id
     *
     * @since    4.1.3
     */

    public function delete_orphaned_rates() {
        $rates_table_name = $this->cdb->get_table_full_name('rates');
        $services_table_name = $this->cdb->get_table_full_name('services');
        $vehicle_table_name = $this->cdb->get_table_full_name('vehicles');
        $journey_lengths_table_name = $this->cdb->get_table_full_name('journey_lengths');

        // get ordered list of rates with distance 0 as the final record
        $sql = "delete r
				 from " . $rates_table_name . " r
					left join " . $vehicle_table_name . " v
						on r.vehicle_id = v.id
					left join " . $services_table_name . " s
						on r.service_id = s.id
					left join " . $journey_lengths_table_name . " jl
						on r.journey_length_id = jl.id
					where v.id is null or s.id is null or jl.id is null;";
        //echo $sql;
        $success = $this->cdb->query($sql);
        return $success;
    }
    public function booking_details_add_my_account_orders_column($columns) {
        $form_section_order = self::get_setting('pro_settings_quote_options', 'select_page_my_quotes', 'post_title');
        $new_columns = array();

        foreach ($columns as $key => $name) {
            $new_columns[$key] = $name;

            // add ship-to after order status column
            if ('order-status' === $key) {
                $new_columns['booking_details'] = __('Booking Details', 'textdomain');
            }

        }
        if ($form_section_order !== "post_title") {
            return $new_columns;
        }
    }
    public function booking_details_to_column($order) {

        $order_id = $order->get_id();
        $order = wc_get_order($order_id);
        $job_id = $order->get_meta('job_id');
        if (!$job_id) {
            return;
        }
        $form_section_order = self::get_setting('pro_settings_quote_options', 'select_page_my_quotes', 'post_title');

        $site_url = get_permalink($form_section_order);
        $site_url .= '?job_id=' . $job_id;

        $html = '<a href="%s">%s</a>';
        echo sprintf($html, $site_url, $site_url);

    }
    public function tq_form_css() {
        $form_header_color = self::get_setting('tq_pro_form_options', 'form_header_color', '#5e5e5e');
        $title_background_color = self::get_setting('tq_pro_form_options', 'title_background_color', '#e8e8e8');
        $form_text_color = self::get_setting('tq_pro_form_options', 'form_color', '#3e80fa');
        $form_background_color = self::get_setting('tq_pro_form_options', 'form_background_color', '#fbfbfb');
        echo "
			<style>
				.requestform form#quote-form.tq-form.tq-primary-color{
					color: $form_text_color !important;
				}
				.requestform form#quote-form.tq-form .tq-form-title-color{
					background-color: $title_background_color !important;
				}
				.requestform form#quote-form.tq-form .tq-form-bg-color{
					background-color: $form_background_color !important;
				}

				.requestform form#quote-form button.tq-button,
				.woocommerce a.button,
				.woocommerce button.button  {
					background-color:  $form_text_color !important;
					color: $form_background_color !important;
				}
			</style>";
    }

    /*
    Return cdb config to be used in any extentions if added
     */
    public function return_main_cdb_config($cdb) {
        $cdb->tables = array_merge($cdb->tables, $this->cdb->tables);
        return $cdb;
    }

}
