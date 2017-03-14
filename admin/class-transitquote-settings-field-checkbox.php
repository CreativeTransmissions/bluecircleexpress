<?php

/**
 * Define Admin Tab functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 * @author     Your Name <email@example.com>
 */
class TransitQuote_Premium_Settings_Field_Checkbox {


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
            $field_config['page'] = $this->tab_key;
            $field_config['admin'] = $this->admin;
            $field_config['section_id'] = $this->section_id;
            $this->fields[$key] = new TransitQuote_Premium_Settings_Field($field_config);
            $this->fields[$key]->add_field();
        }
    }

    public function render(){
    	echo  'Section: '.$this->section_id;
    }

}
