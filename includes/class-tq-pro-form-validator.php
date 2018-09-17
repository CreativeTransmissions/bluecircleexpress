<?php

/**
 * Define Calculation functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      3.0.0
 * @package    TQ_FormData
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
namespace TransitQuote_Pro4;
class TQ_FormValidator {

 	private $default_config = array('required_fields'=>array()); 
 	private $empty_fields = array();
 	private $missing_fields = array();
 	private $invalid_fields = array();
 	private $required_fields = array();

    public function __construct($config = array()) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
		$this->init_properties();
		$this->get_post_data();
		$this->get_get_data();
	}

	private function init_properties(){
		$this->required_fields = $this->config['required_fields'];
	}

	private function get_post_data(){
		$this->post_data = $_POST;
	}

	private function get_get_data(){
		$this->get_data = $_GET;
	}

	public function get_required_fields(){
		return $this->required_fields;
	}

		
	public function has_get_field($field_name){
		return isset($this->get_data[$field_name]);
	}

	public function has_post_field($field_name){
		return isset($this->post_data[$field_name]);
	}

	public function has_required_post_fields(){
		$has_all_fields = true;
		foreach ($this->config['required_fields'] as $key => $field_name) {
			if(self::has_post_field($field_name)){
				if(!self::post_field_has_value($field_name)){
					array_push($this->invalid_fields,$field_name);
					$has_all_fields = false;
				};
			} else {
				array_push($this->missing_fields,$field_name);
				$has_all_fields = false;
			};
		};
		return $has_all_fields;
	}

	public function has_required_get_fields(){
		$has_all_fields = true;
		foreach ($this->config['required_fields'] as $key => $field_name) {
			if(self::has_get_field($field_name)){
				if(!self::get_field_has_value($field_name)){
					array_push($this->invalid_fields,$field_name);
					$has_all_fields = false;
				};
			} else {
				array_push($this->missing_fields,$field_name);
				$has_all_fields = false;
			};
		};
		return $has_all_fields;
	}

	public function get_field_has_value($field_name){
		return !empty($this->get_data[$field_name]);
	}

	public function post_field_has_value($field_name){
		return !empty($this->post_data[$field_name]);
	}

	public function get_error_messages(){
		$error_list = array();

		$missing_field_error_messages =  $this->get_missing_field_error_messages();
		$invalid_field_error_messages = $this->get_invalid_field_error_messages();
		$error_list = array_merge($invalid_field_error_messages, $missing_field_error_messages);
		return $error_list;
	}

	public function get_missing_field_error_messages(){
		$error_list = array();
		foreach ($this->missing_fields as $key => $field_name) {
			$error_list[] = array(	'name'=>$field_name,
											'error'=>'Missing');
		};
		return $error_list;
	}	

	public function get_invalid_field_error_messages(){
		$error_list = array();
		foreach ($this->invalid_fields as $key => $field_name) {
			$error_list[] = array('name'=>$field_name,
									'error'=>'Empty');
		};
		return $error_list;
	}
}

