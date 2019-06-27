<?php

/**
 * Define Admin Tab functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/admin
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
class TransitQuote_Pro_Settings_Section {


	public function __construct($config = null) {
		$this->config = $config;
		$this->section_id = $this->config['id'];
		$this->admin = $this->config['admin'];
		$this->cdb = $this->admin->cdb;
        $this->page = $this->config['page'];
        $this->fields = array();
	}

	public function add_section(){
    	//register an admin tab from a config array
    	if(empty($this->config)){
    		return false;
    	};
          //          print_r($this->config);
    	add_settings_section($this->section_id,
                             $this->config['title'],
                             array( $this, 'render' ),
                             $this->config['page']);

        if(isset($this->config['fields'])){
            $this->register_fields();
        };
    }

    private function register_fields(){

        foreach ($this->config['fields'] as $key => $field_config) {
            $field_config['page'] = $this->page;
            $field_config['admin'] = $this->admin;
            $field_config['section_id'] = $this->section_id;
            switch ($field_config['type']) {
                case 'addresspicker':
                    if($this->admin->has_gmaps_api_key()){
                         $field = new TransitQuote_Pro_Settings_Field_AddressPicker($field_config);
                    };
                    break;
                case 'checkbox':
                    $field = new TransitQuote_Pro_Settings_Field_Checkbox($field_config);
                    break;
                case 'checkgroup':
                    $field = new TransitQuote_Pro_Settings_Field_Check_Group($field_config);
                    break;                    
                case 'input':
                    $field = new TransitQuote_Pro_Settings_Field_Input($field_config);
                    break;
                case 'number':
                    $field = new TransitQuote_Pro_Settings_Field_Input_Number($field_config);
                    break;                    
                case 'radio':
                    $field = new TransitQuote_Pro_Settings_Field_Radio($field_config);
                    break;
                case 'select':
                    $field = new TransitQuote_Pro_Settings_Field_Select($field_config);
                    break;
                case 'textarea':
                    $field = new TransitQuote_Pro_Settings_Field_Textarea($field_config);
                    break;
            };
            
            if(!method_exists($field, 'add_field')){
                echo 'no method: '.$key;
            } else {
                $field->add_field();
            }
           
            
        }
    }

    public function render(){

    }

}
