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
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
class TransitQuote_Pro_Settings_Field_Radio {


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
            $this->fields[$key] = new TransitQuote_Pro_Settings_Field($field_config);
            $this->fields[$key]->add_field();
        }
    }

    public function render(){

    }

}
